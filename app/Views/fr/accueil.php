<!DOCTYPE html>
<html lang="en">
<head>
    <?php include './app/Views/partials/inc.css.php'  ?>
    <link rel="stylesheet" href="/public/css/style.css">
    <title>Page d'accuill</title>
</head>
<body>
<!-- Navigation -->
      <!-- langauge partie -->
      <div class="lang container clearfix">
        <div class="float-right">
          <a href="<?php print "/fr".$router->pathFor('accueil') ?>">FR</a>
          <a href="<?php print "/ar".$router->pathFor('accueil') ?>">AR</a>
        </div>
      </div>
      <nav class="navbar navbar-expand-sm navbar-light ">
        <div class="container">  
          <a class="navbar-brand" href="#">
            <img src="/public/img/logo.svg" alt="logo de site">
          </a>
            <ul class="navbar-nav ml-auto">
              <li class="nav-item">
                <a class="nav-link" href="#propos">About</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="#contact">Contact</a>
              </li>
              <li class="nav-item">
                <a class="nav-link btn-reg" href="#">Se connecter</a>
              </li>
            </ul>
        </div>
      </nav>
<!-- section jumbtron -->
  <div class="jumbotron jumbotron-fluid text-center">
    <div class="container">
      <h1 class="display-4">Accéder aux meilleurs<br><strong>pfe’s</strong> en ligne</h1>
      <a class="btn btn-reg" href="<?php print '/'.$lang.$router->pathFor('inscription') ?>">Créer Votre Compt Maintenant</a>
      <span class="arrow">&darr;</span>
    </div>
  </div>
<!-- section a propos -->
  <section class="propos" id="propos">
    <div class="container text-center">
      <h1 class="display-4 py-3 pt-5">About</h1>
      <p class="lead">ce site permet un accés gratuit à des documents pfe’s dans des
        des domaines variés</p>
        <div class="row">
          <div class="col card">
            <div class="card-body">
              <i class="fas fa-code"></i>
              <p class="card-text">Informatique</p>
            </div>            
          </div>
          <div class="col card">
            <div class="card-body">
                <i class="fas fa-atom"></i>
              <p class="card-text">Physique</p>
            </div>            
          </div>
          <div class="col card">
            <div class="card-body">
              <i class="fas fa-superscript"></i>
              <p class="card-text">Mathématique</p>
            </div>            
          </div>
          <div class="col card">
            <div class="card-body">
              <i class="fas fa-balance-scale"></i>
              <p class="card-text">Droit</p>
            </div>            
          </div>
        </div>
        <div class="row">
          <div class="col card">
            <div class="card-body">
              <i class="fas fa-language"></i>
              <p class="card-text">Les langues</p>
            </div>            
          </div>
          <div class="col card">
            <div class="card-body">
              <i class="fas fa-clinic-medical"></i>
              <p class="card-text">Médcine</p>
            </div>            
          </div>
          <div class="col card">
            <div class="card-body">
              <i class="fas fa-calculator"></i>
              <p class="card-text">Economie</p>
            </div>            
          </div>
          <div class="col card p">
            <div class="card-body">
              <i class="fas fa-plus"></i>
              <p class="card-text">Plan <br>d’autre</p>
            </div>            
          </div>
        </div>
    </div>
  </section>
<!-- section devalopers -->
  <section class="devs">
      <div class="container">
        <h1 data-aos="fade-down" data-aos-once="true" class="display-4 text-center">Ce site était creé par</h1>
        <div class="row" >
          <div class="col-4 offset-2 text-center">
              <figure data-aos="fade-down" data-aos-delay="100" data-aos-once="true" class="figure">
                <img src="/public/img/Nasro.png" class="figure-img img-fluid rounded-circle" alt="A.Nasredine" title="A.Nasredine">
                <h4>Abdelli Nasredine</h4>
                <figcaption class="figure-caption">étudiant en informatique</figcaption>
                <div class="social">
                  <a href="https://github.com/AbdelliNasredine" class="social" title="Github" target="_blank"><i class="fab fa-github-square px-1"></i></a>
                  <a href="https://www.facebook.com/profile.php?id=100005374908479" class="social" title="Facebook" target="_blank"><i class="fab fa-facebook-square px-1"></i></a>
                </div>
              </figure>
          </div>
          <div class="col-4 text-center">
              <figure data-aos="fade-down" data-aos-delay="100" data-aos-once="true" class="figure">
                <img src="/public/img/ismail.png" class="figure-img img-fluid rounded-circle" alt="B.Ismail" title="B.Ismail">
                <h4>Bourega Ismail</h4>
                <figcaption class="figure-caption">étudiant en informatique</figcaption>
                <div class="social">
                  <a href="https://www.facebook.com/profile.php?id=100008006057568" class="social" title="Facebook" target="_blank"><i class="fab fa-facebook-square px-1"></i></a>
                </div>
              </figure>
          </div>
        </div>
      </div>
  </section>
<!-- section contact -->
  <section class="contact" id="contact">
    <div class="container text-center">
      <h1 class="display-4">Contacter Nous</h1>
      <p class="lead">Vous avez besoin d’information prenez contact avec nous</p> 
      <form action="">
        <div class="form-row">
            <div class="col-4 offset-2">
              <input type="text" class="form-control form-control-lg" placeholder="Votre Nom">
            </div>
            <div class="col-4">
              <input type="text" class="form-control form-control-lg" placeholder="Votre Prénom">
            </div>          
        </div>
        <div class="form-row">
          <div class="col-8 offset-2">
            <input type="text" class="form-control form-control-lg" placeholder="Votre adress email">
          </div>
        </div>
        <div class="form-row">
            <div class="col-8 offset-2">
              <input type="text" class="form-control form-control-lg" placeholder="Le suject de message">
            </div>
        </div>
        <div class="form-row">
            <div class="col-8 offset-2">
              <textarea class="form-control form-control-lg" rows="6" placeholder="Votre message"></textarea>
            </div>          
        </div>
        <div class="form-row">
          <div class="col-2 offset-2">
            <input type="submit" value="Envoyer">
          </div>
        </div>
      </form>    
    </div>
  </section>
<!-- La Footer -->
<footer>
  <div class="container">
    <span class="float-left">
      Copyright - Pfe utmb 2019
    </span>
    <span class="float-right">
      Par A.nasredine et B.Ismail
    </span>
  </div>
</footer>
<!-- Script js -->
<?php include './app/Views/partials/inc.js.php'  ?>
</body>
</html>