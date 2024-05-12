@extends('layouts.app')

{{-- Customize layout sections --}}

@section('subtitle', 'Welcome')
@section('content_header_title', trans('custom.home'))
@section('content_header_subtitle', trans('custom.add_new_notification'))

{{-- Content body: main page content --}}

@section('content_body')
    <form class="custom-form" method="POST" action="{{ route('notification.store') }}">
        <div class="card">
            <div class="row">
                <div class="col-sm-12">
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
                        {{ trans('custom.notification_informations') }}
                    </div>
                    <div class="card-body">
                        @if ($languages)
                            <div class="tab-content" id="nav-tabContent">
                                @foreach ($languages as $key => $lang)
                                    <div class="tab-pane fade  {{ $key == 0 ? 'show active' : '' }}"
                                        id="nav-{{ $lang->id }}" role="tabpanel"
                                        aria-labelledby="nav-{{ $lang->id }}-tab">
                                        <div class="form-group">
                                            <input type="text" name="title_{{ $lang->key }}"
                                                placeholder="{{ trans('custom.notification_title_in_' . $lang->key . '') }}"
                                                class="form-control">
                                            <input type="hidden" name="lang[]" value="{{ $lang->key }}">
                                        </div>
                                        <div class="form-group">
                                            <textarea name="description_{{ $lang->key }}"
                                                placeholder="{{ trans('custom.notification_description_in_' . $lang->key . '') }}" class="form-control"
                                                id="" cols="30" rows="6"></textarea>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">
                        {{ trans('custom.notification_informations') }}
                    </div>
                    <div class="card-body">
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
                                <input class="selected-files" type='hidden' name='cover_image'>
                            </div>
                            <div class="file-preview box sm"></div>
                        </div>
                        <div class="form-group row ">
                            <div class="col-sm-6">
                                <select name="zone_id" required class="form-control h--45px js-example-basic-multiple"
                                    data-placeholder="{{ __('custom.select_zone') }}">
                                    <option value="" selected disabled>{{ __('custom.select_zone') }}</option>
                                    @foreach (\App\Models\Zone::where('status', 1)->get(['id', 'name']) as $zone)
                                        <option value="{{ $zone->id }}">{{ $zone->getTranslation('name') }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-sm-6">
                                <select name="send_to" class="form-control">
                                    <option hidden >Send To</option>
                                    <option value="customer">Customer</option>
                                    <option value="customer">Shop</option>
                                </select>
                            </div>
                        </div>
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
    <link rel="stylesheet" href="/vendor/select2/select2.min.css">
@endpush

{{-- Push extra scripts --}}

@push('js')
    <script src="/vendor/media-manager/uppy.min.js"></script>
    <script src="/vendor/media-manager/media-manager.js"></script>
    <script src="/vendor/select2/select2.min.js"></script>
    <script>
        $(document).ready(function() {
            $('.js-example-basic-multiple').select2({
                placeholder:"{{trans('custom.select_shop_category')}}",
                allowClear: true
            });
        })
    </script>
@endpush
