@extends('layouts.app')

{{-- Customize layout sections --}}

@section('subtitle', 'Welcome')
@section('content_header_title', trans('custom.home'))
@section('content_header_subtitle', __('custom.withdraw_balance_request'))

{{-- Content body: main page content --}}

@section('content_body')
    <div class="card">
        <div class="card-body">

            <div class="">
                <button id="in_progress_btn" class="btn btn-info"
                    disabled>{{ trans('custom.change_status_to_in_progress_and_export_as_csv') }}</button>
                <button id="approved_btn" class="btn btn-success"
                    disabled>{{ trans('custom.change_status_to_approved') }}</button>

            </div>
 
            <table id="example" class="table" style="width:100%">
                <thead>
                    <th>
                        <input type="checkbox" id="selectAll" />
                    </th>
                    <th>
                        {{ trans('custom.customer_name') }}
                    </th>
                    <th>
                        {{ trans('custom.amount') }}
                    </th>
                    <th>
                        {{ trans('custom.bank_name') }}
                    </th>
                    <th>
                        {{ trans('custom.full_name') }}
                    </th>
                    <th>
                        {{ trans('custom.iban') }}
                    </th>
                    <th>
                        {{ trans('custom.account_number') }}
                    </th>
                    <th>
                        {{ trans('custom.status') }}
                    </th>
                    <th>
                        {{ trans('custom.action') }}
                    </th>
                </thead>
                <tbody>
                    @foreach ($users_withdraw_requests as $users_withdraw_request)
                        {{-- {{$users_withdraw_request->BankAccount->bank_name}} --}}
                        <tr>
                            <td>
                                <input type="checkbox" name="request_item" class="request_item"
                                    value="{{ $users_withdraw_request->id }}"
                                    data-state="{{ $users_withdraw_request->state }}">
                            </td>
                            <td>
                                {{ $users_withdraw_request->user->first_name }}
                                {{ $users_withdraw_request->user->last_name }}
                            </td>
                            <td>
                                {{ $users_withdraw_request->amount }}
                            </td>
                            <td>
                                {{ $users_withdraw_request->BankAccount->bank_name }}
                            </td>
                            <td>
                                {{ Illuminate\Support\Facades\Crypt::decryptString($users_withdraw_request->BankAccount->full_name) }}
                            </td>
                            <td>
                                {{ Illuminate\Support\Facades\Crypt::decryptString($users_withdraw_request->BankAccount->iban) }}
                            </td>
                            <td>
                                {{ Illuminate\Support\Facades\Crypt::decryptString($users_withdraw_request->BankAccount->account_number) }}
                            </td>
                            <td>
                                {{ $users_withdraw_request->state }}
                            </td>
                            <td>
                                <a href="{{ route('user_withdraw_balance_request.show', ['id' => $users_withdraw_request->id]) }}" class="btn btn-primary"><i class="fas fa-eye"></i></a>
                                <button data-id="{{ $users_withdraw_request->id }}" class="btn btn-danger reject_btn"><i class="fas fa-trash"></i></button>

                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>


@stop

{{-- Push extra CSS --}}

@push('css')
    {{-- Add here extra stylesheets --}}
    {{-- <link rel="stylesheet" href="/css/admin_custom.css"> --}}
@endpush

{{-- Push extra scripts --}}

@push('js')
    <script>
        $(document).ready(function() {


            


            function checkCheckboxesAndEnableButton() {

                var isChecked = $('.request_item:checked').length > 0;
                var checkedPending = $('.request_item:checked[data-state="pending"]').length > 0;
                var checkedInProgress = $('.request_item:checked[data-state="in_progress"]').length > 0;


                // Initialize flags
                var allPending = isChecked && checkedPending && !checkedInProgress;
                var allInProgress = isChecked && !checkedPending && checkedInProgress;


                $('#in_progress_btn').prop('disabled', !allPending);
                $('#approved_btn').prop('disabled', !allInProgress);
            }

            $('.request_item').change(checkCheckboxesAndEnableButton);

            $('#in_progress_btn').click(function() {
                var ids = [];
                $('.request_item:checked').each(function() {
                    ids.push($(this).val());
                });
                $.ajax({
                    method: "POST",
                    url: "{{ route('user_withdraw_balance_request.update_bulk') }}",
                    data: {
                        request_ids: ids,
                        status: 'pending',
                        _token: $('meta[name="c_token"]').attr("content"),
                    },
                    xhrFields: {
                        responseType: 'blob'
                    },
                    success: function(response) {
                        const currentDate = new Date().toISOString().replace(/:/g, '-');
                        const fileName = `user_balance_withdraw_requests-${currentDate}.csv`;
                        var a = document.createElement('a');
                        var url = window.URL.createObjectURL(response);
                        a.href = url;
                        a.download = fileName;
                        document.body.append(a);
                        a.click();
                        a.remove();
                        window.URL.revokeObjectURL(url);
                        setTimeout(() => {
                            window.location.reload();
                        }, 2200);
                    }

                })
            });

            $('#approved_btn').click(function() {

                var ids = [];
                $('.request_item:checked').each(function() {
                    ids.push($(this).val());
                });
                $.ajax({
                    method: "POST",
                    url: "{{ route('user_withdraw_balance_request.update_bulk') }}",
                    data: {
                        request_ids: ids,
                        status: 'in_progress',
                        _token: $('meta[name="c_token"]').attr("content"),
                    },
                    success:function(response) {
                        if (response.success) {
                            toastr["success"](response.message);
                            setTimeout(() => {
                                window.location.reload();
                            }, 1500);
                        } else {
                            toastr["error"](response.message);
                        }
                    }
                });


            });

            $('.reject_btn').click(function() {

                event.preventDefault();
                var id = $(this).data('id');
                Swal.fire({
                    title:  '{{ trans('custom.sw_title_reject_ap_request') }}',
                    input: 'textarea',
                    showDenyButton: true,
                    confirmButtonText: '{{ trans('custom.yes') }}',
                    denyButtonText: '{{ trans('custom.no') }}',
                    customClass: {
                        actions: 'my-actions',
                        cancelButton: 'order-1 right-gap',
                        confirmButton: 'order-2',
                        denyButton: 'order-3',
                    },
                }).then((result) => {
                    console.log(result);
                    if (result.isConfirmed) {

                        var data = {
                            id: [id],
                            _token: $('meta[name="c_token"]').attr("content")
                        };
                        // $.ajax({
                        //     url: "{{ route('approval.handle') }}",
                        //     data,
                        //     method: 'POST',
                        //     success: function(response) {
                        //         // Handle the response here
                        //         if (response.success) {
                        //             toastr["success"](response.message);

                        //             setTimeout(() => {
                        //                 window.location.href = response
                        //                     .action_val
                        //             }, 1500)
                        //         } else {
                        //             toastr["error"](response.message);
                        //         }
                        //     },
                        //     error: function(response) {
                        //         if (response.status == 422) {
                        //             $.each(response.responseJSON.errors, function(key,
                        //                 errorsArray) {
                        //                 $.each(errorsArray, function(item,
                        //                     error) {
                        //                     toastr["error"](error);
                        //                 });
                        //             });
                        //         } else {
                        //             toastr["error"]('somthing went wrong');
                        //         }
                            // }
                        // })

                        // Swal.fire('Saved!', '', 'success')
                    } else if (result.isDenied) {
                        // Swal.fire('Changes are not saved', '', 'info')
                    }
                });
            })


            $('#selectAll').on('change', function() {
                $('input[name="request_item"]').prop('checked', $(this).is(':checked'));
                checkCheckboxesAndEnableButton();
            });


        });
    </script>
    <script>
        new DataTable('#example', {
            info: false,
            ordering: false,
            paging: false
        });
    </script>
@endpush


@section('plugins.Datatables', true)
