// lancer les icons
feather.replace()

var baseUrl = window.location.hostname;

// la modale de details
$(document).ready(function () {
    //data-table -> users
    $('#user_table').DataTable({
        "language": {
            "url": `http://${baseUrl}/public/js/lang-fr.json`
        }
    });
});