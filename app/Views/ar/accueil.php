<!DOCTYPE html>
<html lang="ar">
<head>
    <?php include './app/Views/partials/inc.css.php'  ?>
    <link rel="stylesheet" href="/public/css/style.css">
    <style>
    /* arabic support pour la partie contact*/
    input , textarea {
      direction: rtl;
    }
    </style>
    <title>الصفحة الرئيسية</title>
</head>
<body>
<!-- Navigation -->
      <!-- langauge partie -->
      <div class="lang container clearfix">
        <div class="float-right">
          <a href="<?php print "/fr".$router->pathFor('home') ?>">FR</a>
          <a href="<?php print "/ar".$router->pathFor('home') ?>">AR</a>
        </div>
      </div>
      <nav class="navbar navbar-expand-sm navbar-light ">
        <div class="container">  
          <a class="navbar-brand" href="#">
            <img src="/public/img/logo.svg" alt="logo de site">
          </a>
            <ul class="navbar-nav ml-auto">
              <li class="nav-item">
                <a class="nav-link" href="#propos">معلومات عنا</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="#contact">اتصل بنا</a>
              </li>
              <li class="nav-item">
                <a class="nav-link btn-reg" href="#">تسجيل الدخول</a>
              </li>
            </ul>
        </div>
      </nav>
<!-- section jumbtron -->
  <div class="jumbotron jumbotron-fluid text-center">
    <div class="container">
      <h1 class="display-4"> <h1>يمكنك الوصول إلى أفضل مذكرات تخرج عبر الإنترنت</h1>
      <a class="btn btn-reg" href="<?php print '/'.$lang.$router->pathFor('inscription') ?>">أفتح حساب الأن</a>
      <span class="arrow d-none d-md-block">&darr;</span>
    </div>
  </div>
<!-- section a propos -->
  <section class="propos" id="propos">
    <div class="container text-center">
      <h1 class="display-4 py-3 pt-5">معلومات عنا</h1>
      <p class="lead">هذا الموقع يتيح حرية الوصول إلى مذكرات تخرج في مختلف المجالات</p>
        <div class="row">
          <div class="col">
            <div class="card">
              <div class="card-body">
                <i class="fas fa-code"></i>
                <p class="card-text">الاعلام الالي</p>
              </div> 
            </div>           
          </div>
          <div class="col">
            <div class="card">
              <div class="card-body">
                  <i class="fas fa-atom"></i>
                <p class="card-text">فيزياء</p>
              </div> 
            </div>           
          </div>
          <div class="col">
            <div class="card">
              <div class="card-body">
                <i class="fas fa-superscript"></i>
                <p class="card-text">رياضيات</p>
              </div> 
            </div>           
          </div>
          <div class="col">
            <div class="card">
              <div class="card-body">
                <i class="fas fa-balance-scale"></i>
                <p class="card-text">حقوق</p>
              </div> 
            </div>           
          </div>
        </div>
        <div class="row pb-5">
          <div class="col">
            <div class="card">
              <div class="card-body">
                <i class="fas fa-language"></i>
                <p class="card-text">لغات اجنبية</p>
              </div> 
            </div>           
          </div>
          <div class="col">
            <div class="card">
              <div class="card-body">
                <i class="fas fa-clinic-medical"></i>
                <p class="card-text">الطب</p>
              </div> 
            </div>           
          </div>
          <div class="col">
            <div class="card">
              <div class="card-body">
                <i class="fas fa-calculator"></i>
                <p class="card-text">اقتصاد</p>
              </div> 
            </div>           
          </div>
          <div class="col">
            <div class="card">
              <div class="card-body">
                <i class="fas fa-plus"></i>
                <p class="card-text">آخرى</p>
              </div> 
            </div>           
          </div>
        </div>
    </div>
  </section>
<!-- section devalopers -->
  <section class="devs">
      <div class="container">
        <h1 data-aos="fade-down" data-aos-once="true" class="display-4 text-center">تم انشاء هذا الموقع من قبل</h1>
        <div class="row" >
          <div class="col-sm-12 col-md text-center">
              <figure data-aos="fade-down" data-aos-delay="100" data-aos-once="true" class="figure">
                <img src="/public/img/Nasro.png" class="figure-img img-fluid rounded-circle" alt="A.Nasredine" title="A.Nasredine">
                <h4>عبدلي نصرالدين</h4>
                <figcaption class="figure-caption">طالب اعلام الي</figcaption>
                <div class="social">
                  <a href="https://github.com/AbdelliNasredine" class="social" title="Github" target="_blank"><i class="fab fa-github-square px-1"></i></a>
                  <a href="https://www.facebook.com/profile.php?id=100005374908479" class="social" title="Facebook" target="_blank"><i class="fab fa-facebook-square px-1"></i></a>
                </div>
              </figure>
          </div>
          <div class="col-sm-12 col-md text-center">
              <figure data-aos="fade-down" data-aos-delay="100" data-aos-once="true" class="figure">
                <img src="/public/img/ismail.png" class="figure-img img-fluid rounded-circle" alt="B.Ismail" title="B.Ismail">
                <h4>بورقعة اسماعيل</h4>
                <figcaption class="figure-caption">طالب اعلام الي</figcaption>
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
      <h1 class="display-4">اتصل بنا</h1>
      <p class="lead">تحتاج إلى معلومات اتصل بنا</p> 
      <form action="">
        <div class="form-row">
          <div class="col-8 offset-2">
            <input type="text" class="form-control form-control-lg" placeholder="بريد الكتروني">
          </div>
        </div>
        <div class="form-row">
            <div class="col-8 offset-2">
              <input type="text" class="form-control form-control-lg" placeholder="عنوان الرسالة">
            </div>
        </div>
        <div class="form-row">
            <div class="col-8 offset-2">
              <textarea class="form-control form-control-lg" rows="6" placeholder="..."></textarea>
            </div>          
        </div>
        <div class="form-row">
          <div class="col-8 offset-2">
            <input type="submit" value="أرسل">
          </div>
        </div>
      </form>    
    </div>
  </section>
<!-- La Footer -->
<footer>
  <div class="container">
    <div class="row">
      <div class="col">Copyright - Pfe utmb 2019</div>
      <div class="col text-right">Par A.nasredine et B.Ismail</div>
    </div>
  </div>
</footer>
<!-- Script js -->
<?php include './app/Views/partials/inc.js.php' ?>
</body>
</html>