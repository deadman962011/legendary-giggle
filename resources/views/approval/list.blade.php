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
                    <table  id="example" class="table" style="width:100%">
                        <thead>
                            <th>
                                #
                            </th>
                            <th>
                                {{trans('custom.model')}}
                            </th>
                            <th>
                                {{trans('status')}}
                            </th>
                            <th>
                                {{trans('action')}}
                            </th>
                        </thead>
                        <tbody>
                            @foreach ($approval_requests as $approval_request)
                                <tr>
                                    <td>
                                        2
                                    </td>
                                    <td>
                                        {{$approval_request->model}}
                                    </td>
                                    <td>
                                        @php
                                            if($approval_request->status==='pending'){
                                                $bg='badge-warning';
                                            }
                                            elseif($approval_request->status==='rejected')
                                            {
                                                $bg='badge-danger';
                                            }
                                            elseif ($approval_request->status==='approved') {
                                                $bg='badge-sucess';
                                            }
                                            else{
                                                $bg='badge-primary';
                                            }
                                        @endphp
                                        <span class="badge {{$bg}} ">{{trans('custom.'.$approval_request->status)}}</span>
                                    </td>
                                    <td>
                                        <a href="{{route('approval.show',['id'=>$approval_request->id])}}" class="btn btn-primary"><i class="fas fa-eye"></i></a>
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
        new DataTable('#example', {
            info: false,
            ordering: false,
            paging: false
        });
    </script>
@endpush


@section('plugins.Datatables', true)
