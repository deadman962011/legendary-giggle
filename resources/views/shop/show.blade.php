@extends('layouts.app')

{{-- Customize layout sections --}}

@section('subtitle', 'Welcome')
@section('content_header_title', trans('custom.home'))
@section('content_header_subtitle', trans('custom.shop_details'))

{{-- Content body: main page content --}}

@section('content_body')
    <div class="row">
        <div class="col-sm-6">
            <div class="card">
                <div class="card-header">

                    {{ trans('custom.shop_information') }}
                </div>
                <div class="card-body">
                    <div class="">
                        @if ($languages)
                            @foreach ($languages as $key => $lang)
                                <div>
                                    <span class="font-weight-bold">
                                        {{ trans('custom.shop_name_' . $lang->key) }} :

                                    </span>
                                    <span>
                                        {{ $shop->getTranslation('name', $lang->key) }}
                                    </span>
                                </div>
                                <div>
                                </div>
                            @endforeach
                        @endif
                        <div class="">
                            <span class="font-weight-bold">{{ trans('custom.shop_tax_register') }}</span>
                            <span>{{ $shop->tax_register }}</span>
                        </div>
                        <div class="">
                            <span class="font-weight-bold">{{ trans('custom.shop_contact_email') }}</span>
                            <span>{{ $shop->shop_contact_email }}</span>
                        </div>
                        <div class="">
                            <span class="font-weight-bold">{{ trans('custom.shop_contact_phone') }}</span>
                            <span>{{ $shop->shop_contact_phone }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-6">
            <div class="card">
                <div class="card-header">

                    {{ trans('custom.shop_admin_information') }}
                </div>
                <div class="card-body">
                    <div class="">
                        <span class="font-weight-bold">{{ trans('custom.shop_tax_register') }}</span>
                        <span>{{ $shop->admins->first()->name }}</span>
                    </div>
                    <div class="">
                        <span class="font-weight-bold">{{ trans('custom.shop_owner_email') }}</span>
                        <span>{{ $shop->admins->first()->email }}</span>
                    </div>
                    <div class="">
                        <span class="font-weight-bold">{{ trans('custom.shop_owner_phone') }}</span>
                        <span>{{ $shop->admins->first()->phone }}</span>
                    </div>

                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header">

                    {{ trans('custom.shop_location') }}
                </div>
                <div class="card-body">

                    <div class="row">
                        <div class="col-sm-4">
 
                            <div class="form-group">
                                <label class="input-label" for="choice_zones">{{ __('custom.city') }}</label>
                                <select name="zone_id" id="choice_zones" required readonly
                                    class="form-control h--45px js-example-basic-multiple"
                                    data-placeholder="{{ __('custom.select_city') }}">
                                    @foreach (\App\Models\Zone::where('status', 1)->where('id',$shop->zone_id)->get(['id', 'name']) as $zone)
                                        <option value="{{ $zone->id }}" @selected($shop->zone_id === $zone->id)>
                                            {{ $zone->getTranslation('name') }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label class="input-label" for="choice_zones">{{ __('custom.district') }}</label>
                                <select name="zone_id" id="choice_zones" required readonly
                                    class="form-control"
                                    data-placeholder="{{ __('custom.select_district') }}">
                                    @foreach (\App\Models\District::where('id',$shop->district_id)->where('zone_id',$zone->id)->get(['id', 'name']) as $district)
                                        <option value="{{ $district->id }}" @selected($shop->district_id === $district->id)>
                                            {{ $district->getTranslation('name') }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-8">
                            <div style="height: 370px !important" id="map"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>



@stop

{{-- Push extra CSS --}}

@push('css')
<style>
 
    .gm-style-iw.gm-style-iw button {display: none !important;}

</style>
@endpush

{{-- Push extra scripts --}}

@push('js')
    <script src="https://polyfill.io/v3/polyfill.min.js?features=default"></script>
    <script src="https://maps.googleapis.com/maps/api/js?libraries=drawing,places&v=3.45.8"></script>
    <script>
        let myLatlng = {
            lat: parseFloat("{{ $shop->latitude }}"),
            lng: parseFloat("{{ $shop->longitude }}")
        }
        let map = new google.maps.Map(document.getElementById("map"), {
            zoom: 13,
            center: myLatlng,
        });
        let infoWindow = new google.maps.InfoWindow({
            content: "{{ __('Click_the_map_to_get_Lat/Lng!') }}",
            position: myLatlng,
        });
        infoWindow.open(map);
        infoWindow.setPosition(myLatlng);
        infoWindow.setContent( JSON.stringify(myLatlng));
        infoWindow.open(map); 
        
    </script>
@endpush
