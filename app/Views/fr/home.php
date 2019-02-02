<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="/public/css/bootstrap.min.css">
    <link rel="stylesheet" href="/public/css/home.css">
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,300i,400,400i,500,700" rel="stylesheet">
    <title>Acuille - PFEUTMB</title>
</head>
<body>
    <!-- menu de language -->
    <div class="langnavbar navbar">
        <div class="dropdown float-right">
            <button id="btnGroupDrop1" type="button" class="btn btn-sm dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <img class="lang" src="/public/images/fr.png" alt="franch flag">
            </button>
            <div class="dropdown-menu dropdown-menu-right " aria-labelledby="btnGroupDrop1">
                <a class="dropdown-item" href="<?php print "/fr".$router->pathFor('Home') ?>">
                    <img class="lang" src="/public/images/fr.png" alt="algreia flag"> <span>français</span>
                </a>
                <a class="dropdown-item" href="#">
                    <img class="lang" src="/public/images/ar.png" alt="franch flag"> <span>Arabic</span>
                </a>
                <a class="dropdown-item" href="#">
                    <img class="lang" src="/public/images/en.png" alt="uk flag"> <span>Anglais</span>
                </a>
            </div>
        </div>    
    </div>  
    <!-- header -->
    <nav class="mynavbar navbar navbar-expand-lg navbar-light bg-light-green">
        <div class="container">
            <a class="navbar-brand" href="#">Notre Site</a>
                <ul class="navbar-nav mr-auto">
                    <li class="nav-item">
                        <a class="nav-link text-center mx-3" href="#">A propos de nous</a>
                    </li>
                    <li class="nav-item ">
                        <a class="nav-link text-center mx-3" href="#">Contacter nous</a>
                    </li>
                </ul>
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item">
                        <a class="nav-link btn btn-reg" href="#">éspace mombre</a>
                    </li>
                </ul>
        </div>  
    </nav>
    <!-- fin header -->
    <!-- section 1 -->
    <section class="jumbtron jumbotron-fluid">
        <div class="container">
            <h1 class="display-4">Bienvenu</h1>
            <p class="lead">Ce site est dedie aux étudiants universitaire <br> au ils trouve ici beaucoup des resource's acadimique</p>          
            <span class="badge badge-secondary mr-1">PFE</span><span class="badge badge-secondary mr-1">Exposée</span><span class="badge badge-secondary mr-1">Autre</span><br>
            <button class="btn btn-info mt-3">Creé votre compt maintenant</button>
        </div>
    </section>
    <!-- fin section 1 -->
    <section class="services">
        <div class="container">
            <div class="row">
                <div class="col card">
                    <img class="card-img-top" src="/public/images/004-report.png" alt="Card image cap">
                    <div class="card-body">
                        <h5 class="card-title">Accée illimiter</h5>
                        <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                    </div>
                </div>
                <div class="col card">
                    <img class="card-img-top" src="/public/images/005-seo.png" alt="Card image cap">
                    <div class="card-body">
                        <h5 class="card-title">Rechercher Optimizer</h5>
                        <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                    </div>
                </div>
                <div class="col card">
                    <img class="card-img-top" src="/public/images/029-digital-campaign-1.png" alt="Card image cap">
                    <div class="card-body">
                        <h5 class="card-title">Axée sur la communauté</h5>
                        <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- js -->
    <script src="/public/js/jquery-3.3.1.min.js"></script>
    <script src="/public/js/popper.min.js"></script>
    <script src="/public/js/bootstrap.bundle.min.js"></script>
</body>
</html>