@php
    $offer = json_decode($approval_request->changes);

@endphp





<div class="row">
    <div class="col-sm-6">
        <div class="card">
            <div class="card-header">
                {{ trans('custom.offer_informations') }}
            </div>
            <div class="card-body">
                <div class="">
                    <span class="font-weight-bold">{{ trans('custom.offer_name') }}</span>
                    <span> {{ $offer->name_en }} </span>
                </div>
                <div class="">
                    <span class="font-weight-bold">{{ trans('custom.offer_start_date') }}</span>
                    <span> {{ date('m/d/Y', $offer->start_date) }} </span>
                </div>

                <div class="">
                    <span class="font-weight-bold">{{ trans('custom.offer_end_date') }}</span>
                    <span> {{ date('m/d/Y', $offer->end_date) }} </span>
                </div>
                <div class="">
                    <span class="font-weight-bold">{{ trans('custom.offer_cashback_amount') }}</span>
                    <span> {{ $offer->cashback_amount }} </span>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-6">
        <div class="card">
            <div class="card-header">
                {{ trans('custom.shop_informations') }}
            </div>
            <div class="card-body">
                @php
                    $shop = \App\Models\Shop::find($offer->shop_id);
                @endphp
                <div class="">
                    <span class="font-weight-bold">{{ trans('custom.shop_name_ar') }}</span>
                    <span>
                        {{ $shop->getTranslation('name', 'ar') }}
                    </span>
                </div>
                <div class="">
                    <span class="font-weight-bold">{{ trans('custom.shop_name_en') }}</span>
                    <span>
                        {{ $shop->getTranslation('name', 'en') }}
                    </span>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-sm-12">
        <div class="card">
            <div class="card-header">
                {{ trans('custom.attachments') }}
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-sm-6">
                        <img class="img-fluid" src="{{ getFileUrl($offer->offer_thumbnail) }}">
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
