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
                    @if ($shop_pay_commission_request->state === 'pending')
                        <div class="d-flex justify-content-end align-items-center">
                            <form id='approveForm'>
                                <input type="hidden" name="id" value="{{ $shop_pay_commission_request->id }}">
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
                    {{ trans('custom.shop_pay_commission_request_informations') }}
                </div>
                <div class="card-body">
                    <div class="">
                        <div>
                            <span class="font-weight-bold">
                                {{ trans('custom.amount') }} :
                            </span>
                            <span>
                                {{ $shop_pay_commission_request->amount }}
                            </span>
                        </div>
                        <div>
                            <span class="font-weight-bold">
                                {{ trans('custom.creaated_at') }} :

                            </span>
                            <span>
                                {{ $shop_pay_commission_request->created_at }}
                            </span>
                        </div>
                        <div>
                            <span class="font-weight-bold">
                                {{ trans('custom.shop_name') }} :
                            </span>
                            <span>
                                {{ $shop_pay_commission_request->offer->shop->getTranslation('name') }}
                            </span>
                        </div>
                        <div>
                            <span class="font-weight-bold">
                                {{ trans('custom.offer_name') }} :

                            </span>
                            <span>
                                {{ $shop_pay_commission_request->offer->getTranslation('name') }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-6">
            <div class="card">
                <div class="card-header">
                    {{ trans('custom.shop_pay_commission_request_offer_informations') }}
                </div>
                <div class="card-body">
                    <div class="">
                        <span class="font-weight-bold">{{ trans('custom.full_name') }} :</span>
                        <span> 
                            {{ $shop_pay_commission_request->sender_full_name }} </span>
                    </div>
                    <div class="">
                        <span class="font-weight-bold">{{ trans('custom.phone') }} :</span>
                        <span>{{ $shop_pay_commission_request->sender_phone }}</span>
                    </div>
                    <div class="">
                        <span class="font-weight-bold">{{ trans('custom.notice') }} :</span>
                        <span>{{ $shop_pay_commission_request->notice }}</span>
                    </div>

                </div>
            </div>
        </div>
    </div>


    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header">
                    {{ trans('custom.attachments') }}
                </div>
                <div class="card-body">
                    <div class="row">
                        @foreach ($shop_pay_commission_request->attachments as $attachment)
                            <div class="col-sm-6">
                                <img class="img-fluid" src="{{ getFileUrl($attachment->upload_id) }}">
                            </div>
                        @endforeach
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
                    var url = "{{ route('shop_commission_payment.update', ['id' => ':id']) }}";
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
