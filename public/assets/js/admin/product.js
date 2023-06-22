$(document).ready(function () {

    $(function () {
        $('.product-table').DataTable({
            processing: true,
            serverSide: true,
            dom: 'Bfrtip',
            ajax: productIndexURL,
            columnDefs: [
                {
                    targets: 0,
                    searchable: false,
                    orderable: false,
                    checkboxes: {
                        selectRow: true,
                    },
                }
            ],
            columns: [
                {
                    data: 'id',
                    name: 'id',
                    orderable: false,
                    searchable: false
                },
                {
                    data: 'id',
                    name: 'id',
                    orderable: false,
                    searchable: false
                },
                {
                    data: 'DT_RowIndex',
                    orderable: false,
                    searchable: false
                },
                {
                    data: 'name',
                    name: 'name'
                },
                {
                    data: 'price',
                    name: 'price'
                },
                {
                    data: 'action',
                    name: 'action',
                    orderable: false,
                    searchable: false
                },
            ],
            select: {
                style: 'multi',
                selector: 'td:first-child'
            },
            buttons: [
                {
                    extend: "collection",
                    className: "btn btn-label-primary dropdown-toggle me-2",
                    text: '<i class="ti ti-file-export me-sm-1"></i> <span class="d-none d-sm-inline-block">Action</span>',
                    buttons: [
                        {
                            extend: "print",
                            text: '<i class="ti ti-printer me-1" ></i>Delete',
                            className: "dropdown-item",
                            action: function () {
                                var selectedRows = $('.product-table').DataTable().rows('.selected').data();
                                var selectedColumnValues = selectedRows.toArray().map(function (row) {
                                    return row['id'];
                                });

                                if (selectedColumnValues.length === 0) {
                                    alert('No rows selected');
                                    return;
                                }
                                swal({
                                    title: `Are you sure you want to make this Bulk Action?`,
                                    text: "If you delete this, it will be gone forever.",
                                    icon: "warning",
                                    buttons: true,
                                    dangerMode: true,
                                }).then((willDelete) => {
                                    if (willDelete) {
                                        $.ajax({
                                            url: productbulkActionURL,
                                            method: 'POST',
                                            headers: {
                                                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr(
                                                    "content"
                                                ),
                                            },
                                            data: {
                                                action: 'delete',
                                                ids: selectedColumnValues
                                            },
                                            success: function (response) {
                                                $('.product-table').DataTable().ajax.reload();
                                            },
                                            error: function (xhr, status, error) {
                                                // Handle the error
                                            }
                                        });
                                    }
                                });
                            }
                        }
                    ]
                }
            ]
        });
    });

    $(".validate_form_product").parsley();
    $(".validate_form_product").on("submit", function (event) {
        event.preventDefault();
        $("#submit").attr("disabled", true);

        if ($(".validate_form_product").parsley().isValid()) {
            var formData = new FormData(this);
            $.ajax({
                url: productURL,
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
                        setTimeout((window.location.href = productIndexURL), 2000);
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

    $("body").on("click", ".deleteProduct", function () {
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
                    url: productURL + "/" + id,
                    success: function (data) {
                        toastr.success(data.message);
                        $('.product-table').DataTable().draw(true);

                    },
                    error: function (data) {
                        toastr.error(data);
                    },
                });
            }
        });
    });
});
