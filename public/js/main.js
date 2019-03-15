$(document).ready(function () {
    $('#megamenuId').hover(function () {
        $('.megamenu').fadeIn().removeClass('d-none');
        $('.megamenu').mouseleave(function () {
            $('.megamenu').fadeOut();
        });
    });
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
        $("html , body").animate({scrollTop: 0}, 100);
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
            url: 'http://localhost:9000/contact',
            data: formData,
            dataType: 'json',
            encode: true
        })
            // si l'information sont bien envoyés
            // 'data' contient la reponse de serveur (php)
            .done(function (data) {
                console.log(data);
                if(data.success) {
                    // le messgae et bien sauvgarder dant la base de donnée
                    $("<div class=\"alert alert-success\" role=\"alert\">\n" +
                        " Votre Message a été envoyer avec succeé !\n" +
                      "</div>").insertBefore( $("#contact") );
                }
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

            $("#nomId").focusout(function () {
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
            $("#prenomId").focusout(function () {
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
            $("#emailId").focusout(function () {
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
            $("#passwordId").focusout(function () {
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
            $("#passwordConfId").focusout(function () {
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
        duration : 1200,
        once: true,
    });
});
