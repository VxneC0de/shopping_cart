<?php

include "connection.php";
extract($_POST);
$date=date("Y-m-d");
$hour=date("H:i:s");

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

        $inseTwo = "INSERT INTO cart(id_users_cart, id_products_cart, amount_cart, date_cart, hour_cart, status) VALUES ('1', '$indice', '$product_quanity', '$date', '$hour', '0')";
        $queTwo = pg_query($connection, $inseTwo);

        break;
};

?>