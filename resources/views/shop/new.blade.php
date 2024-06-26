@extends('layouts.app')

{{-- Customize layout sections --}}

@section('subtitle', 'Welcome')
@section('content_header_title', trans('custom.home'))
@section('content_header_subtitle', trans('custom.add_new_shop'))

{{-- Content body: main page content --}}

@section('content_body')
    <form class="custom-form" method="POST" action="{{ route('shop.store') }}">
        <div class="row">
            <div class="col-sm-6">
                <div class="card">
                    <div class="card-header">

                        @if ($languages)
                            <nav>
                                <div class="nav nav-tabs" id="nav-tab" role="tablist">
                                    @foreach ($languages as $key => $lang)
                                        <button class="nav-link {{ $key == 0 ? 'active' : '' }} "
                                            id="nav-{{ $lang->id }}-tab" data-toggle="tab"
                                            data-target="#nav-{{ $lang->id }}" type="button" role="tab"
                                            aria-controls="nav-{{ $lang->id }}"aria-selected="true">{{ $lang->name }}</button>
                                    @endforeach

                                </div>
                            </nav>
                        @endif

                        {{ trans('custom.shop_information') }}
                    </div>
                    <div class="card-body">

                        @if ($languages)
                            <div class="tab-content" id="nav-tabContent">
                                @foreach ($languages as $key => $lang)
                                    <div class="tab-pane fade  {{ $key == 0 ? 'show active' : '' }}"
                                        id="nav-{{ $lang->id }}" role="tabpanel"
                                        aria-labelledby="nav-{{ $lang->id }}-tab">
                                        <div class="form-group">
                                            <input type="text" name="shop_name_{{ $lang->key }}"
                                                placeholder="{{ trans('custom.shop_name_' . $lang->key) }}"
                                                class="form-control">
                                            <input type="hidden" name="lang[]" value="{{ $lang->key }}">
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @endif

                        {{-- <div class="form-group">
                            <input type="text" class="form-control" name="shop_name" placeholder="Enter Shop Name">
                        </div> --}}
                        <div class="form-group">
                            <div class="input-group" data-toggle='aizuploader' data-type='all'
                                data-target='mn_program_thumbnail' data-itemid=''>
                                <div class="input-group-prepend">
                                    <div class="input-group-text bg-soft-secondary font-weight-medium">
                                        {{ trans('custom.browse') }}
                                    </div>
                                </div>
                                <div class="form-control file-amount">
                                    {{ trans('custom.choose_file') }}
                                </div>
                                <input class="selected-files" type='hidden' name='shop_logo'>
                            </div>
                            <div class="file-preview box sm"></div>
                        </div>
                        <div class="form-group">

                            <select class="js-example-basic-multiple w-100" name="categories_ids"
                                placeholder='Select Shop Category'>
                                <option value="" hidden>Select category</option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->getTranslation('name') }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <input type="text" class="form-control" name="tax_register"
                                placeholder="{{ trans('custom.shop_tax_register') }}" required>
                        </div>
                        <div class="form-group">
                            <input type="text" class="form-control" name="shop_contact_email"
                                placeholder="{{ trans('custom.shop_contact_email') }}" required>
                        </div>
                        <div class="form-group">
                            <input id="phone"  name="shop_contact_phone" class="form-control" placeholder="{{ trans('custom.shop_contact_phone') }}" required>
  
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
                        <div class="form-group">
                            <input type="text" class="form-control" name="shop_admin_name"
                                placeholder="{{ trans('custom.shop_admin_name') }}" required>
                        </div>
                        <div class="form-group">
                            <input id="phone"  name="shop_admin_phone" class="form-control" placeholder="{{ trans('custom.shop_admin_phone') }}" required>
 
                        </div>
                        <div class="form-group">
                            <input type="email" class="form-control" name="shop_admin_email"
                                placeholder="{{ trans('custom.shop_admin_email') }}" required>
                        </div>
                        {{-- <div class="form-group">
                            <input type="text" class="form-control" name="shop_admin_password"
                                placeholder="Enter Shop Admin Password" required>
                        </div> --}}
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-body">
                        <div class="card-header">
                            {{ trans('custom.shop_location') }}
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-sm-4">
                                    <input type="text" name="longitude" hidden class="form-control h--45px disabled"
                                        placeholder="{{ __('Ex:_103.344322') }} " id="longitude"
                                        value="{{ old('longitude') }}" required readonly>

                                    <input type="text" id="latitude" hidden name="latitude"
                                        class="form-control h--45px disabled" placeholder="{{ __('Ex:_-94.22213') }} "
                                        value="{{ old('latitude') }}" required readonly>

                                    {{-- <div class="form-group">
                                        <label class="input-label" for="latitude">{{ __('custom.latitude') }}<span
                                                data-toggle="tooltip" data-placement="right"
                                                data-original-title="{{ __('custom.restaurant_lat_lng_warning') }}"
                                                class="input-label-secondary"> 
                                            </span></label>
                                        
                                    </div>
                                    <div class="form-group">
                                        <label class="input-label" for="longitude">{{ __('custom.longitude') }}
                                            <span data-toggle="tooltip" data-placement="right"
                                                data-original-title="{{ __('custom.restaurant_lat_lng_warning') }}"
                                                class="input-label-secondary">
 
                                            </span>
                                        </label>
                                        
                                    </div> --}}
                                    <div class="form-group">
                                        {{-- <label class="input-label" for="longitude">{{ __('messages.address') }} --}}
                                        <span data-toggle="tooltip" data-placement="right"
                                            data-original-title="{{ __('custom.restaurant_lat_lng_warning') }}"
                                            class="input-label-secondary">
                                            {{-- <img
                                                    src="{{ dynamicAsset('/public/assets/admin/img/info-circle.svg') }}"
                                                    alt="{{ __('messages.restaurant_lat_lng_warning') }}"> --}}
                                        </span>
                                        {{-- </label> --}}
                                        {{-- <input type="text" name="shop_address" class="form-control h--45px"
                                            placeholder="Shop address Ex: ryiadh" value="{{ old('address') }}" required> --}}
                                    </div>
                                    <div class="form-group">
                                        <label class="input-label" for="choice_zones">{{ __('custom.city') }}</label>
                                        <select name="zone_id" id="choice_zones" required
                                            class="form-control h--45px js-example-basic-multiple"
                                            data-placeholder="{{ __('custom.select_zone') }}">
                                            <option value="" selected disabled>{{ __('custom.select_city') }}
                                            </option>
                                            @foreach (\App\Models\Zone::where('status', 1)->get(['id', 'name']) as $zone)
                                                <option value="{{ $zone->id }}">{{ $zone->getTranslation('name') }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label class="input-label"
                                            for="choice_district">{{ __('custom.district') }}</label>
                                        <select name="district_id" id="choice_districts" required
                                            class="form-control h--45px js-example-basic-multiple"
                                            data-placeholder="{{ __('custom.select_district') }}">
                                            <option value="" selected disabled>{{ __('custom.select_district') }}
                                            </option>
                                            {{-- @foreach (\App\Models\District::get(['id', 'name']) as $district)
                                            <option value="{{ $district->id }}">{{ $district->getTranslation('name') }}
                                            </option> 
                                            @endforeach --}}
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-8">
                                    <input id="pac-input" class="controls rounded initial-8"
                                        title="{{ __('messages.search_your_location_here') }}" type="text"
                                        placeholder="{{ __('messages.search_here') }}" />
                                    <div style="height: 370px !important" id="map"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12">
                {{ csrf_field() }}
                <input type="submit" value="Save" class="btn btn-primary">
            </div>
        </div>
    </form>
    {{-- <div class="card-footer">
        <button class="btn btn-primary">Save</button>
    </div> --}}

@endsection

@push('css')
    <link rel="stylesheet" href="/vendor/media-manager/uppy.min.css">
    <link rel="stylesheet" href="/vendor/media-manager/media-manger.css">
    <link rel="stylesheet" href="/vendor/select2/select2.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/intl-tel-input@23.0.11/build/css/intlTelInput.css">
    <style>
        #phone {
            -webkit-box-flex: 1;
            -ms-flex: 1 1 auto;
            flex: 1 1 auto;
            width: 100%;
            }
            #phone > input {
            width: 100%!important;
            }
            #phone > .flag-container {
            z-index: 4;
            }
            .iti.iti--allow-dropdown.iti--show-flags.iti--inline-dropdown{
                width: 100%;
            }
    </style>

    {{-- Add here extra stylesheets --}}
    {{-- <link rel="stylesheet" href="/css/admin_custom.css"> --}}
@endpush

{{-- Push extra scripts --}}

@push('js')
    <script src="/vendor/media-manager/uppy.min.js"></script>
    <script src="/vendor/media-manager/media-manager.js"></script>
    <script src="/vendor/select2/select2.min.js"></script>
    <script src="https://polyfill.io/v3/polyfill.min.js?features=default"></script>
    <script src="https://maps.googleapis.com/maps/api/js?libraries=drawing,places&v=3.45.8"></script>
    <script src="https://cdn.jsdelivr.net/npm/intl-tel-input@23.0.11/build/js/intlTelInput.min.js"></script>
    <script>
        $(document).ready(function() {
            $('.js-example-basic-multiple').select2({
                placeholder: "{{ trans('custom.select_shop_category') }}",
                allowClear: true
            });


            const phoneInputs = document.querySelectorAll("#phone");
            if(phoneInputs.length > 0){
                phoneInputs.forEach(input => {
                    window.intlTelInput(input, {
                        initialCountry:"sa",
                        countryOrder :['sa'],
                        preferredCountries:['sa'],
                        utilsScript: "https://cdn.jsdelivr.net/npm/intl-tel-input@23.0.11/build/js/utils.js",
                    });
                    
                })

            }


            $('#choice_zones').on('select2:select', function(e) {
                var data = e.params.data;


                var url = '{{ route('api.zone.get_destricts', ['id' => ':id']) }}';
                url = url.replace(':id', data.id)

                $.ajax({
                    url,
                    method: "GET",
                    success: function(resp) {
                        var districtsSelect = $("#choice_districts")
                        districtsSelect.find('option').remove();
                        districtsSelect.append($('<option></option>').text('select district'))
                            .attr('hidden', true);
                        if (resp.success && resp.payload.length > 0) {
                            $.each(resp.payload, function(index, district) {
                                districtsSelect.append($('<option></option>').attr(
                                    'value', district.id).text(district.name));
                            });

                        }
                        districtsSelect.trigger('change');
                    }
                })


            });


            let myLatlng = {
                lat: 23.757989,
                lng: 90.360587
            }
            let map = new google.maps.Map(document.getElementById("map"), {
                zoom: 13,
                center: myLatlng,
            });
            var zonePolygon = null;
            let infoWindow = new google.maps.InfoWindow({
                content: "{{ __('Click_the_map_to_get_Lat/Lng!') }}",
                position: myLatlng,
            });
            var bounds = new google.maps.LatLngBounds();

            function initMap() {
                // Create the initial InfoWindow.
                infoWindow.open(map);
                //get current location block
                infoWindow = new google.maps.InfoWindow();
                // Try HTML5 geolocation.
                if (navigator.geolocation) {
                    navigator.geolocation.getCurrentPosition(
                        (position) => {
                            myLatlng = {
                                lat: position.coords.latitude,
                                lng: position.coords.longitude,
                            };
                            infoWindow.setPosition(myLatlng);
                            infoWindow.setContent("{{ __('Location_found') }}");
                            infoWindow.open(map);
                            map.setCenter(myLatlng);
                        },
                        () => {
                            handleLocationError(true, infoWindow, map.getCenter());
                        }
                    );
                } else {
                    // Browser doesn't support Geolocation
                    handleLocationError(false, infoWindow, map.getCenter());
                }
                //-----end block------
                // Create the search box and link it to the UI element.
                const input = document.getElementById("pac-input");
                const searchBox = new google.maps.places.SearchBox(input);
                map.controls[google.maps.ControlPosition.TOP_CENTER].push(input);
                let markers = [];
                searchBox.addListener("places_changed", () => {
                    const places = searchBox.getPlaces();
                    if (places.length == 0) {
                        return;
                    }
                    // Clear out the old markers.
                    markers.forEach((marker) => {
                        marker.setMap(null);
                    });
                    markers = [];
                    // For each place, get the icon, name and location.
                    const bounds = new google.maps.LatLngBounds();
                    places.forEach((place) => {
                        if (!place.geometry || !place.geometry.location) {
                            console.log("Returned place contains no geometry");
                            return;
                        }
                        const icon = {
                            url: place.icon,
                            size: new google.maps.Size(71, 71),
                            origin: new google.maps.Point(0, 0),
                            anchor: new google.maps.Point(17, 34),
                            scaledSize: new google.maps.Size(25, 25),
                        };
                        // Create a marker for each place.
                        markers.push(
                            new google.maps.Marker({
                                map,
                                icon,
                                title: place.name,
                                position: place.geometry.location,
                            })
                        );
                        if (place.geometry.viewport) {
                            // Only geocodes have viewport.
                            bounds.union(place.geometry.viewport);
                        } else {
                            bounds.extend(place.geometry.location);
                        }
                    });
                    map.fitBounds(bounds);
                });
            }
            initMap();

            function handleLocationError(browserHasGeolocation, infoWindow, pos) {
                infoWindow.setPosition(pos);
                infoWindow.setContent(
                    browserHasGeolocation ?
                    "Error: The Geolocation service failed." :
                    "Error: Your browser doesn't support geolocation."
                );
                infoWindow.open(map);
            }

            $('#choice_zones').on('change', function() {
                var id = $(this).val();
                $.get({
                    url: '{{ url('/') }}/zone/get-coordinates/' + id,
                    dataType: 'json',
                    success: function(data) {
                        if (zonePolygon) {
                            zonePolygon.setMap(null);
                        }
                        zonePolygon = new google.maps.Polygon({
                            paths: data.coordinates,
                            strokeColor: "#FF0000",
                            strokeOpacity: 0.8,
                            strokeWeight: 2,
                            fillColor: 'white',
                            fillOpacity: 0,
                        });
                        zonePolygon.setMap(map);
                        zonePolygon.getPaths().forEach(function(path) {
                            path.forEach(function(latlng) {
                                bounds.extend(latlng);
                                map.fitBounds(bounds);
                            });
                        });
                        map.setCenter(data.center);
                        google.maps.event.addListener(zonePolygon, 'click', function(
                            mapsMouseEvent) {
                            infoWindow.close();
                            // Create a new InfoWindow.
                            infoWindow = new google.maps.InfoWindow({
                                position: mapsMouseEvent.latLng,
                                content: JSON.stringify(mapsMouseEvent.latLng
                                    .toJSON(),
                                    null, 2),
                            });
                            var coordinates = JSON.stringify(mapsMouseEvent.latLng
                                .toJSON(), null,
                                2);
                            var coordinates = JSON.parse(coordinates);
                            document.getElementById('latitude').value = coordinates[
                                'lat'];
                            document.getElementById('longitude').value = coordinates[
                                'lng'];
                            infoWindow.open(map);
                        });
                    },
                });
            })

            google.maps.event.addListener(map, 'click', function(mapsMouseEvent) {
                infoWindow.close();

                infoWindow = new google.maps.InfoWindow({
                    position: mapsMouseEvent.latLng,
                    content: JSON.stringify(mapsMouseEvent.latLng.toJSON(), null, 2),
                });


                var coordinates = JSON.stringify(mapsMouseEvent.latLng.toJSON(), null, 2);
                console.log(mapsMouseEvent)
                var coordinates = JSON.parse(coordinates);
                document.getElementById('latitude').value = coordinates['lat'];
                document.getElementById('longitude').value = coordinates['lng'];
                infoWindow.open(map);

            })


        });
    </script>
@endpush
