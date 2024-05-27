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
                                <label class="input-label" for="latitude">{{ __('custom.latitude') }}<span
                                        data-toggle="tooltip" data-placement="right"
                                        data-original-title="{{ __('custom.restaurant_lat_lng_warning') }}"
                                        class="input-label-secondary">
                                    </span></label>
                                <input type="text" id="latitude" name="latitude" class="form-control h--45px disabled"
                                    placeholder="{{ __('Ex:_-94.22213') }} " value="{{ $shop->latitude }}" required
                                    readonly>
                            </div>
                            <div class="form-group">
                                <label class="input-label" for="longitude">{{ __('custom.longitude') }}
                                    <span data-toggle="tooltip" data-placement="right"
                                        data-original-title="{{ __('custom.restaurant_lat_lng_warning') }}"
                                        class="input-label-secondary">
                                    </span>
                                </label>
                                <input type="text" name="longitude" class="form-control h--45px disabled"
                                    placeholder="{{ __('Ex:_103.344322') }} " id="longitude"
                                    value="{{ $shop->longitude }}" required readonly>
                            </div>
                            <div class="form-group">
                                <span data-toggle="tooltip" data-placement="right"
                                    data-original-title="{{ __('custom.restaurant_lat_lng_warning') }}"
                                    class="input-label-secondary">

                                </span>
                            </div>
                            <div class="form-group">
                                <label class="input-label" for="choice_zones">{{ __('custom.zone') }}</label>
                                <select name="zone_id" id="choice_zones" required readonly
                                    class="form-control h--45px js-example-basic-multiple"
                                    data-placeholder="{{ __('custom.select_zone') }}">
                                    @foreach (\App\Models\Zone::where('status', 1)->get(['id', 'name']) as $zone)
                                        <option value="{{ $zone->id }}" @selected($shop->zone_id === $zone->id)>
                                            {{ $zone->getTranslation('name') }}
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
