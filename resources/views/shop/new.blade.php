@extends('layouts.app')

{{-- Customize layout sections --}}

@section('subtitle', 'Welcome')
@section('content_header_title', 'Home')
@section('content_header_subtitle', 'Shops')
@section('content_header_subtitle', 'Add New Shop')

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
                                        <button class="nav-link {{$key==0 ? 'active':''}} " id="nav-{{ $lang->id }}-tab" data-toggle="tab" data-target="#nav-{{ $lang->id }}" type="button" role="tab" aria-controls="nav-{{ $lang->id }}"aria-selected="true">{{ $lang->name }}</button>
                                    @endforeach

                                </div>
                            </nav>
                        @endif

                        Shop Informations
                    </div>
                    <div class="card-body">

                        @if ($languages)
                            <div class="tab-content" id="nav-tabContent">
                                @foreach ($languages as $key=>$lang)
                                    <div class="tab-pane fade  {{$key==0 ? 'show active':''}}" id="nav-{{ $lang->id }}" role="tabpanel" aria-labelledby="nav-{{ $lang->id }}-tab">
                                        <div class="form-group">
                                            <input type="text" name="shop_name_{{$lang->key}}" placeholder="shop name {{$lang->name}}" class="form-control" required>
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
                                        Browse
                                    </div>
                                </div>
                                <div class="form-control file-amount">
                                    Choose File
                                </div>
                                <input class="selected-files" type='hidden' name='shop_logo'>
                            </div>
                            <div class="file-preview box sm"></div>
                        </div>
                        <div class="form-group">

                            <select class="js-example-basic-multiple w-100" name="categories_ids[]" multiple="multiple" placeholder='Select Shop Category'>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->getTranslation('name') }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <input type="text" class="form-control" name="tax_register"
                                placeholder="Enter Shop Tex Register" required>
                            {{-- <input type="hidden" name="shop_address" value="=="> --}}
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="card">
                    <div class="card-header">
                        Shop Admin Information
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <input type="text" class="form-control" name="shop_admin_name"
                                placeholder="Enter Admin Name" required>
                        </div>
                        <div class="form-group">
                            <input type="text" class="form-control" name="shop_admin_phone"
                                placeholder="Enter Shop Admin Phone" required>
                        </div>
                        <div class="form-group">
                            <input type="email" class="form-control" name="shop_admin_email"
                                placeholder="Enter Shop Admin Email" required>
                        </div>
                        <div class="form-group">
                            <input type="text" class="form-control" name="shop_admin_password"
                                placeholder="Enter Shop Admin Password" required>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-body">
                        <div class="card-header">
                            Shop Location
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label class="input-label" for="latitude">{{ __('messages.latitude') }}<span
                                                data-toggle="tooltip" data-placement="right"
                                                data-original-title="{{ __('messages.restaurant_lat_lng_warning') }}"
                                                class="input-label-secondary">
                                                {{-- <img src="{{ dynamicAsset('/public/assets/admin/img/info-circle.svg') }}"
                                                    alt="{{ __('messages.restaurant_lat_lng_warning') }}"> --}}
                                            </span></label>
                                        <input type="text" id="latitude" name="latitude"
                                            class="form-control h--45px disabled"
                                            placeholder="{{ __('messages.Ex:_-94.22213') }} " value="{{ old('latitude') }}"
                                            required readonly>
                                    </div>
                                    <div class="form-group">
                                        <label class="input-label" for="longitude">{{ __('messages.longitude') }}
                                            <span data-toggle="tooltip" data-placement="right"
                                                data-original-title="{{ __('messages.restaurant_lat_lng_warning') }}"
                                                class="input-label-secondary">
                                                {{-- <img
                                                    src="{{ dynamicAsset('/public/assets/admin/img/info-circle.svg') }}"
                                                    alt="{{ __('messages.restaurant_lat_lng_warning') }}"> --}}
                                            </span>
                                        </label>
                                        <input type="text" name="longitude" class="form-control h--45px disabled"
                                            placeholder="{{ __('messages.Ex:_103.344322') }} " id="longitude"
                                            value="{{ old('longitude') }}" required readonly>
                                    </div>
                                    <div class="form-group">
                                        <label class="input-label" for="longitude">{{ __('messages.address') }}
                                            <span data-toggle="tooltip" data-placement="right"
                                                data-original-title="{{ __('messages.restaurant_lat_lng_warning') }}"
                                                class="input-label-secondary">
                                                {{-- <img
                                                    src="{{ dynamicAsset('/public/assets/admin/img/info-circle.svg') }}"
                                                    alt="{{ __('messages.restaurant_lat_lng_warning') }}"> --}}
                                            </span>
                                        </label>
                                        <input type="text" name="shop_address" class="form-control h--45px"
                                            placeholder="Shop address Ex: ryiadh" value="{{ old('address') }}" required>
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
    <script>
        $(document).ready(function() {
            $('.js-example-basic-multiple').select2({
                placeholder:"Select Shop Category",
                allowClear: true
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
