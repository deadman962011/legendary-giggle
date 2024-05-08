@extends('layouts.app')

{{-- Customize layout sections --}}

@section('subtitle', 'Welcome')
@section('content_header_title', trans('custom.home'))
@section('content_header_subtitle', __('custom.staff'))

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
                        {{ trans('custom.name') }}
                    </th>
                    <th>
                        {{ trans('custom.role') }}
                    </th>
                    <th>
                        {{ trans('custom.status') }}
                    </th>
                    <th>
                        {{ trans('custom.action') }}
                    </th>
                </thead>
                <tbody>
                    @foreach ($staff as $staff_member)
                        @php
                            $role_name = $staff_member->admin_roles->first()->getTranslation('name');
                        @endphp
                        <tr>
                            <td>
                                {{ $staff_member->id }}
                            </td>
                            <td>
                                {{ $staff_member->name }}
                            </td>
                            <td>
                                {{ $role_name }}
                            </td>
                            <td>
                                <label class="switch">
                                    <input type="checkbox" data-id='{{ $staff_member->id }}' oninput="update_status(this)"
                                        @checked(true) @disabled($role_name === 'Admin')>
                                    <span class="slider round"></span>
                                </label>
                            </td>
                            <td>
                                @if ($role_name !== 'Admin')
                                    <button data-delete-url='{{ route('role.delete', ['id' => $staff_member->id]) }}'
                                        class="btn btn-primary"><i class="fas fa-trash"></i></button>
                                @endif
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

        function update_status(e) {

            var itemId = e.getAttribute('data-id')
            var url = '{{ route('category.update_status', ['id' => ':id']) }}';
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
            }).catch(() => {
                toastr["error"]('somthing went wrong')
            })


        }
    </script>
@endpush


@section('plugins.Datatables', true)
