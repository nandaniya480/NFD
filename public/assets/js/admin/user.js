$(function () {
    var table = $('.user-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: userIndexURL,
        columns: [{
            data: 'DT_RowIndex',
            orderable: false,
            searchable: false
        },
        {
            data: 'first_name',
            name: 'first_name'
        },
        {
            data: 'email',
            name: 'email'
        },
        {
            data: 'action',
            name: 'action',
            orderable: false,
            searchable: false
        },
        ]
    });
});
$(document).ready(function () {
    $(".validate_form_user").parsley();
    $(".validate_form_user").on("submit", function (event) {
        event.preventDefault();
        $("#submit").attr("disabled", true);

        if ($(".validate_form_user").parsley().isValid()) {
            var formData = new FormData(this);
            $.ajax({
                url: userURL,
                method: "POST",
                headers: {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr(
                        "content"
                    ),
                },
                data: formData,
                dataType: "json",
                cache: false,
                contentType: false,
                processData: false,
                beforeSend: function () {
                    $("#submit").val("Submitting...");
                },
                success: function (data) {
                    if (data.success) {
                        toastr.success(data.message);
                        setTimeout((window.location.href = userIndexURL), 2000);
                        $("#submit").val("Submit");
                    } else {
                        toastr.error(data.message);
                    }
                },
                error: function (response) {
                    $("#submit").attr("disabled", false);
                    if (response.responseJSON.errors['name']) {
                        $("#name_error").html(response.responseJSON.errors['name'][0]);
                    } else if (response.responseJSON.errors['email']) {
                        $("#email_error").html(response.responseJSON.errors['email'][0]);
                    } else if (response.responseJSON.errors['password']) {
                        $("#password_error").html(response.responseJSON.errors['password'][0]);
                    } else {
                        toastr.error(response.responseJSON.errors);
                    }
                },
            });
        } else {
            $("#submit").attr("disabled", false);
            return false;
        }
    });

    $("body").on("click", ".deleteUser", function () {
        var id = $(this).data("id");
        swal({
            title: `Are you sure you want to delete this record?`,
            text: "If you delete this, it will be gone forever.",
            icon: "warning",
            buttons: true,
            dangerMode: true,
        }).then((willDelete) => {
            if (willDelete) {
                $.ajax({
                    type: "DELETE",
                    headers: {
                        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr(
                            "content"
                        ),
                    },
                    url: userURL + "/" + id,
                    success: function (data) {
                        toastr.success(data.message);
                        $('.user-table').DataTable().draw(true);

                    },
                    error: function (data) {
                        toastr.error(data);
                    },
                });
            }
        });
    });
});
