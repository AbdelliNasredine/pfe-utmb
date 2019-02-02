<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css" integrity="sha384-GJzZqFGwb1QTTN6wy59ffF1BuGJpLSa9DkKMp0DgiMDm4iYMj70gZWKYbI706tWS" crossorigin="anonymous">
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js" integrity="sha384-B0UglyR+jN6CkvvICOB2joaf5I4l3gm9GU6Hc1og6Ls7i6U/mkkaduKaBhlAXv9k" crossorigin="anonymous"></script>
    <style>
        @import url('http://fonts.googleapis.com/earlyaccess/droidarabickufi.css');
    </style>
    <title>PFEUTMB - الرئيسية</title>
    <style>
    *{
        font-family: 'Droid Arabic Kufi', sans-serif;
    }
    html{
        height: 100vh;
    }
    .dropdown-item:active , .dropdown-item:focus {
        background-color : #17a2b8;
    }
    .container .dropdown-toggle {
        display: block;
        margin-right: 0 !important;
        margin-left: auto !important;
    }
    footer{
        color: white;
        border-radius: 3px;
    }
    </style>
</head>
<body>
    <div class="container">
        <button id="btnGroupDrop1" type="button" class="btn btn-info dropdown-toggle mb-2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        اللغة
        </button>
        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="btnGroupDrop1">
            <a class="dropdown-item" href="<?php print "/fr".$router->pathFor('Home') ?>">فرنسة</a>
            <a class="dropdown-item" href="<?php print "/ar".$router->pathFor('Home') ?>">عربية</a>
            <a class="dropdown-item" href="<?php print "/en".$router->pathFor('Home') ?>">انجليزية</a>
        </div> 
        <div class="jumbotron text-right">
            <h1 class="display-4">مرحبا</h1>
            <p class="lead">يمكنك رأيت عدد غير محدود من البحوث الأكاديمية</p>
            <a class="btn btn-info btn-lg" href="#" role="button">أفتح حسابك الأن</a>
        </div>
        <footer class="fixed-bottom text-center bg-info container py-1"> عبدلي نصرالدين </footer> 
    </div> 
    <!-- script js -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js" integrity="sha384-wHAiFfRlMFy6i5SRaxvfOCifBUQy1xHdJ/yoi7FRNXMRBu5WHdZYu1hA6ZOblgut" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js" integrity="sha384-B0UglyR+jN6CkvvICOB2joaf5I4l3gm9GU6Hc1og6Ls7i6U/mkkaduKaBhlAXv9k" crossorigin="anonymous"></script>
</body>
</html>