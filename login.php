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

<body class="body-login bg-cover bg-center bg-no-repeat min-h-[100vh] bg-full ">
    <?php
    include 'page-master/navbar.php';
    ?>
    <section class="grid grid-cols-4 ">
        <img src="images/motogrande.webp" class="fixed bottom-0 z-0 -left-40 2xl:left-40 xl:top-36 bottom-0" alt="">
        <div class="col-span-4  grid grid-cols-2  lg:col-span-2  bg-banner-right bg-cover bg-opacity-50 md:bg-opacity-100  bg-left md:bg-right bg-no-repeat min-h-[100vh] pt-4 pl-4 pr-4 pb-4 md:pt-8 md:pl-8 z-10">
            <form id="formcontainer" class="grid grid-cols-2 col-span-2">
                <div class="col-span-2 md:col-span-1 md:pt-12">
                    <img src="images/herotenyears.png" class="hidden md:flex" alt="Logo principal">
                    <div class="flex justify-center flex-col items-center  md:hidden ">
                        <img src="./images/hero-aniversario.png" class="w-[200px]" alt="">


                    </div>

                    <h2 class="text-registro font-poppins font-black text-4xl text-center md:text-left md:text-6xl pt-10">REGÍSTRATE</h2>
                    <div class="pt-10">
                        <ul class="grid gap-3">
                            <li>
                                <input id="nombre" name="nombre" placeholder="Nombre Completo" class="w-full border border-slate-200 rounded-md px-3 py-2 transition duration-300 ease focus:outline-none focus:border-[#FF3333] hover:border-slate-300 shadow-sm focus:shadow bg-white  px-3 py-1" type="text">
                            </li>
                            <li>
                                <input id="email" name="email" placeholder="Email" class="w-full border border-slate-200 rounded-md px-3 py-2 transition duration-300 ease focus:outline-none focus:border-[#FF3333] hover:border-slate-300 shadow-sm focus:shadow bg-white  px-3 py-1" type="email">
                            </li>
                            <li>
                                <input id="ciudad" name="ciudad" placeholder="Ciudad" class="w-full border border-slate-200 rounded-md px-3 py-2 transition duration-300 ease focus:outline-none focus:border-[#FF3333] hover:border-slate-300 shadow-sm focus:shadow bg-white  px-3 py-1" type="text">
                            </li>
                            <li>
                                <input id="cedula" name="cedula" placeholder="Cédula" class="w-full border border-slate-200 rounded-md px-3 py-2 transition duration-300 ease focus:outline-none focus:border-[#FF3333] hover:border-slate-300 shadow-sm focus:shadow bg-white  px-3 py-1" type="number">
                            </li>
                            <li>
                                <input id="placa" name="placa" placeholder="Número de placa" class="w-full border border-slate-200 rounded-md px-3 py-2 transition duration-300 ease focus:outline-none focus:border-[#FF3333] hover:border-slate-300 shadow-sm focus:shadow bg-white  px-3 py-1" type="text">
                            </li>
                            <li>
                                <input id="telefono" name="telefono" placeholder="Teléfono / Celular" class="w-full border border-slate-200 rounded-md px-3 py-2 transition duration-300 ease focus:outline-none focus:border-[#FF3333] hover:border-slate-300 shadow-sm focus:shadow bg-white  px-3 py-1" type="number">
                            </li>
                        </ul>
                        <div id="errorMessage">

                        </div>
                    </div>
                </div>
                <div class="col-span-1"></div>
                <div class="mt-0 col-span-2 mt-14">

                    <div class="flex flex justify-center flex-col items-center space-y-6">
                        <label for="facturaimage" class="flex justify-center items-center flex-col">
                            <img id="imgFactura" src="images/subirfactura.png" alt="Subir factura" class="cursor-pointer">
                            <input id="facturaimage" type="file" class="hidden" accept=".webp, .jpg, .jpeg, .png">

                            <div id="fileFactura">

                            </div>
                        </label>

                        <label for="condiciones" class="text-white font-normal font-poppins">
                            <input required type="checkbox" name="condiciones" id="condiciones"> Acepto política de tratamiento de datos personales
                        </label>
                        <button type="submit" id="btnCargar" class="text-registro font-bold rounded bg-white py-2 px-6 flex items-center gap-1">Enviar
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                                <path fill="#FF3333" fill-rule="evenodd" d="M10.271 5.575C8.967 4.501 7 5.43 7 7.12v9.762c0 1.69 1.967 2.618 3.271 1.544l5.927-4.881a2 2 0 0 0 0-3.088l-5.927-4.88Z" clip-rule="evenodd" />
                            </svg>
                        </button>
                    </div>
                </div>
            </form>
        </div>
        <div class="col-span-2 grid w-full justify-end pt-24 hidden lg:flex md:items-start">
            <img src="images/hero-aniversario.png" class="md:w-[50%] xl:w-[60%] 2xl:w-[65%] z-20" alt="Logo Hero">
        </div>
    </section>







    <!-- FOOTER -->
    <?php include 'page-master/footer.php' ?>



    <!-- JS -->
    <?php include 'page-master/js.php' ?>


</body>

</html>