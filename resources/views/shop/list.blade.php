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
                                name
                            </th>
                            <th>
                                status
                            </th>
                            <th>
                                action
                            </th>
                        </thead>
                        <tbody>
                            @foreach ($shops as $shop)
                                <tr>
                                    <td>
                                        {{$shop->id}}
                                    </td>
                                    <td>
                                        {{$shop->getTranslation('name')}}
                                    </td>
                                    <td>
                                        <span class="badge badge-warning">pending</span>
                                    </td>
                                    <td>
                                        <a href="{{route('approval.show',['id'=>$shop->id])}}" class="btn btn-primary">ap</a>
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
