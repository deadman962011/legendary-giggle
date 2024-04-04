@extends('layouts.app')

{{-- Customize layout sections --}}

@section('subtitle', 'Welcome')
@section('content_header_title', 'Home')
@section('content_header_subtitle', 'Add New Category')

{{-- Content body: main page content --}}

@section('content_body')
    <form class="custom-form" method="POST" action="{{ route('category.store') }}">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">Offer Informations</div>
                    <div class="card-body">
                        <div class="form-group">
                            <input type="text" name="name" placeholder="category name" class="form-control">
                        </div>
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
                                <input class="selected-files" type='hidden' name='cover_image'>
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
                                    <div class="input-group date" id="datetimepicker1" data-target-input="nearest">
                                        <input name="end_date" type="text" class="form-control datetimepicker-input"
                                            data-target="#datetimepicker1" />
                                        <div class="input-group-append" data-target="#datetimepicker1"
                                            data-toggle="datetimepicker">
                                            <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <select name="cashback_amount" class="form-control" >
                                    <option value="10">10</option>
                                    <option value="40">40</option>
                                    <option value="50">50</option>
                                    <option value="60">60</option>
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
    </script>
@endpush


