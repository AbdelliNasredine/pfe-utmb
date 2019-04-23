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
    //data-table -> users
    $('#user_table').DataTable({
        "language": {
            "url": `http://${baseUrl}/public/js/lang-fr.json`
        }
    });
});