@extends('layouts.app')

{{-- Customize layout sections --}}

@section('subtitle', 'Welcome')
@section('content_header_title', trans('custom.home'))
@section('content_header_subtitle', trans('custom.add_new_staff'))

{{-- Content body: main page content --}}

@section('content_body')
    <form class="custom-form" method="POST" action="{{ route('staff.store') }}">
        <div class="card">
        <div class="row">
            <div class="col-sm-12">
                    <div class="card-header">
                        {{trans('custom.staff_informations')}}
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <input type="text" name="name" placeholder="{{trans('custom.staff_name')}}" class="form-control">
                        </div>
                        <div class="form-group">
                            <input type="email" name="email" placeholder="{{trans('custom.staff_email')}}" class="form-control">
                        </div>
                        <div class="form-group">
                            <input  name="password" placeholder="{{trans('custom.staff_password')}}" class="form-control">
                        </div>

                        <div class="form-group">
                            
                            <select class="js-example-basic-multiple w-100" name="role_id"  placeholder='Select Staff Role'>
                                @foreach ($roles as $role)
                                    <option value="{{ $role->id }}">{{ $role->getTranslation('name') }}</option>
                                @endforeach
                            </select>
                        </div>
                        
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12">
                {{ csrf_field() }}
                <input type="submit" value="{{trans('custom.save')}}" class="btn btn-primary">
            </div>
        </div>
    </form>

@stop

{{-- Push extra CSS --}}

@push('css')
    <link rel="stylesheet" href="/vendor/media-manager/uppy.min.css">
    <link rel="stylesheet" href="/vendor/media-manager/media-manger.css">
    <link rel="stylesheet" href="/vendor/select2/select2.min.css">
    {{-- Add here extra stylesheets --}}
    {{-- <link rel="stylesheet" href="/css/admin_custom.css"> --}}
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

        });


    </script>
@endpush
