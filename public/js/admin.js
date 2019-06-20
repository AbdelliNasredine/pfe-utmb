// lancer les icons
feather.replace()

var baseUrl = window.location.hostname;

// la modale de details
$(document).ready(function () {
    // view user details
    $('.view_data').click(function () {
        var user_id = $(this).attr("id");
        $.ajax({
            url: `http://${baseUrl}/admin/user-details`,
            method: "post",
            data: { user_id: user_id },
            success: function (data) {
                $('#user_detail').html(data);
                $('#dataModal').modal("show");
            }
        });
    });
    // edit user details (modifications)
    $('.edit_user').click(function () {
        var user_id = $(this).attr("id");
        $('#editModal').modal("show");
        $.ajax({
            url: `http://${baseUrl}/admin/user-edit`,
            method: "GET",
            data: { user_id: user_id },
            success: function (data) {
                $('#user_edit_form').html(data);
                $('#editModal').modal("show");
            }
        });
    });
    //data-table -> users:
    $('#user_table').DataTable({
        "scrollY":        "300px",
        // "scrollCollapse": true,
        // "paging":         false,
        "language": {
            "url": `http://${baseUrl}/public/js/lang-fr.json`
        }
    });
    // memoires table data table:
    $('#memoires_table').DataTable({
        "language": {
            "url": `http://${baseUrl}/public/js/lang-fr.json`
        }
    });
    // table vue chekbox :
    $("#table_vue_checkbox").change(function () {
        if (this.checked) {
            // table vue true
            $('.doc_vue').addClass('d-none');
            $('.table_vue').removeClass('d-none');
        } else {
            // table vue false
            $('.doc_vue').removeClass('d-none');
            $('.table_vue').addClass('d-none');
        }
    });
});