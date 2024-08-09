<?php

include "connection.php";
extract($_POST);

switch($hidden){
    case 1:
        $query = "INSERT INTO users (email, nick, password, status) VALUES ('$email', '$nick', MD5('$password'), '0')";

        //EJECUTAR LA CONSULTA
        $result = pg_query($connection, $query);
        break;

    case 2:
        $file = $_FILES['image']['name']['tmp_name'];
        $type = $_FILE['image']['type'];

        if(strpos($type, "gif") || strpos($type, "jpeg") || strpos($type, "jpg") || strpos($type, "png")){
            $sql = "select max(id_products) from products";
            $result = pg_query($connection, $sql);
            $row = pg_fetch_assoc($result);
            $max = $row[0]+1;
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

            move_uploaded_file($file, '../../php3_fotos/'.$file);
        };

};

?>