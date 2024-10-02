<?php
require './logica/Database.php';
$actions = new Database();
$rank = $actions->getRanking();
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">

    <title>Ranking - Hero</title>

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

<body class="bg-ranking bg-cover bg-center min-h-[100vh] bg-no-repeat flex justify-start md:justify-center  bg-full flex-col md:flex-row">
    <?php
    include 'page-master/navbar.php'
    ?>
 
    <section class="grid grid-cols-2 max-w-[100%] md:max-w-[80%] w-full pt-10 md:p-8 relative p-4 md:mt-16">
        <div class="col-span-2 md:col-span-1 sticky md:relative top-0">
            <img src="images/aniversario-ranking.png" class="xl:max-w-lg hidden md:flex" alt="Aniversario hero" loading="lazy">
            <div class="flex justify-center flex-col items-center  md:hidden ">
                <img src="images/hero-aniversario.png" class="w-[200px]" alt="">
            </div>
        </div>
        <div class="col-span-2 md:col-span-1">
            <div class="grid grid-cols-3 items-end">
                <?php
                $topThree = array_slice($rank, 0, 3);

                ?>
                <?php if (isset($topThree[1])) { ?>

                    <div class="col-span-1 flex flex-col items-center">
                        <img src="images/rankingdos.png" class="max-w-[80%]" alt="2do puesto">
                        <div class="flex flex-col items-center">
                            <p class="text-[10px] md:text-base	font-black text-white uppercase text-center"><?php echo $topThree[1]['nombres']; ?></p>
                            <span class="text-yellow-500 font-semibold"><?php echo $topThree[1]['puntaje_alto']; ?></span>
                        </div>
                    </div>
                <?php } else { ?>
                    <div class="col-span-1 items-end">
                        <img src="images/rankingdos.png" class="max-w-[80%]" alt="2do puesto">

                        <div class="flex flex-col items-center">
                            <p class="text-[10px] md:text-base font-black text-white uppercase text-center">PENDIENTE</p>
                            <span class="text-yellow-500 font-semibold">00.00</span>

                        </div>
                    </div>
                <?php } ?>
                <?php if (isset($topThree[0])) { ?>
                    <div class="col-span-1 items-end">
                        <img src="images/rankinguno.png" alt="2do puesto">
                        <div class="flex flex-col items-center">
                            <p class="text-[10px] md:text-base font-black text-white uppercase text-center"><?php echo $topThree[0]['nombres']; ?></p>
                            <span class="text-yellow-500 font-semibold"><?php echo $topThree[0]['puntaje_alto']; ?></span>

                        </div>
                    </div>
                <?php } else {  ?>
                    <div class="col-span-1 items-end">
                        <img src="images/rankinguno.png" alt="2do puesto">
                        <div class="flex flex-col items-center">
                            <p class=" font-black text-white uppercase text-center">PENDIENTE</p>
                            <span class="text-yellow-500 font-semibold">00.00</span>
                        </div>
                    </div>
                <?php } ?>
                <?php if (isset($topThree[2])) { ?>

                    <div class="col-span-1 items-end">
                        <img src="images/rankingtres.png" class="max-w-[80%]" alt="2do puesto">
                        <div class="flex flex-col items-center">
                            <p class="text-[10px] md:text-base font-black text-white uppercase text-center"><?php echo $topThree[2]['nombres']; ?></p>
                            <span class="text-yellow-500 font-semibold"><?php echo $topThree[2]['puntaje_alto']; ?></span>
                        </div>
                    </div>
                <?php } else { ?>
                    <div class="col-span-1 items-end">
                        <img src="images/rankingtres.png" class="max-w-[80%]" alt="2do puesto">

                        <div class="flex flex-col items-center">
                            <p class="font-black text-white uppercase text-center">PENDIENTE</p>
                            <span class="text-yellow-500 font-semibold">00.00</span>
                        </div>
                    </div>
                <?php } ?>

            </div>
            <div>
                <div class="grid grid-cols-7 gap-1 items-center">
                    <?php
                    $pos = 0;
                    if (!$rank) {
                        echo "<p class='font-black col-span-7 mt-8 text-white uppercase text-center'>NO SE ENCONTRARON PARTICIPANTES</p>";
                    } else {
                        foreach ($rank as $data) {
                            $pos++;

                    ?>

                            <div class="col-span-1  relative">
                                <img src="images/casiellero.png" alt="Puntaje">
                                <p class="font-black text-lg md:text-4xl absolute top-0 left-0 right-0 bottom-0 flex items-center justify-center"><?php echo $pos; ?></p>
                            </div>
                            <div class="col-span-2 flex justify-center items-center">
                                <img src="images/userrank.png" alt="Ranking de usuario">
                            </div>

                            <div class="col-span-4 gap-1 relative items-center">
                                <img src="images/casilleropoint.png" alt="Casillero puntaje">

                                <div class="absolute top-0 left-0 right-0 bottom-0 flex items-center justify-between px-2 md:px-4">
                                    <p class="font-bold text-xs text-xl uppercase w-[50%] max-h-[2xl] overflow-hidden whitespace-nowrap overflow-ellipsis">
                                        <?php echo $data['nombres']; ?>
                                    </p>
                                    <div class="flex flex-col items-center">
                                        <small class="text-[10px] md:text-xs text-font-bold">PUNTAJE</small>
                                        <span class="text-[10px] md:text-lg text-registro font-black"><?php echo $data['puntaje_alto'] ?></span>
                                    </div>
                                </div>
                            </div>
                    <?php }
                    } ?>

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