@extends('layouts.app')

{{-- Customize layout sections --}}

@section('subtitle', 'Welcome')
@section('content_header_title', 'Home')
@section('content_header_subtitle', 'Add New Offer')

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
                                        <button class="nav-link {{$key==0 ? 'active':''}} " id="nav-{{ $lang->id }}-tab" data-toggle="tab" data-target="#nav-{{ $lang->id }}" type="button" role="tab" aria-controls="nav-{{ $lang->id }}"aria-selected="true">{{ $lang->name }}</button>
                                    @endforeach

                                </div>
                            </nav>
                        @endif
                    
                        Offer Informations
                    
                    </div>
                    <div class="card-body">
                        @if ($languages)
                        <div class="tab-content" id="nav-tabContent">
                            @foreach ($languages as $key=>$lang)
                                <div class="tab-pane fade  {{$key==0 ? 'show active':''}}" id="nav-{{ $lang->id }}" role="tabpanel" aria-labelledby="nav-{{ $lang->id }}-tab">
                                    <div class="form-group">
                                        <input type="text" name="name_{{$lang->key}}" placeholder="offer name {{$lang->name}}" class="form-control">
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
                            <div class="input-group" data-toggle='aizuploader' data-type='all'
                                data-target='offer_thumbnail' data-itemid=''>
                                <div class="input-group-prepend">
                                    <div class="input-group-text bg-soft-secondary font-weight-medium">
                                        Browse
                                    </div>
                                </div>
                                <div class="form-control file-amount">
                                    Choose File
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
                                            data-target="#datetimepicker1" />
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
                                            data-target="#datetimepicker2" />
                                        <div class="input-group-append" data-target="#datetimepicker2"
                                            data-toggle="datetimepicker">
                                            <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <select name="cashback_amount" class="form-control" >
                                        <option value="" selected>Select Checkout amount</option>
                                        <option value="10">10</option>
                                        <option value="40">40</option>
                                        <option value="50">50</option>
                                        <option value="60">60</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <select name="shop_id" class="form-control" >
                                    <option value="" selected>Select Shop</option>
                                    @foreach ($shops as $shop)
                                        <option value="{{$shop->id}}">{{$shop->getTranslation('name')}}</option>
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
    {{-- Add here extra stylesheets --}}
    {{-- <link rel="stylesheet" href="/css/admin_custom.css"> --}}
@endpush

{{-- Push extra scripts --}}
@push('js')
<script src="/vendor/media-manager/uppy.min.js"></script>
<script src="/vendor/media-manager/media-manager.js"></script>

@section('plugins.tempusdominusBootstrap4', true)
    <script>
        $('#datetimepicker1').datetimepicker();
        
        $('#datetimepicker2').datetimepicker();
    </script>
@endpush


