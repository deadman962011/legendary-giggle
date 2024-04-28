
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
            error: function(response) {
                if (response.status == 422) {
                    $.each(response.responseJSON.errors, function (key, errorsArray) {
                        $.each(errorsArray, function (item, error) {
                            toastr["error"](error);
                        });
                    });
                }
                else{
                    toastr["error"]('somthing went wrong');
                }
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



    $(document).on(
        "click",
        '[data-toggle="remove-parent"]',
        function () {
            var $this = $(this);
            var parent = $this.data("parent");
            $this.closest(parent).remove();
        }
    );

    $('[data-toggle="add-more"]').each(function () {
        var $this = $(this);
        var content = $this.data("content");
        var target = $this.data("target");

        $this.on("click", function (e) {
            e.preventDefault();
            $(target).append(content);
            // AIZ.plugins.bootstrapSelect();
        });
    });
    
});