@php
    $shop = json_decode($approval_request->changes);
    // dd($shop);
@endphp

<div class="row">
    <div class="col-sm-6">
        <div class="card">
            <div class="card-header">

                {{ trans('custom.shop_information') }}
            </div>
            <div class="card-body">
                <div class="">
                    <div>
                        <span class="font-weight-bold">
                            {{ trans('custom.shop_name') }} :

                        </span>
                        <span>
                            {{ $shop->shop_name }}
                        </span>
                    </div>
                    <div class="">
                        <span class="font-weight-bold">{{ trans('custom.shop_category') }}</span>
                        <span>
                            @php
                                $categories=\App\Models\Category::whereIn('id',explode(',',$shop->categories_ids))->get();
                            @endphp
                             
                             @foreach ($categories as $item)
                                {{$item->getTranslation('name')}}
                            @endforeach    
                        </span>
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
                    <span class="font-weight-bold">{{ trans('custom.shop_owner_name') }}</span>
                    <span>{{ $shop->shop_admin_name }}</span>
                </div>
                <div class="">
                    <span class="font-weight-bold">{{ trans('custom.shop_owner_email') }}</span>
                    <span>{{ $shop->shop_admin_name }}</span>
                </div>
                <div class="">
                    <span class="font-weight-bold">{{ trans('custom.shop_owner_phone') }}</span>
                    <span>{{ $shop->shop_admin_phone }}</span>
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


