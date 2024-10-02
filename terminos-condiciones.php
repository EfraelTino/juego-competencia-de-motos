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

<body class="bg-ranking bg-cover bg-center min-h-[100vh] bg-no-repeat flex justify-center  bg-full flex flex-col md:flex-row">
    <?php
    include 'page-master/navbar.php'
    ?>

    <section class="grid grid-cols-1 md:max-w-[70%] xl:max-w-[60%] w-full items-center  md:pt-24 md:pb-8 relative">
        <div class="bg-mecanica bg-center bg-cover bg-no-repeat">
            
            <div class="grid grid-cols-7 gap-4 px-8 py-4">
            <h3 class="text-white font-bold text-4xl w-full col-span-7">Política de privacidad                </h3>

                <div class="col-span-7">
                    <p class="text-white font-poppins ">Autorizo expresa e indefinidamente a <strong>HMCL Colombia SAS.</strong>, a sus establecimientos, distribuidores y en general a sus representantes, empleados autorizados o responsables, para recolectar, almacenar, utilizar, circular o suprimir los datos suministrados por mí, para propósitos comerciales, promocionales, publicitarios, estadísticos, de mercadeo, gestión de cobranza pre-jurídica, jurídica y relacionados con la calidad de los servicios que prestan, inclusive para contactarme, comunicarme o notificarme sobre temas relacionados con sus productos y servicios. <br /><br /> También autorizo para que mis datos personales sean administrados y tratados a través de los sistemas de información de <strong>HMCL Colombia SAS.</strong>, de sus establecimientos, distribuidores y en general representantes, empleados autorizados o responsables. <br/> <br />Reconozco que <strong>HMCL Colombia SAS.</strong>, me ha informado cuáles son las finalidades del tratamiento de los datos suministrados y que conozco mis derechos referentes a la posibilidad de solicitar conocer, actualizar y rectificar mis datos personales, conocer sobre el uso que se le ha dado a mis datos personales, solicitar prueba de la presente autorización, revocar mi autorización para el tratamiento o solicitar la supresión de mis datos personales.<br/><br />Reconozco que puedo ejercer mis derechos como titular de los datos personales a través de los canales de contacto dispuestos por a <strong>HMCL Colombia SAS.</strong> en su página web o por cualquier otro medio. También reconozco los derechos que tengo como titular de la información suministrada.</p>
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