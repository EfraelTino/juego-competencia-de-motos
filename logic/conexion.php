<?php

$host = "localhost";
$user = "u694359124_hero";
$database = "u694359124_hero";
$pass = "0Z]3^OOu";


// $host = "localhost";
// $user = "root";
// $database = "hero";
// $pass = "";

$dblink = mysqli_connect($host, $user, $pass, $database);

if ($dblink) {
   echo "hola";
} else {
   echo "NO ESTA CONECTADO";
}
