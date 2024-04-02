@extends('layouts.app')

{{-- Customize layout sections --}}

@section('subtitle', 'Welcome')
@section('content_header_title', 'Home')
@section('content_header_subtitle', 'Welcome')

{{-- Content body: main page content --}}

@section('content_body')
    <div class="row">
        <div class="col-sm-6">
            <div class="card">
                <div class="card-body">

                </div>
            </div>
        </div>
        <div class="col-sm-6">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-end align-items-center">
                        <form class="custom-form" action="{{ route('approval.approve') }}" method="POST">
                            <input type="hidden" name="id" value="{{ $approval_request->id }}">
                            {{ csrf_field() }}
                            <button class="btn btn-primary mx-2">Approve</button>
                        </form>
                        <button class="btn btn-danger">Reject</button>
                    </div>

                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-6">
            <div class="card">
                <div class="card-body">

                </div>
            </div>
        </div>
    </div>



@stop

{{-- Push extra CSS --}}

@push('css')
    {{-- Add here extra stylesheets --}}
    {{-- <link rel="stylesheet" href="/css/admin_custom.css"> --}}
@endpush

{{-- Push extra scripts --}}

@push('js')
    <script></script>
@endpush
