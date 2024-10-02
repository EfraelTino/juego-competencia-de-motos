<?php
//include "../logica/conexion.php";
//include "../logica/verificarsesion.php";

$documento = '';
$tipo = '';
$id = '';
$decoded_query_string = $_GET['q'];
$query_string_decoded = base64_decode($decoded_query_string);
parse_str($query_string_decoded, $params);
$documento = $params['documento'];
$tipo = $params['tipo'];
$id = $params['id'];
$nivel = $params['nivel'];

?>
<!DOCTYPE html>

<html>

<head>
  <title>TEST MOTOROLA</title>
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
        background-color: #330445;
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
<body id="cuerpo" style="    background-image: url(images/vertical.jpg);
    overflow: hidden;
    background-size: cover;
    background-attachment: 100% 100%;
    width: 100%;">
    <div class="loader" id="loader">
        <img src="../images/preloader.svg" alt="preload">
    </div>
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
      <div id="hudi" >
        <label id="current_lap_time">TIEMPO: </label><span id="current_lap_time_value" class="value">0.0</span>
        <label id="preguntas">ITEMS: </label><span id="preguntas_valor" class="value">-</span>
        <label id="combustible">GASOLINA: </label><span id="combustible_valor" class="value">-</span>
        <label id="puntos">SCORE: </label><span id="puntos_valor" class="value">-</span>
      </div>

    </div>
    <div style="    position: absolute;
    top: 50%;
    justify-items: 50;
    left: 50%;">
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
      <div id="front" class="front" style=" z-index: 1;  "></div>

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
    <div id="id_jugador" class="value"><?php echo $id; ?> </div>
    <div id="tipo" class="value"><?php echo $tipo; ?></div>
    <div id="nivel" class="value"><?php echo $nivel; ?></div>
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
  <script src="demo.js"></script>
  <script src="index.js"></script>
  <script>
        window.addEventListener("load", function () {
            const loader = document.getElementById("loader");
            loader.classList.add("hidden");
            const body = document.querySelector("body");
            body.style.overflowX="hidden";
        });
    </script>
</body>

</html>