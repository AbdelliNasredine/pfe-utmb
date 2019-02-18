<!DOCTYPE html>
<html lang="en">
<head>
    <?php include './app/Views/partials/inc.css.php'  ?>
    <title>Singup - pfeutmb</title>
    <style>
        html {
            scroll-behavior: smooth;
        }
        body {
            -webkit-font-smoothing: antialiased !important; 
            -moz-osx-font-smoothing: grayscale !important; 
            text-rendering: optimizeLegibility !important; 
            -webkit-text-stroke: 0.45px rgba(0, 0, 0, 0.1);
            font-family: 'Work Sans', sans-serif;
            background-color: #7f3d9b10;
        } 
        input:focus , select:focus {
            -webkit-box-shadow: 0px 0px 20px -4px rgba(36, 36, 36, 0.39) !important;
            -moz-box-shadow: 0px 0px 20px -4px rgba(36, 36, 36, 0.39) !important;
            box-shadow: 0px 0px 20px -4px rgba(36, 36, 36, 0.39) !important;
        }
        input{
            border-color : rgba(36, 36, 36, 0.39) ;
        }
        input[type='submit']{
            width: 100%;
            background-color: #7f3d9b;
            color: #fff;
            border: none;
            border-radius: 48px;
            padding-top: 9px;
            padding-bottom: 9px;
            font-size: 18px;
            font-weight: 500;
            margin-top: 10px;
            text-transform: capitalize;
            transition: all .2s ease-in-out !important;
        }
        input[type='submit']:hover ,input[type='submit']:focus {
            outline: none;
            cursor: pointer;
            background-color: #9d57bb;
            -webkit-box-shadow: 0px 0px 20px -4px rgba(36, 36, 36, 0.39) !important;
            -moz-box-shadow: 0px 0px 20px -4px rgba(36, 36, 36, 0.39) !important;
            box-shadow: 0px 0px 20px -4px rgba(36, 36, 36, 0.39) !important;
        }
        ::placeholder{
            color: #4646467a !important;
        }
        label {
            color: #464646;
        }  
        .row {
            height: 88vh;
            width: 80vw;
            background-color: #fff;
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            border-radius: 10px;
            -webkit-box-shadow: 0px 0px 40px -4px rgba(36, 36, 36, 0.178);
            -moz-box-shadow: 0px 0px 40px -4px rgba(36, 36, 36, 0.178);
            box-shadow: 0px 0px 40px -4px rgba(36, 36, 36, 0.178);
        }
        .row .left , .row .right{
            padding: 20px;
            padding-top: 40px;
        }
        .row .right {
            padding-left: 30px;
        }
        .row .left {
            background: url(/public/img/bg.jpg);
            background-repeat: no-repeat;
            background-size: cover;
            border-top-left-radius: 10px;
            border-bottom-left-radius: 10px;
            color: #fff;
        }
        .row .left .container h4{
            font-size: 32px;
            margin-bottom: 15px;
        }
        .row .left .container .lead{
            margin-bottom: calc(60vh - 60px);
        }
        .row .left .container a:hover span {
            transition: all .2s ease-in;
            transition: all .2s ease-out;
            padding-left: 12px !important;
        }
        .row .right .container h4{
            display: inline-block;
            font-size: 30px;
            margin-bottom: 25px;
        }
        .row .right .container a {
            color: #7f3d9b;
            margin-top: 5px;
            box-shadow: none;
        }
        .row .right .container a:hover {
            color: #9d57bb;
            border-bottom: 1px dotted #9d57bb;
        }
        .is-valid {
            border-color: #28a745;
            background-image: url(/public/img/succ.svg);
            background-repeat: no-repeat;
            background-position: center right calc(.375em + .1875rem);
            background-size: calc(.75em + .375rem) calc(.75em + .375rem);
        }
        .is-invalid {
            border-color: #dc3545;
            background-image: url(/public/img/fail.svg);
            background-repeat: no-repeat;
            background-position: center right calc(.375em + .1875rem);
            background-size: calc(.75em + .375rem) calc(.75em + .375rem);

        }
    </style>
</head>
<body>
    <div class="row">
        <div class="col-4 left">
            <div class="container">
                <h4>Inscription</h4>
                <p class="lead">Vous pouvez créer votre compte ici</p>
            </div>
        </div>
        <div class="col right">
            <div class="container">
                <h4>Form d'inscription</h4>
                <a href="<?php print "/".$lang.$router->pathFor('home') ?>" class="float-right">retour page d'accueil<span class="pl-2">&rarr;</span></a>
                <form id="reg-form" class="" action="/inscription" method="POST" novalidate>
                    <div class="form-row">
                            <div class="col">
                                <div class="form-group">
                                    <label for="">Votre nom *</label>
                                    <input id="nom" name="nom" type="text" class="form-control"  required>
                                    <div id="err-nom" class="invalid-feedback"></div>
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-group">
                                    <label for="">Votre prénom *</label>
                                    <input id="prenom" name="prenom" type="text" class="form-control" required>
                                    <div id="err-prenom" class="invalid-feedback"></div>
                                </div>
                            </div>
                    </div>
                    <div class="form-row">
                        <div class="col">
                            <div class="form-group">
                                <label for="">Votre email *</label>
                                <input id="email" name="email" type="email" class="form-control" required>
                                <div id="err-email" class="invalid-feedback"></div>
                            </div>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col">
                            <div class="form-group">
                                <label for="">Mote de pass *</label>
                                <input id="pass" name="pass" type="password" class="form-control" required>
                                <div id="err-pass" class="invalid-feedback"></div>
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group">
                                <label for="pass-c">Mote de pass (Confirmation) *</label>
                                <input id="pass-c" name="pass-c" type="password" class="form-control" required>
                                <div id="err-pass-c" class="invalid-feedback"></div>
                            </div>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col-6">
                            <div class="form-group">
                                <label for="select">Vous etes un ? *</label>
                                <select id="type" name="type" class="custom-select" id="select" required>
                                    <option value="">choisi ...</option>
                                    <option value="Etudiant">Etudiant</option>
                                    <option value="Ensiegnant">Ensiegnant</option>
                                </select>
                                <div id="err-type" class="invalid-feedback"></div>
                            </div>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col-4" style="display: inline-block;">
                            <input type="submit" value="s'inscrire">
                        </div>
                        <div class="col-4 offset-4 mt-3">
                            <span class="float-right">(*) champ obligatoire</span>
                        </div>
                    </div>
                </form>
            </div>    
        </div>
    </div>
<!-- scripts -->
<?php include './app/Views/partials/inc.js.php'  ?>
<script>
    $(function() {
        $("#err-nom").hide();
        $("#err-prenom").hide();
        $("#err-email").hide();
        $("#err-pass").hide();
        $("#err-pass-c").hide();
        $("#err-type").hide();

        var err_nom = false;
        var err_prenom = false;
        var err_email = false;
        var err_pass = false;
        var err_pass_c = false;
        var err_type = false;

        var regex_s = /^[a-zA-Z]*$/;
        var regex_e = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;

        $("#nom").focusout(function(){
            var nom = $("#nom").val();
            if(nom !== '' && regex_s.test(nom) ){
                $("#err-nom").hide();
                $("#nom").removeClass("is-invalid").addClass("is-valid");
            }else{
                if( nom === ''){
                    $("#err-nom").html("le nom ne doit pas être vide");    
                }else{
                    $("#err-nom").html("le nom ne doit contenir que des lettres");
                }
                $("#err-nom").show();
                $("#nom").removeClass("is-invalid").addClass("is-invalid");
                err_nom = true;
            }
        });
        $("#prenom").focusout(function(){
            var prenom = $("#prenom").val();
            if(prenom !== '' && regex_s.test(prenom) ){
                $("#err-prenom").hide();
                $("#prenom").removeClass("is-invalid").addClass("is-valid");
            }else{
                if( prenom === ''){
                    $("#err-prenom").html("le prénom ne doit pas être vide");    
                }else{
                    $("#err-prenom").html("le prénom ne doit contenir que des lettres");
                }
                $("#err-prenom").show();
                $("#prenom").removeClass("is-invalid").addClass("is-invalid");
                err_prenom = true;
            }
        });
        $("#email").focusout(function(){
            var email = $("#email").val();
            if(email !== '' && regex_e.test(email) ){
                $("#err-email").hide();
                $("#email").removeClass("is-invalid").addClass("is-valid");
            }else{
                if( email === ''){
                    $("#err-email").html("l'email ne doit pas être vide");    
                }else{
                    $("#err-email").html("email non valid");
                }
                $("#err-email").show();
                $("#email").removeClass("is-invalid").addClass("is-invalid");
                err_email = true;
            }
        });
        $("#pass").focusout(function(){
            var pass = $("#pass").val();
            if(pass !== '' && pass.length >= 8){
                $("#err-pass").hide();
                $("#pass").removeClass("is-invalid").addClass("is-valid");
            }else{
                if( pass === ''){
                    $("#err-pass").html("la mot de pass est vide");    
                }else{
                    $("#err-pass").html("la mot de pass doit être au moins composé de 8 caractères ");
                }
                $("#err-pass").show();
                $("#pass").removeClass("is-invalid").addClass("is-invalid");
                err_pass = true;
            }
        });
        $("#pass-c").focusout(function(){
            var pass_c = $("#pass-c").val();
            if(pass_c === $("#pass").val() && pass_c !== ''){
                $("#err-pass-c").hide();
                $("#pass-c").removeClass("is-invalid").addClass("is-valid");
            }else{
                $("#err-pass-c").html("la confirmation du mot de passe doit être identique au mot de passe original");
                $("#err-pass-c").show();
                $("#pass-c").removeClass("is-invalid").addClass("is-invalid");
                err_pass_c = true;
            }
        });
        $("#type").focusout(function(){
            var type = $('#type').val();
            if( type !== '' ){
                $("#err-type").hide();
                $("#type").removeClass("is-invalid").addClass("is-valid");
            }else{
                $("#err-type").html("erreur !");
                $("#err-type").show();
                $("#type").removeClass("is-invalid").addClass("is-invalid");
                err_type = true;
            }
        });
    });
</script>
</body>
</html>