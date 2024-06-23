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
                    <div class="d-flex justify-content-end align-items-center">
                        <form id='approveForm'>
                            <input type="hidden" name="id" value="{{ $approval_request->id }}">
                            <button class="btn btn-primary mx-2 actionBtn"
                                data-action='approve'>{{ trans('custom.approve') }}</button>
                            {{ csrf_field() }}
                        </form>
                        <button class="btn btn-danger actionBtn" data-action='reject'>{{ trans('custom.reject') }}</button>
                    </div>

                </div>
            </div>
        </div>
    </div>
    @if ($approval_request->model === 'shop')
        @include('approval.parts.shop')
    @endif
    @if ($approval_request->model === 'offer')
        @include('approval.parts.offer')
    @endif
@stop

{{-- Push extra CSS --}}


@push('css')

    @if ($approval_request->model === 'shop')
        <style>
            .gm-style-iw.gm-style-iw button {
                display: none !important;
            }
        </style>
    @endif
@endpush




{{-- Push extra scripts --}}

@push('js')
    <script>
        $(document).on('click', '.actionBtn', function() {

            event.preventDefault();
            var action = $(this).data('action');
            Swal.fire({
                title: action === 'approve' ? '{{ trans('custom.sw_title_approve_ap_request') }}' :
                    '{{ trans('custom.sw_title_reject_ap_request') }}',
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
                        id: $('input[name=id]').val(),
                        action,
                        _token: $('meta[name="c_token"]').attr("content")
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

    @if ($approval_request->model === 'shop')
        @php
            $shop = json_decode($approval_request->changes);
            // dd($shop);
        @endphp
        <script src="https://polyfill.io/v3/polyfill.min.js?features=default"></script>
        <script src="https://maps.googleapis.com/maps/api/js?libraries=drawing,places&v=3.45.8"></script>
        <script>
            let myLatlng = {
                lat: parseFloat("{{ $shop->latitude }}"),
                lng: parseFloat("{{ $shop->longitude }}")
            }
            let map = new google.maps.Map(document.getElementById("map"), {
                zoom: 13,
                center: myLatlng,
            });
            let infoWindow = new google.maps.InfoWindow({
                content: "{{ __('Click_the_map_to_get_Lat/Lng!') }}",
                position: myLatlng,
            });
            infoWindow.open(map);
            infoWindow.setPosition(myLatlng);
            infoWindow.setContent(JSON.stringify(myLatlng));
            infoWindow.open(map);
        </script>
    @endif

@endpush


@section('plugins.Sweetalert2', true)
