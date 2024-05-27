@extends('layouts.app')

{{-- Customize layout sections --}}

@section('subtitle', 'Welcome')
@section('content_header_title', trans('custom.home'))
@section('content_header_subtitle', trans('custom.add_new_coupon'))

{{-- Content body: main page content --}}

@section('content_body')
    <form class="custom-form" method="POST" action="{{ route('coupon.store') }}">
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
                        {{ trans('custom.coupon_informations') }}
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
                                                placeholder="{{ trans('custom.coupon_name_in_' . $lang->key . '') }}"
                                                class="form-control">
                                            <input type="hidden" name="lang[]" value="{{ $lang->key }}">
                                        </div>
                                        <div class="form-group">
                                            <textarea name="description_{{ $lang->key }}"
                                                placeholder="{{ trans('custom.coupon_description_in_' . $lang->key . '') }}" class="form-control" id=""
                                                cols="30" rows="3"></textarea>
                                        </div>
                                        <div class="form-group">
                                            <textarea name="refund_details_{{ $lang->key }}"
                                                placeholder="{{ trans('custom.coupon_refund_details_in_' . $lang->key . '') }}" class="form-control" id=""
                                                cols="30" rows="3"></textarea>
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
                                        {{ trans('custom.browse') }}
                                    </div>
                                </div>
                                <div class="form-control file-amount">
                                    {{ trans('custom.choose_file') }}
                                </div>
                                <input class="selected-files" type='hidden' name='image'>
                            </div>
                            <div class="file-preview box sm"></div>
                        </div>
                        <div class="form-group">
                            <select name="category" placeholder="{{ trans('custom.coupon_category') }}"
                                class="form-control">
                                <option value="" hidden>{{trans('custom.select_coupon_category')}}</option>
                                <option value="onsite">{{trans('onsite')}}</option>
                                <option value="online">{{trans('online')}}</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex justify-content-between">
                            {{ trans('custom.coupon_variations') }}
                            <button id="add_variation_button" type="button" class="btn btn-primary">+ {{trans('custom.add_variation')}}</button>
                        </div>
                    </div>
                    <div id="variations" class="card-body">
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12">
                {{ csrf_field() }}
                <input type="submit" value="{{ trans('custom.save') }}" class="btn btn-primary">
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
        "use strict";
        let variation_count = 0;
        let variation_key_count = 0;
        var variations = $('#variations')

        $(document).on('click', '#add_variation_button', function(e) {
            variation_count++;
            e.preventDefault();

            variations.append(
                '<div class="card bg-light my-2 variation_item"> <div class="card-body"> <div class="d-flex align-items-center justify-content-between mb-3"> <div class=""></div> <button type="button" class="btn btn-danger delete_variation_button "> <i class="far fa-trash"></i></button> </div> <div class="row"> <div class="col-12 col-sm-6"> <div class="form-group"><label>Amount</label><input type="number" name="variation[' +
                variation_count +
                '][amount]" placeholder="amount" class="form-control" /></div></div> </div> <div class="variation_keys_' +
                variation_count +
                '"></div><button class="btn btn-outline-primary add_variation_key_button" type="button" data-id="' +
                variation_count + '">Add coupon key</button></div></div></div>')
        })


        $(document).on('click', '.delete_variation_button', function(e) {
            e.preventDefault();
            $(this).closest('.variation_item').remove();
        })

        $(document).on('click', '.add_variation_key_button', function(e) {
            e.preventDefault();
            variation_key_count++;
            var id = $(this).data('id'); 
            
            $('.variation_keys_'+id).append(
                '<div class="row variation_key_item_'+ variation_count +'_'+variation_key_count+
                '" ><div class="col-sm-4"><div class="form-group"><input type="text" name="variation[' +
                variation_count +
                '][key][]" placeholder="key" class="form-control" required /></div></div><div class="col-sm-2"><button class="btn btn-danger delete_variation_key_item" data-id="' +
                variation_count +
                '" data-keyid="'+variation_key_count+'"><i class="far fa-trash"></i></button></div>');
        })

        $(document).on('click', '.delete_variation_key_item', function(e) {
            e.preventDefault();
            var id = $(this).data('id');
            var keyid=$(this).data('keyid');
            $('.variation_key_item_'+id+'_'+keyid).remove();

        })
    </script>
@endpush
