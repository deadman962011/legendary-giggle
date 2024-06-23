@extends('layouts.app')

{{-- Customize layout sections --}}

@section('subtitle', 'Welcome')
@section('content_header_title', 'Home')
@section('content_header_subtitle', 'Welcome')

{{-- Content body: main page content --}}

@section('content_body')
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-body">
                    @if ($users_withdraw_request->state === 'pending')
                        <div class="d-flex justify-content-end align-items-center">
                            <form id='approveForm'>
                                <input type="hidden" name="id" value="{{ $users_withdraw_request->id }}">
                                <button class="btn btn-primary mx-2 actionBtn"
                                    data-action='approve'>{{ trans('custom.approve') }}</button>
                                {{ csrf_field() }}
                            </form>
                            <button class="btn btn-danger actionBtn"
                                data-action='reject'>{{ trans('custom.reject') }}</button>
                        </div>
                    @endif

                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-6">
            <div class="card">
                <div class="card-header">

                    {{ trans('custom.withdraw_balance_request_informations') }}
                </div>
                <div class="card-body">
                    <div class="">
                        <div>
                            <span class="font-weight-bold">
                                {{ trans('custom.amount') }} :

                            </span>
                            <span>
                                {{ $users_withdraw_request->amount }}
                            </span>
                        </div>
                        <div>
                            <span class="font-weight-bold">
                                {{ trans('custom.created_at') }} :

                            </span>
                            <span>
                                {{ $users_withdraw_request->created_at }}
                            </span>
                        </div>



                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-6">
            <div class="card">
                <div class="card-header">

                    {{ trans('custom.withdraw_balance_request_user_informations') }}
                </div>
                <div class="card-body">
                    <div class="">
                        <span class="font-weight-bold">{{ trans('custom.full_name') }}</span>
                        <span>{{ $users_withdraw_request->user->first_name }}
                            {{ $users_withdraw_request->user->last_name }} </span>
                    </div>
                    <div class="">
                        <span class="font-weight-bold">{{ trans('custom.email') }}</span>
                        <span>{{ $users_withdraw_request->user->email }}</span>
                    </div>
                    {{-- <div class="">
                        <span class="font-weight-bold">{{ trans('custom.phone') }}</span>
                        <span>{{ $users_withdraw_request->user->phone }}</span>
                    </div> --}}

                </div>
            </div>
        </div>
    </div>


    <div class="row">
        <div class="col-sm-6">
            <div class="card">
                <div class="card-header">

                    {{ trans('custom.withdraw_balance_request_user_bank_account_informations') }}
                </div>
                <div class="card-body">
                    <div class="">

                        <div>
                            <span class="font-weight-bold">
                                {{ trans('custom.bank_account') }} :

                            </span>
                            <span>
                                {{ $users_withdraw_request->BankAccount->bank_name }}
                            </span>
                        </div>

                        <div>
                            <span class="font-weight-bold">
                                {{ trans('custom.full_name') }} :

                            </span>
                            <span>
                                {{ Illuminate\Support\Facades\Crypt::decryptString($users_withdraw_request->BankAccount->full_name) }}
                            </span>
                        </div>
                        <div>
                            <span class="font-weight-bold">
                                {{ trans('custom.iban') }} :

                            </span>
                            <span>
                                {{ Illuminate\Support\Facades\Crypt::decryptString($users_withdraw_request->BankAccount->iban) }}
                            </span>
                        </div>
                        <div>
                            <span class="font-weight-bold">
                                {{ trans('custom.account_number') }} :

                            </span>
                            <span>
                                {{ Illuminate\Support\Facades\Crypt::decryptString($users_withdraw_request->BankAccount->account_number) }}
                            </span>
                        </div>



                    </div>
                </div>
            </div>
        </div>

    </div>







@stop

{{-- Push extra CSS --}}

@push('css')
    <style>
        .gm-style-iw.gm-style-iw button {
            display: none !important;
        }
    </style>
@endpush

{{-- Push extra scripts --}}

@push('js')
    <script>
        $(document).on('click', '.actionBtn', function() {

            event.preventDefault();
            var action = $(this).data('action');


            // var modalBody = '<div class="row gutters-5"><div class="col-md-8"><div class="form-group"><div class="input-group" data-toggle="aizuploader" data-type="image"><div class="input-group-prepend"><div class="input-group-text bg-soft-secondary font-weight-medium">{{ __('custom.browse') }}</div></div><div class="form-control file-amount">{{ trans('custom.choose_file') }}</div><input type="hidden" name="slider_images[]" class="selected-files"></div><div class="file-preview box sm"></div></div></div></div>'
            // var modalBody = '<textarea name="" class="form-control"></textarea>'



            Swal.fire({
                title: action === 'approve' ? '{{ trans('custom.sw_title_approve_ap_request') }}' :
                    '{{ trans('custom.sw_title_reject_ap_request') }}',
                // input: 'textarea',
                // html:modalBody,
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
                if (result.isConfirmed) {

                    var data = {
                        action,
                        _token: $('meta[name="c_token"]').attr("content")
                    };

                    var itemId = $('input[name=id]').val()
                    var url = "{{ route('user_withdraw_balance_request.update', ['id' => ':id']) }}";
                    url = url.replace(':id', itemId)

                    $.ajax({
                        url,
                        data,
                        method: 'POST',
                        success: function(response) {
                            // Handle the response here
                            if (response.success) {
                                toastr["success"](response.message);

                                setTimeout(() => {
                                    window.location.href = response.action_val
                                }, 1500)
                            } else {
                                toastr["error"](response.message);
                            }
                        },
                        error: function(response) {
                            if (response.status == 422) {
                                $.each(response.responseJSON.errors, function(key,
                                    errorsArray) {
                                    $.each(errorsArray, function(item, error) {
                                        toastr["error"](error);
                                    });
                                });
                            } else {
                                toastr["error"]('somthing went wrong');
                            }
                        },
                    })

                    // Swal.fire('Saved!', '', 'success')
                } else if (result.isDenied) {
                    // Swal.fire('Changes are not saved', '', 'info')
                }
            })
        })
    </script>
@endpush
