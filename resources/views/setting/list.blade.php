@extends('layouts.app')

{{-- Customize layout sections --}}

@section('subtitle', 'Welcome')
@section('content_header_title', trans('custom.home'))
@section('content_header_subtitle', trans('custom.settings'))

{{-- Content body: main page content --}}

@section('content_body')
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header">
                    {{trans('custom.general_settings')}}
                </div>
                <div class="card-body">
                    @foreach ($settings as $setting)
                        <div class="form-group row">
                            <input type="hidden" name="types[]" value="minimum_order_amount">
                            <div class="col-md-6">
                                <label class="control-label">{{ $setting->getTranslation('name') }}</label>
                            </div>
                            <div class="col-md-6">
                                @if ($setting->input_type === 'numeric_taglist')
                                    <input name='{{ $setting->key }}' pattern="^[0-9]{1,2}$" class="tagify"
                                        value='{{ $setting->value }}' autofocus required>
                                @elseif($setting->input_type === 'number')
                                    <input class="form-control setting-input" type="number" name='{{ $setting->key }}'
                                        value="{{ $setting->value }}" required>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
@endsection


@push('css')
    <link rel="stylesheet" href="/vendor/tagify/tagify.css">
@endpush


@push('js')
    <script src="/vendor/tagify/tagify.js"></script>
    <script src="/vendor/tagify/tagify.polyfills.min.js"></script>


    <script>
        $('.setting-input').on('keyup', (e) => update_setting(e.target.name, e.target.value));

        function update_setting(key, value) {
            const debouncedFunction = debounce(() => {
                $.ajax({
                    url: "{{ route('setting.update') }}",
                    method: "POST",
                    data: {
                        key: key,
                        value: value,
                        _token: "{{ csrf_token() }}"
                    },
                    success: function(response) {
                        if (response.success) {
                            toastr["success"](response.message);
                        } else {

                            toastr["error"](response.message);
                        }
                    }
                })
            }, 1000);
            debouncedFunction(key, value);
        }





        var inputs = document.querySelectorAll('.tagify');
        inputs.forEach(element => {
            var tagify = new Tagify(element)
            tagify.on('change', function(e) {
                const jsonArray = JSON.parse(element.value);
                const valuesArray = jsonArray.map(item => item.value);
                update_setting(element.name, valuesArray.join(','))
            });
        })

        // {

        // } 
        // .map(item => item.value).join(',')
        // tagify.on('add', function(event) { 
        // });
        // tagify.on('remove',function(event){
        //     console.log('item removed',tagify.input.value)
        // })
    </script>
@endpush
