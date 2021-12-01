<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>this is a refrense for</title>
</head>
<body>
    <h1><h1>
        <?php
        echo date("y/m-d h:m:s");
        echo "<br/>";

        echo date("Y")+2-date("Y");
        echo "<br/>";

        $till_expired_old = time() + (30*24*60*60);
        $till_expired_new = strtotime('next month');

        echo '<br/>';
        echo $till_expired_old;
        echo '<br/>';
        echo $till_expired_new ;
        echo '<br/>';
        echo date('Y-m-d h:m:s' , $till_expired_new);
        echo '<br/>';


        echo 'expiration test';
        echo '<br/>';
        echo $expiredAt = date('Y-m-d',strtotime('+30 day'));
        echo ' <br/>';
        echo    $today  = date('Y-m-d',time());  
        echo '<br/>';
        $expiredAtT = strtotime($expiredAt);
        echo ($expiredAtT - time())/(60*60*24);
        // $exprired = strtotime($request);
        // $numberDays = intval($exprired);
        // echo date('d' , $exprired - time());

        ?>
    </h1></h1>
</body>
<script>
//     const xhttp = new XMLHttpRequest();

//         xhttp.onload = function () {
//             console.log("done sending", this.responseText);
//             document.getElementsByTagName('h1')[0].innerHTML = this.responseText
//         }

//         xhttp.open("post", "http://localhost:8000/api/add-product");

//         xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
//         xhttp.setRequestHeader("Accept", "application/json");
//         xhttp.setRequestHeader("Authorization","Bearer 1|RcybLqtqsMrktd3Bqdty6zCdUyQElouVRh2WreUS");
// //      xhttp.send("name=mhmd&email=a&email_confirmation=a&password=1&password_confirmation=1");
//         xhttp.send("name=a&type=b&quantity=5&price=88&contact=0909");
    

</script>
</html>