@extends('layouts.app')

{{-- Customize layout sections --}}

@section('subtitle', 'Welcome')
@section('content_header_title', trans('custom.home'))
@section('content_header_subtitle', trans('custom.add_new_role'))

{{-- Content body: main page content --}}

@section('content_body')
    <form class="custom-form" method="POST" action="{{ route('role.store') }}">
        <div class="card">
            <div class="row">
                <div class="col-sm-12">
                    <div class="card-header">
                        
                        {{ trans('custom.role_informations') }}
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
                                                placeholder="{{ trans('custom.role_name_in_' . $lang->key . '') }}"
                                                class="form-control">
                                            <input type="hidden" name="lang[]" value="{{ $lang->key }}">
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        
        <ul class="list-group mb-4">
            <li class="list-group-item" aria-current="true">{{trans('custom.permissions')}}</li>
            <li class="list-group-item">
                <div class="row">

                    @foreach ($permissions as $key => $permission)
                        <div class="col-lg-3 col-md-4 col-sm-4 col-xs-6">
                            <div class="p-2 border mt-1 mb-2">
                                <label
                                    class="control-label d-flex"> {{$permission->getTranslation('name')}} </label>
                                <label class="switch">
                                    <input type="checkbox" name="permissions[]" class="form-control demo-sw"
                                        value="{{ $permission->name }}">
                                    <span class="slider round"></span>
                                </label>
                            </div>
                        </div>
                    @endforeach

                </div>
            </li>
        </ul>
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
