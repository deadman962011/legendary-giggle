@extends('layouts.app')

{{-- Customize layout sections --}}

@section('subtitle', 'Welcome')
@section('content_header_title', trans('custom.home'))
@section('content_header_subtitle', trans('custom.add_new_offer'))

{{-- Content body: main page content --}}

@section('content_body')
    <form class="custom-form" method="POST" action="{{ route('offer.store') }}">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">
                        @if ($languages)
                            <nav>
                                <div class="nav nav-tabs" id="nav-tab" role="tablist">
                                    @foreach ($languages as $key => $lang)
                                        <button class="nav-link {{ $key == 0 ? 'active' : '' }} "
                                            id="nav-{{ $lang->id }}-tab" data-toggle="tab"
                                            data-target="#nav-{{ $lang->id }}" type="button" role="tab"
                                            aria-controls="nav-{{ $lang->id }}"aria-selected="true">{{ $lang->name }}</button>
                                    @endforeach

                                </div>
                            </nav>
                        @endif

                        {{trans('custom.offers_informations')}}

                    </div>
                    <div class="card-body">
                        @if ($languages)
                            <div class="tab-content" id="nav-tabContent">
                                @foreach ($languages as $key => $lang)
                                    <div class="tab-pane fade  {{ $key == 0 ? 'show active' : '' }}"
                                        id="nav-{{ $lang->id }}" role="tabpanel"
                                        aria-labelledby="nav-{{ $lang->id }}-tab">
                                        <div class="form-group">
                                            <input type="text" name="name_{{ $lang->key }}"
                                                placeholder="{{trans('custom.offer_name_'.$lang->key)}}" class="form-control">
                                            <input type="hidden" name="lang[]" value="{{ $lang->key }}">
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @endif

                        {{-- 
                        <div class="form-group">
                            <input type="text" name="name" placeholder="offer name" class="form-control">
                        </div> --}}
                        <div class="form-group">
                            <div class="input-group" data-toggle='aizuploader' data-type='all' data-target='offer_thumbnail'
                                data-itemid=''>
                                <div class="input-group-prepend">
                                    <div class="input-group-text bg-soft-secondary font-weight-medium">
                                        {{trans('custom.browse')}}
                                    </div>
                                </div>
                                <div class="form-control file-amount">
                                    {{trans('custom.choose_file')}}
                                </div>
                                <input class="selected-files" type='hidden' name='offer_thumbnail'>
                            </div>
                            <div class="file-preview box sm"></div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <div class="input-group date" id="datetimepicker1" data-target-input="nearest">
                                        <input name="start_date" type="text" class="form-control datetimepicker-input"
                                            data-target="#datetimepicker1"
                                            placeholder="{{ __('custom.offer_start_date') }}" autocomplete="off" />
                                        <div class="input-group-append" data-target="#datetimepicker1"
                                            data-toggle="datetimepicker">
                                            <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <div class="input-group date" id="datetimepicker2" data-target-input="nearest">
                                        <input name="end_date" type="text" class="form-control datetimepicker-input"
                                            data-target="#datetimepicker2" placeholder="{{ __('custom.offer_end_date') }}"
                                            autocomplete="off" />
                                        <div class="input-group-append" data-target="#datetimepicker2"
                                            data-toggle="datetimepicker">
                                            <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                        </div>
                                    </div>
                                </div>
                            </div>


                            @php
                                $setting = getSetting('cashbak_amounts');
                                $options = explode(',',$setting);
                            @endphp
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <select name="cashback_amount" class="form-control">
                                        <option value="" selected>{{ __('custom.select_checkout_amount') }}</option>
                                        @foreach ($options as $option)
                                            <option value="{{$option}}">{{$option}}%</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <select name="shop_id" class="form-select js-example-basic-multiple">
                                    <option value="" selected>{{trans('custom.select_shop')}}</option>
                                    @foreach ($shops as $shop)
                                        <option value="{{ $shop->id }}">{{ $shop->getTranslation('name') }}</option>
                                    @endforeach
                                </select>
                            </div>
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
            placeholder: "{{trans('custom.select_shop')}}",
            allowClear: true
            // theme, "bootstrap" 
        });

        $('#datetimepicker1').datetimepicker({
            useCurrent: false,
            minDate: new Date(),
            // maxDate: new Date().setDate(new Date().getDate() + 14) 
            // options:{
            // }

        });

        $('#datetimepicker2').datetimepicker({
            useCurrent: false,
            minDate: new Date(),
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
