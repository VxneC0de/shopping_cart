<?php
session_start();
include "connection.php";
extract($_POST);
extract($_GET);
$fecha = date("Y-m-d");
$hora = date("h:i:s A");

switch($hidden){
    case 1:
        $query = "INSERT INTO users (email, nick, password, status) VALUES ('$email', '$nick', MD5('$password'), '0')";

        //EJECUTAR LA CONSULTA
        $result = pg_query($connection, $query);
        break;

    case 2:
        $file = $_FILES['image']['tmp_name'];
        $type = $_FILES['image']['type'];

        if(strpos($type, "gif") || strpos($type, "jpeg") || strpos($type, "jpg") || strpos($type, "png")){
            $sql = "select max(id_products) from products";
            $result = pg_query($connection, $sql);
            $row = pg_fetch_array($result);

            if (isset($row[0])){
                $max = $row[0]+1;
            }else{
                $max = 1;
            };
            
            $ext = getimagesize($file);

            if($ext[2]==1){
                $max = $max.".gif";
            };

            if($ext[2]==2){
                $max = $max.".jpg";
            };

            if($ext[2]==3){
                $max = $max.".png";
            };

            move_uploaded_file($file, '../../php3_fotos/'.$max);
            $ima = '../../../php3_fotos/'.$max;
        };
        $inse = "INSERT INTO products(name_products, description, image, price, amount, status) VALUES ('$name', '$description', '$ima', '$price', '$inventory', '0')";
        $que = pg_query($connection, $inse);
        break;

    case 3: 

        $query = "INSERT INTO cart (id_users_cart, id_products_cart, amount_cart, date_cart, hour_cart, status) VALUES ('$_SESSION[who]', '$indice', '$product_quanity', '$fecha', '$hora', '0')";

        // EJECUTAR LA CONSULTA
        $consulta = pg_query($connection, $query);
        header("location:./view/cart.php");

        break;

    case 4:

        $queryLogin = "SELECT id, email, nick FROM users WHERE password = MD5('$passwordLogin') AND nick ='$loginData' or email = '$loginData'";

        $conne=pg_query($connection, $queryLogin);

        if($v = pg_fetch_array($conne)){
        //session_start();
        $_SESSION['who'] = $v[0];
        $_SESSION['nick'] = $v[2];
        $_SESSION['email'] = $v[1];

        header("location:./view/index.php");

        }else{
        header("location:./view/login.php?answer=5");
        };

        break;

    case 5:

        session_start();
        
        session_unset();
        session_destroy();
        header("location:./view/index.php");
        
        break;
};

?>