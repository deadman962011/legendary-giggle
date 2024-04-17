@extends('layouts.app')

{{-- Customize layout sections --}}

@section('subtitle', 'Welcome')
@section('content_header_title', 'Home')
@section('content_header_subtitle', 'Add New Category')

{{-- Content body: main page content --}}

@section('content_body')
    <form class="custom-form" method="POST" action="{{ route('category.store') }}">
        <div class="card">
        <div class="row">
            <div class="col-sm-12">
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
                        Category Informations
                    </div>
                    <div class="card-body">
                        @if ($languages)
                            <div class="tab-content" id="nav-tabContent">
                                @foreach ($languages as $key=>$lang)
                                    <div class="tab-pane fade  {{$key==0 ? 'show active':''}}" id="nav-{{ $lang->id }}" role="tabpanel" aria-labelledby="nav-{{ $lang->id }}-tab">
                                        <div class="form-group">
                                            <input type="text" name="name_{{$lang->key}}" placeholder="category name {{$lang->name}}" class="form-control">
                                            <input type="hidden" name="lang[]" value="{{ $lang->key }}">
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                        <div class="form-group">
                            <div class="input-group" data-toggle='aizuploader' data-type='all'
                                data-target='mn_program_thumbnail' data-itemid=''>
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
    <script>
        console.log("Hi, I'm using the Laravel-AdminLTE package!");
    </script>
@endpush
