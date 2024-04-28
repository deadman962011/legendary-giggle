@extends('layouts.app')

{{-- Customize layout sections --}}

@section('subtitle', 'Welcome')
@section('content_header_title', 'Home')
@section('content_header_subtitle', 'Zones List')

{{-- Content body: main page content --}}

@section('content_body')
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-body">
                    <table id="example" class="table" style="width:100%">
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
                            @foreach ($zones as $zone)
                                <tr>
                                    <td>
                                        {{ $zone->id }}
                                    </td>
                                    <td>
                                        {{ $zone->getTranslation('name') }}
                                    </td>
                                    <td>
                                        <label class="switch">
                                            <input type="checkbox" data-id='{{ $zone->id }}' oninput="update_status(this)"
                                                @checked($zone->status)>
                                            <span class="slider round"></span>
                                        </label>
                                    </td>
                                    <td>
                                        {{-- <a href="{{route('approval.show',['id'=>$shop->id])}}" class="btn btn-primary"><i class="fas fa-eye"></i></a> --}}
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

        function update_status(e) {

            var itemId = e.getAttribute('data-id')
            var url = '{{ route('zone.update_status', ['id' => ':id']) }}';
            url = url.replace(':id', itemId)
            $.ajax({
                method: "PUT",
                url,
                data: {
                    _token: $('meta[name="c_token"]').attr("content")
                }
            }).then((resp) => {
                if (resp.success) {
                    toastr["success"](resp.message)
                } else {
                    toastr["error"](resp.message)
                }
            })
            .catch(()=>{
                toastr["error"]('somthing went wrong')
            })
        }
    </script>
@endpush


@section('plugins.Datatables', true)