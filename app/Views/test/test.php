<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <style>
        .trow {
            padding : 10px;
            background-color : tomato;
            border: 1px solid rgba(0,0,0,.6);
        }
    </style>
</head>
<body>
    
    <button id="btn">Clicker moi</button>
    <div class="content" id="cnt">
    </div>
    <script>
        var content_div = document.getElementById("cnt");
        var btn = document.getElementById("btn");
        btn.addEventListener("click" , function(){
            var req = new XMLHttpRequest();
            req.open('GET' , 'http://localhost:9000/posttest');
            req.onload = function(){
                var data = JSON.parse(req.responseText);
                console.log(data);
                affichier(data);
            };
            req.send();
        });
        function affichier(data){
            var content = "";
            for( i=0 ; i < data.length; i++){
                content += "<div class='trow'>"+data[i].username+"</div>";
            }
            content_div.insertAdjacentHTML('beforeend',content);
        }
    </script>
</body>
</html>