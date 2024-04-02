@extends('layouts.app')

{{-- Customize layout sections --}}

@section('subtitle', 'Welcome')
@section('content_header_title', 'Home')
@section('content_header_subtitle', 'Approval Requests')

{{-- Content body: main page content --}}

@section('content_body')
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-body">
                    <table class="table">
                        <thead>
                            <th>
                                id
                            </th>
                            <th>
                                model
                            </th>
                            <th>
                                status
                            </th>
                            <th>
                                action
                            </th>
                        </thead>
                        <tbody>
                            @foreach ($approval_requests as $approval_request)
                                <tr>
                                    <td>
                                        2
                                    </td>
                                    <td>
                                        Shop
                                    </td>
                                    <td>
                                        <span class="badge badge-warning">pending</span>
                                    </td>
                                    <td>
                                        <a href="{{route('approval.show',['id'=>$approval_request->id])}}" class="btn btn-primary">ap</a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

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
    <script>
        console.log("Hi, I'm using the Laravel-AdminLTE package!");
    </script>
@endpush
