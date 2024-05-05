@extends('layouts.app')

{{-- Customize layout sections --}}

@section('subtitle', 'Welcome')
@section('content_header_title', trans('custom.home'))
@section('content_header_subtitle', trans('custom.sliders'))



@section('content_body')
    <div class="row">
        <div class="col-sm-12">
            <form class="custom-form" action="{{ route('slider.update',['name'=>$slider->name]) }}"  method="POST" >
            <div class="card">
                <div class="card-header">
                    {{trans('custom.home_slider')}}
                </div>
                <div class="card-body">
                        @csrf
                        <div class="form-group"> 
                            <div class="home-slider-target">
                                @foreach ($slider->slides as $image)
                                    <div class="row gutters-5">
                                        <div class="col-md-8">
                                            <div class="form-group">

                                                <div class="input-group" data-toggle="aizuploader" data-type="image">
                                                    <div class="input-group-prepend">
                                                        <div class="input-group-text bg-soft-secondary font-weight-medium">
                                                            {{ __('custom.browse') }}</div>
                                                    </div>
                                                    <div class="form-control file-amount">{{trans('custom.choose_file')}}
                                                    </div>
                                                    <input type="hidden" name="slider_images[]" class="selected-files"
                                                        value="{{ $image->upload_id }}">
                                                </div>
                                                <div class="file-preview box sm">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-auto">
                                            <div class="form-group">
                                                <button type="button"
                                                    class="mt-1 btn btn-danger"
                                                    data-toggle="remove-parent" data-parent=".row">
                                                    <i class="fas fa-times"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        <button type="button" class="btn btn-secondary btn-sm" data-toggle="add-more"
                            data-content='
                        <div class="row gutters-5">
                            <div class="col-md-8">
                                <div class="form-group">
                                    <div class="input-group" data-toggle="aizuploader" data-type="image">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text bg-soft-secondary font-weight-medium">{{ __('custom.browse') }}</div>
                                        </div>
                                        <div class="form-control file-amount">{{trans('custom.choose_file')}}</div>
                                        <input type="hidden" name="slider_images[]" class="selected-files">
                                    </div>
                                    <div class="file-preview box sm">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-auto">
                                <div class="form-group">
                                    <button type="button" class="mt-1 btn btn-danger" data-toggle="remove-parent" data-parent=".row">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </div>
                            </div>
                        </div>'
                            data-target=".home-slider-target">
                            {{ __('custom.add_new') }}
                        </button> 

                    </div>
                </div>
                <input type="submit" value="{{trans('custom.update')}}" class="btn btn-primary">
            </form>
        </div>
    </div>

@endsection



@push('css')
    <link rel="stylesheet" href="/vendor/media-manager/uppy.min.css">
    <link rel="stylesheet" href="/vendor/media-manager/media-manger.css">

@endpush


@push('js')
    <script src="/vendor/media-manager/uppy.min.js"></script>
    <script src="/vendor/media-manager/media-manager.js"></script>
    <script>

        
$(document).ready(function() {





    
});

    </script>

@endpush
 