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
                        {{ trans('custom.customer_name') }}
                    </th>
                    <th>
                        {{ trans('custom.customer_name') }}
                    </th>
                    <th>
                        {{ trans('custom.amount') }}
                    </th>
                    <th>
                        {{ trans('custom.action') }}
                    </th>
                </thead>
                <tbody>
                    @foreach ($shop_pay_commission_requests as $shop_pay_commission_request)
                        <tr>
                            <td>
                                {{ $shop_pay_commission_request->id }}
                            </td>
                            <td>
                                {{ $shop_pay_commission_request->offer->shop->getTranslation('name') }}  </td>
                                <td>
                                    {{ $shop_pay_commission_request->offer->getTranslation('name') }}  </td>
                            <td>
                                {{ $shop_pay_commission_request->amount }}
                            </td>
                            <td>
                                <a href="{{route('shop_commission_payment.show',['id'=>$shop_pay_commission_request->id])}}" class="btn btn-primary"><i class="fas fa-eye"></i></a>
                                   
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
