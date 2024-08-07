<?php
// Configuración de la conexión
$db_host = 'localhost'; // o el nombre del servidor donde se encuentra la base de datos
$db_name = 'shopping_cart'; // nombre de la base de datos
$db_user = 'postgres'; // usuario de la base de datos
$db_password = '123456'; // contraseña del usuario

// Crear la conexión
$conn = pg_connect("host=$db_host dbname=$db_name user=$db_user password=$db_password");

// Comprobar si la conexión fue exitosa
if (!$conn) {
    echo "Error al conectar a la base de datos: " . pg_last_error();
    exit;
} else {
    echo "Conectado a la base de datos con éxito!";
}
?>