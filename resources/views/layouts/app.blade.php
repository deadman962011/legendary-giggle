@extends('adminlte::page')

{{-- Extend and customize the browser title --}}

@section('title')
    {{ config('adminlte.title') }}
    @hasSection('subtitle')
        | @yield('subtitle')
    @endif
@stop

{{-- Extend and customize the page content header --}}

@section('content_header')
    <meta name="c_token" content="{{ csrf_token() }}" />
    @hasSection('content_header_title')
        <h1 class="text-muted">
            @yield('content_header_title')

            @hasSection('content_header_subtitle')
                <small class="text-dark">
                    <i class="fas fa-xs fa-angle-right text-muted"></i>
                    @yield('content_header_subtitle')
                </small>
            @endif
        </h1>
    @endif
@stop

{{-- Rename section content to content_body --}}

@section('content')
        <link rel="stylesheet" href="/vendor/custom.css">
    @yield('content_body')
    @include('modals.delete_modal')
@stop


{{-- Add common Javascript/Jquery code --}}

@push('js')
    {{-- @include('adminlte::plugins', ['type' => 'js']) --}}
    <script>
        $(document).ready(function() {


            $(".custom-form").on("submit", function(e) {
                e.preventDefault();

                var form = $(this);
                var url = form.attr("action"); // Get the action URL from the form
                var method = form.attr("method");
                var beforeSubmitFuncName = form.data("before-submit");

                if (beforeSubmitFuncName && typeof window[beforeSubmitFuncName] === "function") {
                    window[beforeSubmitFuncName](form);
                }

                $.ajax({
                    type: method,
                    url: url,
                    data: form.serialize(), // Serialize the form data
                    success: function(response) {
                        // Handle the response here
                        if (response.success) {
                            toastr["success"](response.message);

                            if (response.action === 'redirect_to_url') {

                                setTimeout(() => {
                                    window.location.href = response.action_val
                                }, 1500)

                            }

                        } else {
                            toastr["error"](response.message);
                        }
                    },
                    error: function() {
                        toastr["error"]('somthing went wrong');
                    },
                });
            });


            $('.delete-button').on('click', function() {
                console.log('delete button clicked')
                deleteUrl = $(this).data('delete-url');
                console.log(deleteUrl)
                $('#deleteModalBtn').data('delete-url',deleteUrl)
                $('#delete-modal').modal('show');
            })


            $('#deleteModalBtn').on('click',function(){

                deleteUrl=$(this).data('delete-url');

                $.ajax({
                    method:'DELETE',
                    url:deleteUrl,
                    data:{
                        _token:$('meta[name="c_token"]').attr("content")
                    },
                    success:function(response){
                        if (response.success) {
                            toastr["success"](response.message);

                            if (response.action === 'redirect_to_url') {

                                setTimeout(() => {
                                    window.location.href = response.action_val
                                }, 1500)

                            }

                        } else {
                            toastr["error"](response.message);
                        }
                    }
                })


            })


            // Add your common script logic here...
        });
    </script>
@endpush

{{-- Add common CSS customizations --}}

@push('css')
    {{-- @include('adminlte::plugins', ['type' => 'css'])  --}}
    <style type="text/css">
        {{-- You can add AdminLTE customizations here --}}
        /*
        .card-header {
            border-bottom: none;
        }
        .card-title {
            font-weight: 600;
        }
        */
    </style>
@endpush

@section('plugins.toastr', true)