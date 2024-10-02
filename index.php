<!DOCTYPE html>
<html lang="es">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">

    <title>Hero</title>

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

<body class="body-login bg-cover bg-left	 bg-no-repeat min-h-[100vh] bg-full ">
    <?php
    include 'page-master/navbar.php';
    ?>
    <section class="grid grid-cols-4">
        <img src="images/motogrande.webp" class="fixed bottom-0 z-0 w-3/4  2xl:w-2/4 2xl:left-96 bottom-0" alt="">

        <div class="col-span-4 lg:col-span-2  grid grid-cols-2 bg-banner-right bg-cover bg-opacity-50 md:bg-opacity-100  bg-left md:bg-right bg-no-repeat min-h-[100vh] pt-4 pl-4 pr-4 pb-4 md:pt-8 md:pl-8 z-10">
            <div class="col-span-2 md:col-span-1 md:pt-12">
                <img src="images/logo-participa.png" class="hidden md:flex" alt="">
                <div class="flex justify-center flex-col items-center  md:hidden ">
                    <img src="./images/hero-aniversario.png" class="w-[200px]" alt="">


                </div>
                <div class="pt-2 md:pt-10">
                    <ul class="grid gap-8">
                        <li class="font-poppins grid grid-cols-7 items-center text-white gap-4">
                            <img src="images/01.png" class="col-span-2" alt="">
                            <span class="font-poppins col-span-5 text-sm md:text-base">Compra y matricula una
                                motocicleta HERO entre el 01 de octubre y el 15 de diciembre.
                            </span>
                        </li>
                        <li class="font-poppins grid grid-cols-7 items-center text-white gap-4">
                            <img src="images/02.png" class="col-span-2" alt="">
                            <span class="font-poppins col-span-5 text-sm md:text-base">Regístrate en nuestra página web <br> <strong class="font-poppins">www.aniversariohero.com.</strong></span>
                        </li>
                        <li class="font-poppins grid grid-cols-7 items-center text-white gap-4"><img src="images/03.png" class="col-span-2" alt=""><span class="font-poppins col-span-5 text-sm md:text-base">
                                <strong class="font-poppins">Completa tus datos personales: </strong>Cedula, Nombres Completos, Correo, Celular, Ciudad, foto de la factura y número tu placa.
                            </span>
                        </li>
                        <li class="font-poppins grid grid-cols-7 items-center text-white gap-4"><img src="images/04.png" class="col-span-2" alt=""><span class="font-poppins col-span-5 text-sm md:text-base">Juega y tendrás 3 oportunidades para realizar tu mejor puntaje. Una vez validada tu factura y matrícula (previamente registrada en el RUNT), tu puntaje aparecerá en
                                el ranking.</>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="col-span-1"></div>
        </div>
        <div class="col-span-2 grid w-full justify-end pt-24 hidden lg:flex md:items-start">
            <img src="images/hero-aniversario.png" class="md:w-[50%] xl:w-[60%] 2xl:w-[65%] z-20" alt="Logo Hero">
        </div>
    </section>







    <!-- FOOTER -->
    <?php include 'page-master/footer.php' ?>



    <!-- JS -->



</body>

</html>