@extends('layouts.app')

{{-- Customize layout sections --}}

@section('subtitle', 'Welcome')
@section('content_header_title', trans('custom.home'))
@section('content_header_subtitle', trans('custom.add_new_plan'))

{{-- Content body: main page content --}}

@section('content_body')
    <form class="custom-form" method="POST" action="{{ route('plan.store') }}">
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
                        {{ trans('custom.plan_informations') }}
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
                                                placeholder="{{ trans('custom.plan_name_in_' . $lang->key . '') }}"
                                                class="form-control">
                                            <input type="hidden" name="lang[]" value="{{ $lang->key }}">
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @endif

                        <div class="form-group">
                            <input type="number" name="duration" placeholder="{{ trans('custom.plan_duration') }}"
                                class="form-control">
                        </div>

                        <div class="form-group">
                            <input type="number" name="price" placeholder="{{ trans('custom.plan_price') }}"
                                class="form-control">
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
