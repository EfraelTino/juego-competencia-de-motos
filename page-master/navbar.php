<style>
    .header-item {
        min-width: 100vw;
        min-height: 100vh;
        background: white;
        transform: translateX(-40000px);
        /* Menú oculto */
        transition: transform 0.5s ease-in-out;
        /* Transición suave */
    }

    .header-item.active {
        transform: translateX(0);
        /* Menú visible */
    }

    .bg-wasd {
        background: #cb362a;
        padding-bottom: 2rem;
        transition: all;
        box-shadow: 10px 10px 27px 0px rgb(0 0 0 / 42%);
        -webkit-box-shadow: 10px 10px 27px 0px rgb(0 0 0 / 42%);
        -moz-box-shadow: 10px 10px 27px 0px rgb(0 0 0 / 42%);
    }

    .bg-inicio {
        background-color: white;
        color: #cb362a;
        transition: all;

    }
</style>
<nav class="pt-8 px-8 header-item fixed lg:hidden top-0 left-0 right-0 w-full z-20" id="header-item">
    <div class="flex mt-24 md:mt-0">
        <ul class="flex md:items-center md:justify-between gap-2 md:gap-8 flex-col md:flex-row">
            <li><a class="text-registro md:text-white text-lg md:text-2xl" href="./">Inicio</a></li>
            <li><a class="text-registro md:text-white text-lg md:text-2xl" href="terminos-condiciones">Términos y condiciones</a></li>
            <li><a class="text-registro md:text-white text-lg md:text-2xl" href="mecanica">Mecánica</a></li>
            <li><a class="text-registro md:text-white text-lg md:text-2xl" href="ranking">Ranking</a></li>
            <li class="mt-8 md:mt-0"><a class="text-white text-lg md:text-2xl bg-hero-red rounded-full py-2 px-4" href="login">Iniciar Sesión</a></li>
        </ul>
    </div>
</nav>

<nav class="pt-8 px-8 hidden md:block fixed  left-0 top-0  right-0 w-full z-30 flex justify-between" id="nav_pc">

    <div class="flex justify-end mt-8 md:mt-0">
        <ul class="flex md:items-center md:justify-between gap-2 md:gap-8 flex-col md:flex-row">
            <li><a class="text-registro md:text-white text-lg md:text-base lg:text-2xl" href="./">Inicio</a></li>

            <li><a class="text-registro md:text-white text-lg md:text-base lg:text-2xl" href="terminos-condiciones">Términos y condiciones</a></li>
            <li><a class="text-registro md:text-white text-lg md:text-base lg:text-2xl" href="mecanica">Mecánica</a></li>
            <li><a class="text-registro md:text-white text-lg md:text-base lg:text-2xl" href="ranking">Ranking</a></li>
            <li class="mt-8 md:mt-0"><a id="iniciar" class="text-white text-lg md:text-base lg:text-2xl bg-hero-red rounded-full py-2 px-4" href="login">Iniciar Sesión</a></li>
        </ul>
    </div>
</nav>



<div class="sticky top-0 right-0 px-4 py-2 bg-red z-[90] md:hidden bg-white grid grid-cols-5 justify-between left-0 items-center">
    <div class="col-span-2">
        <img src="./images/hero-logo-movil.webp" class="w-[200px]" alt="">
    </div>
    <div class="col-span-3 flex items-center justify-end">
        <a id="iniciar" class="text-white text-sm md:text-base lg:text-2xl bg-hero-red rounded-full py-2 px-4" href="login">Iniciar Sesión</a>
        <button id="toggle" class="text-xl rounded bg-white text-registro font-black">
            <svg id="menu-icon" xmlns="http://www.w3.org/2000/svg" width="28" height="28" fill="currentColor" class="bi bi-list" viewBox="0 0 16 16">
                <path fill-rule="evenodd" d="M2.5 12a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5m0-4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5m0-4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5" />
            </svg>
        </button>
    </div>
</div>

<script>
    window.addEventListener("scroll", function() {
        const nav = document.getElementById("nav_pc");
        const iniciar = document.getElementById("iniciar");

        // Si la página ha sido desplazada 50px o más, agrega la clase
        if (window.scrollY > 50) {
            nav.classList.add("bg-wasd");
            iniciar.classList.add("bg-inicio");
        } else {
            // Si el scroll es menor, elimina la clase
            nav.classList.remove("bg-wasd");
            iniciar.classList.remove("bg-inicio");
        }
    });

    const btnToggle = document.getElementById('toggle');
    const menuContainer = document.getElementById('header-item');
    const menuIcon = document.getElementById('menu-icon');

    const iconMenu = `
        
            <path fill-rule="evenodd" d="M2.5 12a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5m0-4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5m0-4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5" />
      
    `;

    const iconClose = `
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-x-lg" viewBox="0 0 16 16">
  <path d="M2.146 2.854a.5.5 0 1 1 .708-.708L8 7.293l5.146-5.147a.5.5 0 0 1 .708.708L8.707 8l5.147 5.146a.5.5 0 0 1-.708.708L8 8.707l-5.146 5.147a.5.5 0 0 1-.708-.708L7.293 8z"/>
</svg>
    `;

    btnToggle.addEventListener('click', () => {
        menuContainer.classList.toggle('active');

        // Alternar iconos
        if (menuContainer.classList.contains('active')) {
            menuIcon.innerHTML = iconClose; // Mostrar icono de cerrar
        } else {
            menuIcon.innerHTML = iconMenu;
        }
    });
</script>