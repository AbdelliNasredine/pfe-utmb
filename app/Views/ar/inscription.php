<!DOCTYPE html>
<html lang="en">
<head>
    <?php include './app/Views/partials/inc.css.php'  ?>
    <title>تسجيل</title>
    <style>
        html {
            scroll-behavior: smooth;
        }
        body {
            -webkit-font-smoothing: antialiased !important; 
            -moz-osx-font-smoothing: grayscale !important; 
            text-rendering: optimizeLegibility !important; 
            -webkit-text-stroke: 0.45px rgba(0, 0, 0, 0.1);
            background-color: #7f3d9b10;
        } 
        input , select{
            border-color: #4646462d !important;
            direction: rtl;
        }
        input:focus , select:focus {
            -webkit-box-shadow: 0px 0px 20px -4px rgba(36, 36, 36, 0.39) !important;
            -moz-box-shadow: 0px 0px 20px -4px rgba(36, 36, 36, 0.39) !important;
            box-shadow: 0px 0px 20px -4px rgba(36, 36, 36, 0.39) !important;
            border-color: #464646 !important;
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
            text-align:right;
        }
        .row .left {
            background: url(/public/img/bg.jpg);
            background-repeat: no-repeat;
            background-size: cover;
            border-top-right-radius: 10px;
            border-bottom-right-radius: 10px;
            text-align:right;
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
        }
    </style>
</head>
<body>
    <div class="row">
        <div class="col right">
            <div class="container">
                <a href="<?php print "/".$lang.$router->pathFor('home') ?>" class="float-left"><span class="pr-2">&larr;</span>العودة الصفحة الرئيسية</a>
                <h4>استمارة التسجيل</h4>
                <form action="<?php $router->pathFor('inscription') ?>" method="POST">
                    <div class="form-row">
                            <div class="col">
                                <div class="form-group">
                                    <label for="exampleInputEmail1">* اللقب</label>
                                    <input type="text" class="form-control">
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-group">
                                    <label for="exampleInputEmail1">* الاسم</label>
                                    <input type="text" class="form-control">
                                </div>
                            </div>
                    </div>
                    <div class="form-row">
                        <div class="col">
                            <div class="form-group">
                                <label for="exampleInputEmail1">* البريد الالكتروني</label>
                                <input type="email" class="form-control">
                            </div>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col">
                            <div class="form-group">
                                <label for="exampleInputEmail1"> * (كلمة المرور (تأكيد</label>
                                <input type="password" class="form-control">
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group">
                                <label for="exampleInputEmail1"> * كلمة المرور </label>
                                <input type="password" class="form-control">
                            </div>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col-6 offset-6">
                            <div class="form-group">
                                <label for="exampleFormControlSelect1">* هل انت ؟</label>
                                <select class="form-control" id="exampleFormControlSelect1">
                                  <option>أستاذ</option>
                                  <option>طالب</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col-4 mt-3" style="display: inline-block;">
                            <span class="float-left">(*) حقل اجباري</span>
                        </div>
                        <div class="col-4 offset-4">
                            <input type="submit" value="s'inscrire">        
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div class="col-4 left">
            <div class="container">
                <h4>التسجيل</h4>
                <p class="lead">يمكنك إنشاء حسابك هنا</p>
            </div>
        </div>
    </div>
<!-- scripts -->
<?php include './app/Views/partials/inc.js.php'  ?>
</body>
</html>