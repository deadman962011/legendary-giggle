@extends('layouts.app')

{{-- Customize layout sections --}}
@section('subtitle', 'Welcome')
@section('content_header_title', trans('custom.home'))
@section('content_header_subtitle', __('custom.plans'))

{{-- Content body: main page content --}}

@section('content_body')
    <div class="card">
        <div class="card-body">
            <table id="example" class="table" style="width:100%">
                <thead>
                    <th>
                        #
                    </th>
                    <th>
                        {{trans('custom.name')}}
                    </th>
                    <th>
                        {{trans('custom.status')}}
                    </th>
                    <th>
                        {{trans('custom.action')}}
                    </th>
                </thead>
                <tbody>
                    @foreach ($plans as $plan)
                        <tr>
                            <td>
                                {{$plan->id}}
                            </td>
                            <td>
                                {{ $plan->getTranslation('name') }}
                            </td>
                            <td>
                                <label class="switch">
                                    <input type="checkbox" data-id='{{$plan->id}}' oninput="update_status(this)" @checked($plan->status)>
                                    <span class="slider round"></span>
                                  </label>
                            </td>
                            <td>
                                <button data-delete-url='{{route('plan.delete',['id'=>$plan->id])}}'  class="btn btn-primary delete-button" ><i class="fas fa-trash"></i></button>
                                {{-- <a href="{{route('approval.show',['id'=>$approval_request->id])}}" class="btn btn-primary">ap</a> --}}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
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

        function update_status(e){
            
            var itemId= e.getAttribute('data-id')
            var url = '{{ route("plan.update_status",["id"=>":id"]) }}';
            url=url.replace(':id',itemId)
            $.ajax({
                method:"PUT",
                url,
                data:{
                    _token:$('meta[name="c_token"]').attr("content")
                }
            }).then((resp)=>{
                if(resp.success){
                    toastr["success"](resp.message)
                }
                else{
                    toastr["error"](resp.message)
                }
            }).catch(()=>{
                toastr["error"]('somthing went wrong')
            })
            

        }


    </script>
@endpush


@section('plugins.Datatables', true)
