<?php

include "../logica/Database.php";

$actions = new Database();
if (isset($_GET['d'])) {
  // Si ambos parámetros están presentes, puedes realizar alguna acción aquí
  $documento = $_GET['d'];
  $email = $_GET['e'];
  $data = $actions->getDataWhere('usuarios', 'cedula', $documento);
  if (!$data) {
    // header("Location: ../");
  }
  $intentos = $data[0]['intentos'];
  $puntaje = $data[0]['puntaje'];
  $aumentarintento = $intentos++;
  if ($intentos >= 3) {
    header('Location:../puntaje.php');
  } else {
    $actualizar = "intentos=?";

    $condicion = "cedula=?";
    $params = [intval($aumentarintento), $documento];
    $strings = "is"; // i=integer, s=string

    $update = $actions->updateDatas("usuarios", $actualizar, $condicion, $strings, ...$params);
  }
 
} else {
  // Redirigir al índice si los parámetros no están presentes
  header("Location: ../");
  exit(); // Asegúrate de detener la ejecución del script después de redirigir
}

?>

<!DOCTYPE html>

<html>

<head>

  <!-- TikTok Pixel Code End -->
  <!-- Google tag (gtag.js) -->
  <script async src="https://www.googletagmanager.com/gtag/js?id=G-PZQDKC0PSE"></script>
  <script>
    window.dataLayer = window.dataLayer || [];

    function gtag() {
      dataLayer.push(arguments);
    }
    gtag('js', new Date());

    gtag('config', 'G-PZQDKC0PSE');
  </script>

  <!-- Google Tag Manager -->
  <script>
    (function(w, d, s, l, i) {
      w[l] = w[l] || [];
      w[l].push({
        'gtm.start': new Date().getTime(),
        event: 'gtm.js'
      });
      var f = d.getElementsByTagName(s)[0],
        j = d.createElement(s),
        dl = l != 'dataLayer' ? '&l=' + l : '';
      j.async = true;
      j.src =
        'https://www.googletagmanager.com/gtm.js?id=' + i + dl;
      f.parentNode.insertBefore(j, f);
    })(window, document, 'script', 'dataLayer', 'GTM-MQDR7LWF');
  </script>
  <!-- End Google Tag Manager -->


  <title>Hero - Aniversario de 10 años </title>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <link href="common.css" rel="stylesheet" type="text/css" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">

  <link rel="icon" type="image/png" href="../images/favicon.ico" />
  <link href="trivia.css" rel="stylesheet" type="text/css" />
  <meta http-equiv="Expires" content="0">


  <meta http-equiv="Last-Modified" content="0">

  <meta http-equiv="Cache-Control" content="no-cache, mustrevalidate">

  <meta http-equiv="Pragma" content="no-cache">
</head>
<style>
  .loader {
    background-color: #B7C5C6;
    width: 100%;
    height: 100vh;
    z-index: 1000;
    margin: 0;
    padding: 0;
    display: flex;
    justify-content: center;
    align-items: center;
  }

  .hidden {
    display: none !important;
  }

  body {
    overflow: hidden;
  }
</style>

<body id="cuerpo" style="    padding: 0;
    margin: 0;">
  <!-- Google Tag Manager (noscript) -->
  <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-MQDR7LWF"
      height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
  <!-- End Google Tag Manager (noscript) -->

  <div class="loader" id="loader">
    <img src="../images/preloader.svg" alt="preload">
  </div>
  <style>
    .bg-juego {
      position: fixed;
      top: 0;
      left: 0;
      right: 0;
      bottom: 0;
      z-index: 1;
      width: 100%;
    }

    .img-bannerarriba {
      display: none;
    }

    #hudi {
      display: block;
    }

    #hudP {
      top: 10px;
    }

    @media screen and (max-width: 949px) {
      .bg-juego {
        display: none;
      }

      #racer {
        margin: 0;
        padding: 0;
        width: 100%;
        border: none;
      }

      .img-bannerarriba {
        display: flex;
        position: relative;
        top: 0;
        left: 0;
        right: 0;
        width: 100%;
        height: auto;
        z-index: 2;


      }

      #hudP {
        display: flex;
        align-items: center;
        justify-content: center;
        top: 0;
      }

      .data-movil {
        position: absolute;
        z-index: 3;
        display: flex;
        align-items: center;
        gap: 4px;
      }

      #hudi {

        display: flex;
        justify-content: center;
        align-items: center;
        transform: translate(0);
        left: 0;
        padding: 0;
        height: 100%;
        width: 100%;
        z-index: 3;
        background-image: none !important;
        top: 0px;
        gap: 4px;

      }

      #combustible,
      #combustible_valor,
      #puntos,
      #puntos_valor {
        font-size: 18px;
        transition: all;
      }

    }

    @media screen and (max-width: 600px) {

      #combustible,
      #combustible_valor,
      #puntos,
      #puntos_valor {

        font-size: 12px;
      }
    }
  </style>
  <img src="images/front.png" alt="" class="bg-juego">
  <table id="controls" hidden>

    <tr>
      <td id="fps" colspan="2" align="right"></td>
    </tr>
    <tr>
      <th><label for="resolution">Resolution :</label></th>
      <td>
        <select id="resolution" style="width:100%">
          <option value='fine'>Fine (1280x960)</option>
          <option selected value='high'>High (1024x768)</option>
          <option value='medium'>Medium (640x480)</option>
          <option value='low'>Low (480x360)</option>
        </select>
      </td>
    </tr>
    <tr>
      <th><label for="lanes">Lanes :</label></th>
      <td>
        <select id="lanes">
          <option>1</option>
          <option>2</option>
          <option selected>3</option>
          <option>4</option>
        </select>
      </td>
    </tr>
    <tr>
      <th><label for="roadWidth">Road Width (<span id="currentRoadWidth"></span>) :</label></th>
      <td><input id="roadWidth" type='range' min='500' max='3000' title="integer (500-3000)"></td>
    </tr>
    <tr>
      <th><label for="cameraHeight">CameraHeight (<span id="currentCameraHeight"></span>) :</label></th>
      <td><input id="cameraHeight" type='range' min='500' max='5000' title="integer (500-5000)"></td>
    </tr>
    <tr>
      <th><label for="drawDistance">Draw Distance (<span id="currentDrawDistance"></span>) :</label></th>
      <td><input id="drawDistance" type='range' min='100' max='500' title="integer (100-500)"></td>
    </tr>
    <tr>
      <th><label for="fieldOfView">Field of View (<span id="currentFieldOfView"></span>) :</label></th>
      <td><input id="fieldOfView" type='range' min='80' max='140' title="integer (80-140)"></td>
    </tr>
    <tr>
      <th><label for="fogDensity">Fog Density (<span id="currentFogDensity"></span>) :</label></th>
      <td><input id="fogDensity" type='range' min='0' max='50' title="integer (0-50)"></td>
    </tr>
  </table>


  <div id="racer">
    <div id="hudP">
      <img src="images/bannermovil.png" alt="img" class="img-bannerarriba">

      <div id="hudi">
        <label hidden id="current_lap_time">TIEMPO: </label><span id="current_lap_time_value" hidden class="value">0.0</span>
        <label id="preguntas" hidden>ITEMS: </label><span hidden id="preguntas_valor" class="value">-</span>
        <label id="combustible">GASOLINA: </label><span id="combustible_valor" class="value">-</span>
        <label id="puntos">SCORE: </label><span id="puntos_valor" class="value">-</span>

      </div>


    </div>
    <div id="conpre" style="    position: relative;
    display: flex;
    justify-content: center;
    align-items: center;">
      <div id="quest" style=" z-index: 2;  padding: relative; width: 100vw; height: auto; display: none; transform: scale(.9) !important;">
        <div class="puntaje" id="puntaje"></div>
        <div class="categoria" id="categoria" style="display: none;"></div>
        <div class="numero" id="numero" style="display: none;"></div>
        <img src="#" class="imagen" id="imagen">
        <div class="pregunta" id="pregunta"></div>
        <div id="btns">
          <div class="btn" id="btn1" onclick="oprimir_btn(0)" style="height: 100%;"></div>
          <div class="btn" id="btn2" onclick="oprimir_btn(1)"></div>
          <div class="btn" id="btn3" onclick="oprimir_btn(2)"></div>
          <div class="btn" id="btn4" onclick="oprimir_btn(3)"></div>

          <div style="color: rgba(98, 20, 101, 0.853);"></div>
        </div>
      </div>


    </div>
  </div>
  <div class="maquina">
    <div id="item" class="item" style=" z-index: 2; display: none;"> </div>

    <div id="fin" class="fin" style=" z-index: 2; display: none; "></div>
    <div id="item2" class="item2" style=" z-index: 2;">
      <img src="images/instru.png" alt="" class="img-pre">
      <img src="images/instruh.png" alt="" class="img-pre2">
    </div>
    <div id="fin" class="fin" style=" z-index: 2; display: none; "></div>
    <!-- <div id="front" class="front" style=" z-index: 1;  "></div> -->

  </div>


  <style>
    #id {
      width: 150% !important;
      height: 100% !important;
      margin-left: -10% !important;
      margin-top: 43% !important;
    }
  </style>
  <div>

    <canvas id="canvas">
      Este juego no lo puedes usar en este navegador utiliza por favor uno compatible &lt;canvas&gt; element
    </canvas>
  </div>


  </div>
  <div style="display: none;">
    <span id="speed" class="hud"><span id="speed_value" class="value">HOLA</span> kmh</span></span>
    <span id="current_lap_time" class="hud">Tiempo: <span id="current_lap_time_value" class="value">0.0</span></span>
    <span id="last_lap_time" class="hud">Ultima vuelta: <span id="last_lap_time_value" class="value">0.0</span></span>
    <span id="fast_lap_time" class="hud">Mejor vuelta:<span id="fast_lap_time_value" class="value">0.0</span></span>
    <span id="puntos" class="hud">Puntaje: <span id="puntos_valor" class="value">0.0</span></span>
    <span id="preguntas" class="hud">Preguntas contestadas: <span id="preguntas_valor" class="value">0</span></span>
    <span id="tiempor" class="hud">Tiempo de respuesta: <span id="tiempor_valor" class="value">0</span></span>
    <div id="id_jugador" hidden class="value"><?php echo $id; ?> </div>
    <div id="tipo" hidden class="value"><?php echo $tipo; ?></div>
    <div id="nivel" hidden class="value"><?php echo $nivel; ?></div>
    <p hidden id="documento"><?php echo $documento ?></p>
    <p hidden id="imei"><?php echo $imei ?></p>
    <p hidden id="email"><?php echo $email ?></p>
  </div>


  <audio id='music' hidden>

    <source src="music/racer.mp3">
  </audio>
  <audio id="turbo">
    <source src="music/turbo.mp3">
  </audio>
  <audio id="gaso">
    <source src="music/gaso.mp3">
  </audio>
  <audio id="choke">
    <source src="music/pito.mp3">
  </audio>
  <span id="mute" hidden></span>
  <script src="stats.js"></script>
  <script src="common.js"></script>
  <script src="juego.js"></script>
  <script src="index.js"></script>
  <script>
    window.addEventListener("load", function() {
      const loader = document.getElementById("loader");
      loader.classList.add("hidden");
      const body = document.querySelector("body");
      body.style.overflowX = "hidden";
    });

    // var valorP = localStorage.getItem("pulso");
    // if (valorP == 1) {
    //   // alert("aca esta la vuelta");

    //   let string1 = '<id00122cunter<12ASQ332522343123wesadaw33utsdcaseta<scoreasdasdasdasdi<preguntasowqujenoiqujhlc<nombreuzdfhNWLIOKFRJWEOQODJOIQWHDYIQASDJAIOQWJEQWsdewe<vueltasENASNDBaxsandgasdhwqe<preguntasiqwenasdbajsdhasjdkajsdlsadkasdoasdqweqz<1231231231231$%1231312312213099';
    //   window.location.href = "../point.php?res=" + string1 + "&p=" + scoreFinal + "&d=" + $documento + "&i=" + $imei + "&e=" + $email;


    // }
    // localStorage.setItem("pulso", 1)
  </script>
</body>

</html>