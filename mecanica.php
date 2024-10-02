<?php
require './logica/Database.php';
$actions = new Database();
$rank = $actions->getRanking();
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">

    <title>Mecánica - Hero</title>

    <meta property="og:type" content="website">
    <meta property="og:url" content="https://dominio.com/">
    <meta property="og:site_name" content="https://dominio.com/">
    <meta property="og:title" content="Hero">
    <meta property="og:description" content="Description">
    <meta property="og:image" content="https://dominio.com/images/og.png">
    <meta property="og:image:width" content="400">
    <meta property="og:image:height" content="400">

    <!-- HEAD -->
    <?php include 'page-master/head.php' ?>

<body class="bg-ranking bg-cover bg-center min-h-[100vh] bg-no-repeat flex justify-start md:justify-center  bg-full flex-col md:flex-row ">
    <?php
    include 'page-master/navbar.php'
    ?>

    <section class="grid grid-cols-1 md:max-w-[50%] xl:max-w-[30%] w-full  md:pt-24 md:pb-8 relative">
        <div class="bg-mecanica bg-center bg-cover bg-no-repeat h-full">
            <img src="juego/images/comojugar.png" alt="">
            <div class="grid grid-cols-7 gap-4 px-8 py-4">
                <div class="col-span-2 flex items-center justify-center"><img src="juego/images/mojugar.png" class="w-[120px]" alt=""></div>
                <div class="col-span-5">
                    <p class="text-white font-poppins ">Acelera y acumula puntos hasta que se acabe el tiempo o te quedes sin gasolina.</p>
                </div>
                <div class="col-span-2  flex items-center justify-center"><img src="juego/images/reloaod.png" lass="w-[120px]" alt=""></div>
                <div class="col-span-5">
                    <p class="text-white font-poppins ">Tienes 3 intentos para jugar, al final seleccionaremos el puntaje más alto que hayas conseguido. </p>
                </div>
                <div class="col-span-2  flex items-center justify-center"><img src="juego/images/corazon.png" class="w-[120px]" alt=""></div>
                <div class="col-span-5">
                    <p class="text-white font-poppins ">Los emblemas Hero te ayudarán a recargar gasolina y asi ganaras más puntos. </p>
                </div>
                <div class="col-span-2  flex items-center justify-center"><img src="juego/images/cono.png" class="w-[120px]" alt=""></div>
                <div class="col-span-5">
                    <p class="text-white font-poppins ">Ten cuidado con los obstáculos en el camino. Si chocas con alguno perderás gasolina.</p>
                </div>
                <div class="col-span-2  flex items-center justify-center"><img src="juego/images/rank.png" class="w-[120px]" alt=""></div>
                <div class="col-span-5">
                    <p class="text-white font-poppins ">Al finalizar, podrás revisar tu posición en el ranking una vez tu factura sea validada. </p>
                </div>
            </div>
        </div>
    </section>



    <!-- FOOTER -->
    <?php include 'page-master/footer.php' ?>



    <!-- JS -->
    <?php

    // include 'page-master/js.php' 
    ?>


</body>

</html>