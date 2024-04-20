@extends('layouts.app')

{{-- Customize layout sections --}}

@section('subtitle', 'Welcome')
@section('content_header_title', 'Home')
@section('content_header_subtitle', 'Welcome')

{{-- Content body: main page content --}}

@section('content_body')
    <div class="row">
        <div class="col-sm-6">
            <div class="card">
                <div class="card-body">

                </div>
            </div>
        </div>
        <div class="col-sm-6">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-end align-items-center">
                        <form id='approveForm'>
                            <input type="hidden" name="id" value="{{ $approval_request->id }}">
                            <button class="btn btn-primary mx-2 actionBtn" data-action='approve'>{{ trans('custom.approve') }}</button>
                            {{ csrf_field() }}
                        </form>
                        <button class="btn btn-danger actionBtn" data-action='reject'>{{ trans('custom.reject') }}</button>
                    </div>

                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-6">
            <div class="card">
                <div class="card-body">

                </div>
            </div>
        </div>
    </div>



@stop

{{-- Push extra CSS --}}

@push('css')
    {{-- <link rel="stylesheet" href="/css/admin_custom.css"> --}}

    {{-- Add here extra stylesheets --}}
@endpush

{{-- Push extra scripts --}}

@push('js')
    <script>
        $(document).on('click', '.actionBtn', function() {

            event.preventDefault();
            var action=$(this).data('action');
            Swal.fire({
                title: action ==='approve' ? '{{trans("custom.sw_title_approve_ap_request")}}' : '{{trans("custom.sw_title_reject_ap_request")}}',
                showDenyButton: true,
                confirmButtonText: '{{trans("custom.yes")}}',
                denyButtonText: '{{trans("custom.no")}}',
                customClass: {
                    actions: 'my-actions',
                    cancelButton: 'order-1 right-gap',
                    confirmButton: 'order-2',
                    denyButton: 'order-3',
                },
            }).then((result) => {
                if (result.isConfirmed) {

                    var data = {
                        id: $('input[name=id]').val(),
                        action,
                        _token:$('meta[name="c_token"]').attr("content")
                    };
                    $.ajax({
                        url: "{{ route('approval.handle') }}",
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


@section('plugins.Sweetalert2', true)
