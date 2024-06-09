@extends('layouts.app')

{{-- Customize layout sections --}}

@section('subtitle', 'Welcome')
@section('content_header_title', trans('custom.home'))
@section('content_header_subtitle', trans('custom.add_new_deposit_bank_account'))

{{-- Content body: main page content --}}

@section('content_body')
    <form class="custom-form" method="POST" action="{{ route('deposit_bank_account.store') }}">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">
                        {{ trans('custom.deposit_bank_accounts_informations') }}
                    </div>
                    <div class="card-body">


                        <div class="form-group">
                            <input type="text" name="bank_name" placeholder="{{ trans('custom.bank_name') }}"
                                class="form-control">
                        </div>
                        <div class="form-group">
                            <input type="text" name="full_name" placeholder="{{ trans('custom.full_name') }}"
                                class="form-control">
                        </div>
                        <div class="form-group">
                            <input type="text" name="iban" placeholder="{{ trans('custom.iban') }}"
                                class="form-control">
                        </div>
                        <div class="form-group">
                            <input type="text" name="account_number" placeholder="{{ trans('custom.account_number') }}"
                                class="form-control">
                        </div>

                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12">
                        {{ csrf_field() }}
                        <input type="submit" value="Save" class="btn btn-primary">
                    </div>
                </div>
    </form>
    <script src="/vendor/moment/moment.min.js"></script>
@stop

{{-- Push extra CSS --}}

@push('css')
    <link rel="stylesheet" href="/vendor/media-manager/uppy.min.css">
    <link rel="stylesheet" href="/vendor/media-manager/media-manger.css">
    <style>
        .select2 {
            width: 100% !important;
        }
    </style>
    {{-- Add here extra stylesheets --}}
    {{-- <link rel="stylesheet" href="/css/admin_custom.css"> --}}
@endpush

{{-- Push extra scripts --}}
@push('js')
    <script src="/vendor/media-manager/uppy.min.js"></script>
    <script src="/vendor/media-manager/media-manager.js"></script>

    @section('plugins.tempusdominusBootstrap4', true)
@section('plugins.Select2', true)

<script>
    $(document).ready(function() {
        $('.js-example-basic-multiple').select2({
            placeholder: "{{ trans('custom.select_shop') }}",
            allowClear: true
            // theme, "bootstrap" 
        });

        $('#datetimepicker1').datetimepicker({
            useCurrent: false,
            minDate: new Date(),
            icons: {
                time: 'fas fa-clock',
            }
            // maxDate: new Date().setDate(new Date().getDate() + 14) 
            // options:{
            // }

        });

        $('#datetimepicker2').datetimepicker({
            useCurrent: false,
            minDate: new Date(),
            icons: {
                time: 'fas fa-clock',
            }
            // options:{
            //     minDate:new Date()
            // }
        });


        $('#datetimepicker1').on('change.datetimepicker', function(e) {

            var startDateVal = new Date($('#datetimepicker1').data('date'));
            var endDateVal = new Date($('#datetimepicker2').data('date'));

            var validEndDate = new Date(startDateVal.getTime() + 14 * 24 * 60 * 60 * 1000);

            if (endDateVal < startDateVal || endDateVal > validEndDate) {
                $('#datetimepicker2').datetimepicker('clear');
            }

            var endDateInpEndDate = new Date(startDateVal).setDate(startDateVal.getDate() + 15);

            $('#datetimepicker2').datetimepicker('minDate', startDateVal);
            $('#datetimepicker2').datetimepicker('maxDate', new Date(endDateInpEndDate))
        });
    });
</script>
@endpush
