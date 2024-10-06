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

<body class="bg-terminos bg-cover bg-top min-h-[100vh] bg-no-repeat">

    <div class="flex md:hidden w-full">
        <?php
        include 'page-master/navbar.php'
        ?>
    </div>
    <section class=" w-full">

        <div class="  h-full flex w-full justify-center items-center bg-cover bg-bottom bg-no-repeat w-full  md:pt-24">
            <div class="hidden md:grid">
                <?php
                include 'page-master/navbar.php'
                ?>
            </div>
            <div class="md:max-w-[70%]  xl:max-w-[60%] grid grid-cols-5 items-center justify-center w-full px-4 py-4 md:px-4 md:py-0">
                <div class="col-span-3 md:col-span-2">
                    <img src="images/politicas.webp" class="col-span-1" alt="">
                </div>
                <div class="col-span-2 md:col-span-3 flex items-center justify-end">
                    <img src="images/logo-terminos.webp" class="col-span-3 w-[80px] md:w-[180px]" alt="">
                </div>
            </div>
        </div>
        <div class=" bg-cover bg-no-repeat flex justify-center px-4 pb-4 md:px-0">

            <div class="grid grid-cols-7 gap-4  md:max-w-[70%]  xl:max-w-[60%]">

                <div class="col-span-7 pt-8">
                    <p class="text-white font-poppins md:text-lg ">Autorizo expresa e indefinidamente a HMCL Colombia SAS., a sus establecimientos, distribuidores y en general a sus
                        representantes, empleados autorizados o responsables, para recolectar, almacenar, utilizar, circular o suprimir los datos suministrados por mí, para propósitos comerciales, promocionales, publicitarios, estadísticos, de mercadeo, gestión de
                        cobranza pre-jurídica, jurídica y relacionados con la calidad de los servicios que prestan, inclusive para contactarme,
                        comunicarme o notificarme sobre temas relacionados con sus productos y servicios.
                        <br>
                        <br>
                        También autorizo para que mis datos personales sean administrados y tratados a través de los sistemas de
                        información de HMCL Colombia SAS., de sus establecimientos, distribuidores y en general representantes, empleados autorizados o responsables.
                        <br>
                        <br>
                        Reconozco que HMCL Colombia SAS., me ha informado cuáles son las finalidades del tratamiento de los datos
                        suministrados y que conozco mis derechos referentes a la posibilidad de solicitar conocer, actualizar y rectificar mis datos personales, conocer sobre el uso que se le ha dado a mis datos personales, solicitar prueba de la presente
                        autorización, revocar mi autorización para el tratamiento o solicitar la supresión de mis datos personales.
                        <br>
                        <br>
                        Reconozco que puedo ejercer mis derechos como titular de los datos personales a través de los canales de contacto
                        dispuestos por a HMCL Colombia SAS. en su página web o por cualquier otro medio. También reconozco los derechos que tengo como titular de la información suministrada.
                    </p>
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