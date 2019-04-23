$(document).ready(function () {
    // --------------------------------------------------------------------
    var baseURL = window.location.hostname;
    // --------------------------------------------------------------------
    // btn up animation function
    $(window).scroll(function () {
        if ($(this).scrollTop() > 100) {
            $(".btn_up").fadeIn().removeClass('d-none');
        } else {
            $(".btn_up").fadeOut();
        }
    });
    $(".btn_up").on("click", function (e) {
        e.preventDefault();
        $("html , body").animate({ scrollTop: 0 }, 100);
    });

    // --------------------------------------------------------------------
    // search forum - ajax fetch data
    $("#input_search").keyup(function () {

        var searchQuery = $("#input_search").val();

        // simple validation (vide)
        if (searchQuery === "") {
            $("#search_er").html("Champ vide !");
            $("#input_search").addClass('border-danger');
            return false;
        }
        // l'appel ajax (asyncron javascript)
        $.ajax({
            type: 'GET',
            url: `http://${baseURL}/search/s/${searchQuery}`,
            dataType: 'json',
            encode: true
        })
            .done(function (data) {
                // les resultat de recherche :
                $("#search_er").html("");
                $("#input_search").removeClass('border-danger');
                $("#search_result").removeClass('d-none');
                $("#search_result").html("");
                console.log(data);
                if (!data.length) {
                    $("#search_result").html(`
                    <h3 class="font-weight-bold color-pr">
                        Oups ! Nous n'avons trouvé aucune ressource pour "${ searchQuery}"
                    </h3>
                    <p class="lead color-lead mb-3">
                        Essayez d'ajuster votre recherche. Voici quelques idées :
                    </p>
                    <ul class="list-unstyled text-muted mb-3">
                        <li>
                            - Assurez-vous que tous les mots soient orthographiés correctement
                        </li>
                        <li>
                            - Essayez d'autres mots clés pour affiner votre recherche
                        </li>
                    </ul>
                `);
                } else {
                    $("#search_result").append(`
                        <h5 class="text-muted mb-4">
                            ${ data.length} pfe(s) trouvé(s)
                        </h5>
                        <div class="list-group rounded-0"></div>     
                    `);
                    for (i = 0; i < data.length; i++) {
                        $("#search_result .list-group").append(
                            `
                            <a href="/document/${ data[i].id}" class="list-group-item list-group-item-action">
                                <div class="d-flex w-100 justify-content-between">
                                    <h4 class="mb-2 color-pr font-weight-bold">${ data[i].titre}</h4>
                                    <div><small>ajouter le ${ data[i].date_publication}</small></div>
                                </div>
                                <p class="mb-2">
                                    Auteur : ${ data[i].auteur}
                                </p>
                                <p class="mb-2">
                                    Université : ${ data[i].universite}
                                </p>
                                <p class="mb-2">
                                    Faculté : ${ data[i].faculte}
                                </p>
                            </a>
                        `
                        );
                    }
                }
            })
            .fail(function () {
                // ereur de serveur type 500
                $("#search_er").html("");
                $("#input_search").removeClass('border-danger');
                alert('ereur serveur 505')
            });
    });
    // search avancéé
    $("#search_av").submit(function (event) {
        event.preventDefault();
        var titre = $("#input_search_av_titre").val();
        var type = $("#input_search_av_type").val();
        var lang = $("#input_search_av_lang").val();
        var domaine = $("#input_search_av_domain").val();
        var annee = $("#input_search_av_annee").val();
        // la requet ajax de recherche
        // &type=${type}&lang=${lang}&domaine=${domaine}&annee=${annee}
        $.ajax({
            type: 'GET',
            url: `http://${baseURL}/search/a?titre=${titre}&type=${type}&lang=${lang}&domaine=${domaine}&annee=${annee}`,
            dataType: 'json',
            encode: true
        })
            .done(function (data) {
                console.log(data);
                $("#search_result").removeClass('d-none');
                $("#search_result").html('');
                if (!data.length) {
                    $("#search_result").html(`
                    <h3 class="font-weight-bold color-pr">
                        Oups ! Nous n'avons trouvé aucune ressource
                    </h3>
                    <p class="lead color-lead mb-3">
                        Essayez d'ajuster votre recherche. Voici quelques idées :
                    </p>
                    <ul class="list-unstyled text-muted mb-3">
                        <li>
                            - Assurez-vous que tous les mots soient orthographiés correctement
                        </li>
                        <li>
                            - Essayez d'autres critère pour affiner votre recherche
                        </li>
                    </ul>
                `);
                } else {
                    $("#search_result").append(`
                        <h5 class="text-muted mb-4">
                            ${ data.length} pfe(s) trouvé(s)
                        </h5>
                        <div class="list-group rounded-0"></div>     
                    `);
                    for (i = 0; i < data.length; i++) {
                        $("#search_result .list-group").append(
                            `
                            <a href="/document/${ data[i].id}" class="list-group-item list-group-item-action">
                                <div class="d-flex w-100 justify-content-between">
                                    <h4 class="mb-2 color-pr font-weight-bold">${ data[i].titre}</h4>
                                    <div><small>ajouter le ${ data[i].date_publication}</small></div>
                                </div>
                                <p class="mb-2">
                                    Auteur : ${ data[i].auteur}
                                </p>
                                <p class="mb-2">
                                    Université : ${ data[i].universite}
                                </p>
                                <p class="mb-2">
                                    Faculté : ${ data[i].faculte}
                                </p>
                            </a>
                        `
                        );
                    }
                }
            })
            .fail(function () {
                alert('erreur 500 serveur');
            });
        
            event.preventDefault();
    });


    // --------------------------------------------------------------------
    // contact form
    $("#contact").submit(function (event) {

        // les information a envoyé
        var formData = {
            'nom': $('input[name=nom]').val(),
            'email': $('input[name=email]').val(),
            'titre': $('input[name=titre]').val(),
            'contenu': $('textarea[name=contenu]').val(),
        };
        // l'appel ajax (asyncron javascript)
        $.ajax({
            type: 'POST',
            url: `http://${baseURL}/contact`,
            data: formData,
            dataType: 'json',
            encode: true
        })
            // si l'information sont bien envoyés
            // 'data' contient la reponse de serveur (php)
            .done(function (data) {
                if (data.success) {
                    // le messgae et bien sauvgarder dant la base de donnée
                    $("<div class=\"alert alert-success\" role=\"alert\">\n" +
                        " Votre Message a été envoyer avec succeé !\n" +
                        "</div>").insertBefore($("#contact"));
                }
            })
            .fail(function () {
                alert('erreur !');
            });

        // desactivation de 'page Refresh' lors de l'envoi des données
        event.preventDefault();
    });

    // --------------------------------------------------------------------
    // form validation
    var err_nom = false;
    var err_prenom = false;
    var err_email = false;
    var err_pass = false;
    var err_pass_c = false;

    function validation() {
        $("#err-nom").hide();
        $("#err-prenom").hide();
        $("#err-email").hide();
        $("#err-pass-c").hide();

        var regex_s = /^[a-zA-Z]*$/;
        var regex_e = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;

        $("#nomId").keyup(function () {
            var nom = $("#nomId").val();
            if (nom !== "" && regex_s.test(nom)) {
                $("#err-nom").hide();
                $("#nomId")
                    .removeClass("is-invalid")
                    .addClass("is-valid");
                err_nom = false;
            } else {
                if (nom === "") {
                    $("#err-nom")
                        .removeClass("text-muted")
                        .addClass("text-danger")
                        .html("le nom ne doit pas être vide");
                } else {
                    $("#err-nom")
                        .removeClass("text-muted")
                        .addClass("text-danger")
                        .html("le nom ne doit contenir que des lettres");
                }
                $("#err-nom").show();
                $("#nomId")
                    .removeClass("is-invalid")
                    .addClass("is-invalid");
                err_nom = true;
            }
        });
        $("#prenomId").keyup(function () {
            var prenom = $("#prenomId").val();
            if (prenom !== "" && regex_s.test(prenom)) {
                $("#err-prenom").hide();
                $("#prenomId")
                    .removeClass("is-invalid")
                    .addClass("is-valid");
                err_prenom = false;
            } else {
                if (prenom === "") {
                    $("#err-prenom")
                        .removeClass("text-muted")
                        .addClass("text-danger")
                        .html("le prénom ne doit pas être vide");
                } else {
                    $("#err-prenom")
                        .removeClass("text-muted")
                        .addClass("text-danger")
                        .html("le prénom ne doit contenir que des lettres");
                }
                $("#err-prenom").show();
                $("#prenomId")
                    .removeClass("is-invalid")
                    .addClass("is-invalid");
                err_prenom = true;
            }
        });
        $("#emailId").keyup(function () {
            var email = $("#emailId").val();
            if (email !== "" && regex_e.test(email)) {
                $("#err-email").hide();
                $("#emailId")
                    .removeClass("is-invalid")
                    .addClass("is-valid");
                err_email = false;
            } else {
                if (email === "") {
                    $("#err-email")
                        .removeClass("text-muted")
                        .addClass("text-danger")
                        .html("l'email ne doit pas être vide");
                } else {
                    $("#err-email")
                        .removeClass("text-muted")
                        .addClass("text-danger")
                        .html("email non valid");
                }
                $("#err-email").show();
                $("#emailId")
                    .removeClass("is-invalid")
                    .addClass("is-invalid");
                err_email = true;
            }
        });
        $("#passwordId").keyup(function () {
            var pass = $("#passwordId").val();
            if (pass !== "" && pass.length >= 6) {
                $("#err-pass").hide();
                $("#passwordId")
                    .removeClass("is-invalid")
                    .addClass("is-valid");
                err_pass = false;
            } else {
                if (pass === "") {
                    $("#err-pass")
                        .removeClass("text-muted")
                        .addClass("text-danger")
                        .html("la mot de pass ne doit pas être vide");
                } else {
                    $("#err-pass")
                        .removeClass("text-muted")
                        .addClass("text-danger")
                        .html(
                            "la mot de pass doit être au moins composé de 6 caractères "
                        );
                }
                $("#err-pass").show();
                $("#passwordId")
                    .removeClass("is-invalid")
                    .addClass("is-invalid");
                err_pass = true;
            }
        });
        $("#passwordConfId").keyup(function () {
            var pass_c = $("#passwordConfId").val();
            if (pass_c === $("#passwordId").val() && pass_c !== "") {
                $("#err-pass-c").hide();
                $("#passwordConfId")
                    .removeClass("is-invalid")
                    .addClass("is-valid");
                err_pass_c = false;
            } else {
                $("#err-pass-c")
                    .removeClass("text-muted")
                    .addClass("text-danger")
                    .html(
                        "la confirmation du mot de passe doit être identique au mot de passe original"
                    );
                $("#err-pass-c").show();
                $("#passwordConfId")
                    .removeClass("is-invalid")
                    .addClass("is-invalid");
                err_pass_c = true;
            }
        });
        return err_nom && err_prenom && err_email && err_pass && err_pass_c;
    }
    validation();

    // scroll animation
    AOS.init({
        duration: 1200,
        once: true,
    });
});
