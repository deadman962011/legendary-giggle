@extends('adminlte::page')

{{-- Extend and customize the browser title --}}

@section('title')
    {{ config('adminlte.title') }}
    @hasSection('subtitle')
        | @yield('subtitle')
    @endif
@stop

{{-- Extend and customize the page content header --}}

@section('content_header')
    <meta name="c_token" content="{{ csrf_token() }}" />
    @hasSection('content_header_title')
        <h1 class="text-muted">
            @yield('content_header_title')

            @hasSection('content_header_subtitle')
                <small class="text-dark">
                    <i class="fas fa-xs fa-angle-right text-muted"></i>
                    @yield('content_header_subtitle')
                </small>
            @endif
        </h1>
    @endif
@stop

{{-- Rename section content to content_body --}}

@section('content')
        <link rel="stylesheet" href="/vendor/custom.css">
    @yield('content_body')
    @include('modals.delete_modal')
@stop


{{-- Add common Javascript/Jquery code --}}

@push('js')
    {{-- @include('adminlte::plugins', ['type' => 'js']) --}}
    <script src="{{asset('/custom/custom.js')}}" ></script>
@endpush

{{-- Add common CSS customizations --}}

@push('css')
    {{-- @include('adminlte::plugins', ['type' => 'css'])  --}}
    <style type="text/css">
        {{-- You can add AdminLTE customizations here --}}
        /*
        .card-header {
            border-bottom: none;
        }
        .card-title {
            font-weight: 600;
        }
        */
    </style>
@endpush

@section('plugins.toastr', true)