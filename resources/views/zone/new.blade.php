@extends('layouts.app')

{{-- Customize layout sections --}}

@section('subtitle', 'Welcome')
@section('content_header_title', 'Home')
@section('content_header_subtitle', 'add new zone')

{{-- Content body: main page content --}}

@section('content_body')

    <form class="custom-form" method="POST" action="{{ route('zone.store') }}">
        <div class="card">
            <div class="row">
                <div class="col-sm-12">
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
                        {{ trans('custom.zone_informations') }}
                    </div>
                    <div class="card-body">
                        @if ($languages)
                            <div class="tab-content" id="nav-tabContent">
                                @foreach ($languages as $key => $lang)
                                    <div class="tab-pane fade  {{ $key == 0 ? 'show active' : '' }}"
                                        id="nav-{{ $lang->id }}" role="tabpanel"
                                        aria-labelledby="nav-{{ $lang->id }}-tab">
                                        <div class="form-group">
                                            <input type="text" name="name_{{ $lang->key }}"
                                                placeholder="{{ trans('custom.zone_name_in_' . $lang->key . '') }}"
                                                class="form-control">
                                            <input type="hidden" name="lang[]" value="{{ $lang->key }}">
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                        <label class="input-label" for="exampleFormControlInput1">{{ __('Coordinates') }}<span
                                class="form-label-secondary" data-toggle="tooltip" data-placement="right"
                                data-original-title="{{ __('messages.draw_your_zone_on_the_map') }}">{{ __('messages.draw_your_zone_on_the_map') }}</span></label>
                        <textarea type="text" rows="8" name="coordinates" id="coordinates" class="form-control" readonly></textarea>
                        <div class="map-warper overflow-hidden rounded">
                            <input id="pac-input" class="controls rounded initial-8"
                                title="{{ __('messages.search_your_location_here') }}" type="text"
                                placeholder="{{ __('messages.search_here') }}" />
                            <div id="map-canvas" class="h-100 m-0 p-0"></div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12">
                {{ csrf_field() }}
                <input type="submit" value="{{ trans('custom.save') }}" class="btn btn-primary">
            </div>
        </div>
    </form>
@endsection


@push('css')
    <style>
        .map-warper {
            height: 300px;
        }
    </style>
@endpush

@push('js')
    {{-- https://maps.googleapis.com/maps/api/js?libraries=drawing,places&v=3.45.8 --}}
    <script src="https://maps.googleapis.com/maps/api/js?libraries=drawing,places&v=3.45.8"></script>

    <script>
        "use strict";
        auto_grow();

        function auto_grow() {
            let element = document.getElementById("coordinates");
            element.style.height = "0px";
            element.style.visibility='hidden';
            // element.style.height = (element.scrollHeight) + "px";
        }

        // $(document).on('ready', function() {
        //     // INITIALIZATION OF DATATABLES
        //     // =======================================================
        //     let datatable = $.HSCore.components.HSDatatables.init($('#columnSearchDatatable'));

        //     $('#column1_search').on('keyup', function() {
        //         datatable
        //             .columns(1)
        //             .search(this.value)
        //             .draw();
        //     });


        //     $('#column3_search').on('change', function() {
        //         datatable
        //             .columns(2)
        //             .search(this.value)
        //             .draw();
        //     });


        //     // INITIALIZATION OF SELECT2
        //     // =======================================================
        //     $('.js-select2-custom').each(function() {
        //         let select2 = $.HSCore.components.HSSelect2.init($(this));
        //     });

        //     $("#zone_form").on('keydown', function(e) {
        //         if (e.keyCode === 13) {
        //             e.preventDefault();
        //         }
        //     })
        // });

        let map; // Global declaration of the map
        let drawingManager;
        let lastpolygon = null;
        let polygons = [];

        function resetMap(controlDiv) {
            // Set CSS for the control border.
            const controlUI = document.createElement("div");
            controlUI.style.backgroundColor = "#fff";
            controlUI.style.border = "2px solid #fff";
            controlUI.style.borderRadius = "3px";
            controlUI.style.boxShadow = "0 2px 6px rgba(0,0,0,.3)";
            controlUI.style.cursor = "pointer";
            controlUI.style.marginTop = "8px";
            controlUI.style.marginBottom = "22px";
            controlUI.style.textAlign = "center";
            controlUI.title = "Reset map";
            controlDiv.appendChild(controlUI);
            // Set CSS for the control interior.
            const controlText = document.createElement("div");
            controlText.style.color = "rgb(25,25,25)";
            controlText.style.fontFamily = "Roboto,Arial,sans-serif";
            controlText.style.fontSize = "10px";
            controlText.style.lineHeight = "16px";
            controlText.style.paddingLeft = "2px";
            controlText.style.paddingRight = "2px";
            controlText.innerHTML = "X";
            controlUI.appendChild(controlText);
            // Setup the click event listeners: simply set the map to Chicago.
            controlUI.addEventListener("click", () => {
                lastpolygon.setMap(null);
                $('#coordinates').val('');

            });
        }

        function initialize() {
            @php($default_location = 0)
            let myLatlng = {
                lat: {{ $default_location ? $default_location['lat'] : '23.757989' }},
                lng: {{ $default_location ? $default_location['lng'] : '90.360587' }}
            };

            let myOptions = {
                zoom: 13,
                center: myLatlng,
                mapTypeId: google.maps.MapTypeId.ROADMAP
            }
            map = new google.maps.Map(document.getElementById("map-canvas"), myOptions);
            drawingManager = new google.maps.drawing.DrawingManager({
                drawingMode: google.maps.drawing.OverlayType.POLYGON,
                drawingControl: true,
                drawingControlOptions: {
                    position: google.maps.ControlPosition.TOP_CENTER,
                    drawingModes: [google.maps.drawing.OverlayType.POLYGON]
                },
                polygonOptions: {
                    editable: true
                }
            });
            drawingManager.setMap(map);


            //get current location block
            // infoWindow = new google.maps.InfoWindow();
            // Try HTML5 geolocation.
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(
                    (position) => {
                        const pos = {
                            lat: position.coords.latitude,
                            lng: position.coords.longitude,
                        };
                        map.setCenter(pos);
                    });
            }

            google.maps.event.addListener(drawingManager, "overlaycomplete", function(event) {
                if (lastpolygon) {
                    lastpolygon.setMap(null);
                }
                $('#coordinates').val(event.overlay.getPath().getArray());
                lastpolygon = event.overlay;
                auto_grow();
            });

            const resetDiv = document.createElement("div");
            resetMap(resetDiv, lastpolygon);
            map.controls[google.maps.ControlPosition.TOP_CENTER].push(resetDiv);

            // Create the search box and link it to the UI element.
            const input = document.getElementById("pac-input");
            const searchBox = new google.maps.places.SearchBox(input);
            map.controls[google.maps.ControlPosition.TOP_CENTER].push(input);
            // Bias the SearchBox results towards current map's viewport.
            map.addListener("bounds_changed", () => {
                searchBox.setBounds(map.getBounds());
            });
            let markers = [];
            // Listen for the event fired when the user selects a prediction and retrieve
            // more details for that place.
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

        google.maps.event.addDomListener(window, 'load', initialize);


        function set_all_zones() {
            // $.get({
            //     url:  'admin.zone.zoneCoordinates',
            //     dataType: 'json',
            //     success: function(data) {

            //         console.log(data);
            //         for (let i = 0; i < data.length; i++) {
            //             polygons.push(new google.maps.Polygon({
            //                 paths: data[i],
            //                 strokeColor: "#FF0000",
            //                 strokeOpacity: 0.8,
            //                 strokeWeight: 2,
            //                 fillColor: "#FF0000",
            //                 fillOpacity: 0.1,
            //             }));
            //             polygons[i].setMap(map);
            //         }

            //     },
            // });
        }
        $(document).on('ready', function() {
            set_all_zones();
        });


        $('#reset_btn').click(function() {
            $('.tab-content').find('input:text').val('');
            lastpolygon.setMap(null);
            $('#coordinates').val(null);
        })
    </script>
@endpush
