let intentos = document.getElementById('intentos');
var vidas = 0;
var valorP = localStorage.getItem("int");
valorP++;
let datPoint = localStorage.getItem("datpt");
intentos.innerHTML= valorP;
// alert(datPoint);

localStorage.setItem("int", valorP);
if (valorP == 3) {
  // alert("Ultima oportunidad " + valorP);

}
if (valorP > 3) {
  // alert("FIN DE LOS JUEGOS " + valorP);

}

const $myCanvas = document.getElementById("canvas");
const $cuadro = document.getElementById("quest");
const $cuerpo = document.getElementById("cuerpo");
const $conpre = document.getElementById("conpre");
const $hudP = document.getElementById("hudP");
const $item = document.getElementById("item");
const $fin = document.getElementById("fin");
const $letras = document.getElementById("hudi");
const $documento = document.getElementById("documento").innerText;
const $imei = document.getElementById("imei").innerText;
const $email = document.getElementById("email").innerText;

var id = document.getElementById("id_jugador").innerText;
var windowWidth = window.innerWidth; //screen.width,window.innerWidth,document.documentElement.scrollWidth
var windowHeight = window.innerHeight;
var celu = false;

var posActual = 0;

const $item2 = document.getElementById("item2");
/*
$item2.style.scale =0.4;
$item2.style.right= -150+"px";
$item2.style.top =-150+ "px";
*/
if (windowWidth < windowHeight) {
  $myCanvas.style.width = 250 + "%";
  $myCanvas.style.height = 100 + "%";
  // $cuerpo.style.backgroundImage = "url(images/vertical.jpg)";
  $cuadro.style.marginTop = 2 + "em";
  $item.style.top = 550 + "px";
  $item.style.right = -20 + "%";
  // $fin.style.backgroundImage = "url(images/overV.png)";
  $fin.style.marginTop = 6 + "%";
  $fin.style.zIndex = 1;
  celu = true;
  /*
    $item2.style.top = 42 + "px";
    $item2.style.scale =0.5;
    $item2.style.backgroundImage = "url(images/instru.jpg)";
    let calcular = windowWidth/5.5; 
    $item2.style.right = -calcular+ "px";
    $item2.style.backgroundImage = "url(images/instru.png)";
  */

}
document.body.style.overflow = "hidden";
//Swal.fire('probando');
function preventDefault(e) {
  e.preventDefault();
}
var supportsPassive = false;
try {
  window.addEventListener(
    "test",
    null,
    Object.defineProperty({}, "passive", {
      get: function () {
        supportsPassive = true;
      },
    })
  );
} catch (e) { }
var wheelOpt = supportsPassive ? { passive: false } : false;
window.addEventListener("touchmove", preventDefault, wheelOpt);

var fps = 60; // how many 'update' frames per second
var step = 1 / fps; // how long is each frame (in seconds)
var width = 1024; // logical canvas width
var height = 768; // logical canvas height
var centrifugal = 0.3; // centrifugal force multiplier when going around curves
var offRoadDecel = 0.99; // speed multiplier when off road (e.g. you lose 2% speed each update frame)
var skySpeed = 0.0001; // background sky layer scroll speed when going around curve (or up hill)
var hillSpeed = 0.0002; // background hill layer scroll speed when going around curve (or up hill)
var treeSpeed = 0.0003; // background tree layer scroll speed when going around curve (or up hill)
var skyOffset = 0; // current sky scroll offset
var hillOffset = 0; // current hill scroll offset
var treeOffset = 0; // current tree scroll offset
var segments = []; // array of road segments
var cars = []; // array of cars on the road
var stats = Game.stats("fps"); // mr.doobs FPS counter
var canvas = Dom.get("canvas"); // our canvas...
var ctx = canvas.getContext("2d"); // ...and its drawing context
var background = null; // our background image (loaded below)
var sprites = null; // our spritesheet (loaded below)
var resolution = null; // scaling factor to provide resolution independence (computed)
var roadWidth = 2000; // actually half the roads width, easier math if the road spans from -roadWidth to +roadWidth
var segmentLength = 200; // length of a single segment
var rumbleLength = 3; // number of segments per red/white rumble strip
var trackLength = null; // z length of entire track (computed)
var lanes = 3; // number of lanes
var fieldOfView = 100; // angle (degrees) for field of view
var cameraHeight = 1000; // z height of camera
var cameraDepth = null; // z distance camera is from screen (computed)
var drawDistance = 300; // number of segments to draw
var playerX = 0; // player x offset from center of road (-1 to 1 to stay independent of roadWidth)
var playerZ = null; // player relative z distance from camera (computed)
var fogDensity = 5; // exponential fog density
var position = 0; // current camera Z position (add playerZ to get player's absolute Z position)
var speed = 0; // current speed
var maxSpeed = segmentLength / step; // top speed (ensure we can't move more than 1 segment in a single frame to make collision detection easier)
var accel = maxSpeed / 5; // acceleration rate - tuned until it 'felt' right
var breaking = -maxSpeed; // deceleration rate when braking
var decel = -maxSpeed / 5; // 'natural' deceleration rate when neither accelerating, nor braking
var offRoadDecel = -maxSpeed / 2; // off road deceleration is somewhere in between
var offRoadLimit = maxSpeed / 4; // limit when off road deceleration no longer applies (e.g. you can always go at least this speed even when off road)
var totalCars = 400; // total number of cars on the road 400
var currentLapTime = 0; // current lap time
var lastLapTime = null; // last lap time
var keyLeft = false;
var keyRight = false;
var keyFaster = false;
var keySlower = false;
var gasolina = 100;
var tanque = 10;
var gameOver = false;
var failPregunta = 0;
var bloqueo = false;
var vuelta = 1;
var botoness = null;
var scoreFinal = 0;
var transmitir = false;
var items = 0;
var nomas = false;
var contDeath = 0;
var bono = 0;
var hud = {
  speed: { value: null, dom: Dom.get("speed_value") },
  current_lap_time: { value: null, dom: Dom.get("current_lap_time_value") },
  last_lap_time: { value: null, dom: Dom.get("last_lap_time_value") },
  fast_lap_time: { value: null, dom: Dom.get("fast_lap_time_value") },
  puntos: { value: null, dom: Dom.get("puntos_valor") },
  preguntas: { value: null, dom: Dom.get("preguntas_valor") },
  tiempor: { value: null, dom: Dom.get("tiempor_valor") },
  combustible: { value: null, dom: Dom.get("combustible_valor") },
};
//=========================================================================
// UPDATE THE GAME WORLD
//=========================================================================
var segundos = 0;

var llenadoOK = false;
function recargaOIL(cantidad) {
  if (!llenadoOK) {
    if (gasolina < 1) {
      gasolina = 10;
    } else {
      gasolina = gasolina + cantidad;
    }

    llenadoOK = true;
  }

  $item.style.background = "url(images/carga.gif)";
  $item.style.display = "block";
  Game.playGaso();
  segundos = 0;

  // console.log(position + " " + playerX + " " + speed + " " + gasolina);
}
function recargaGAS() {
  if (!llenadoOK) {
    if (gasolina < 0) {
      gasolina = 7;
    } else {
      gasolina = gasolina + 5;
    }
    llenadoOK = true;
  }
}
var enviarOK = false;
function finEnviarBD() {
  let banner = document.querySelector('.bannerfuera');

  if (!enviarOK) {
    enviarOK=true;
   
    // alert("Puntuacion Final " + bono + " ---- " + datPoint);

    banner.style.display="flex";

  }
  /*
  if(!enviarOK){
    enviarOK=true;
    console.log(scoreFinal + " documento: " + $documento + " imei: " + $imei);
    let string1 = '<id00122cunter<12ASQ332522343123wesadaw33utsdcaseta<scoreasdasdasdasdi<preguntasowqujenoiqujhlc<nombreuzdfhNWLIOKFRJWEOQODJOIQWHDYIQASDJAIOQWJEQWsdewe<vueltasENASNDBaxsandgasdhwqe<preguntasiqwenasdbajsdhasjdkajsdlsadkasdoasdqweqz<1231231231231$%1231312312213099';
    window.location.href = "../enviarcorreo.php?res=" + string1 + "&p=" + bono.toFixed(0) + "&d=" + $documento + "&i=" + $imei +"&e=" +$email;
  }
  */
}
async function update(dt) {
  var n, car, carW, sprite, spriteW;
  var playerSegment = findSegment(position + playerZ);
  var playerW = SPRITES.PLAYER_STRAIGHT.w * SPRITES.SCALE;
  var speedPercent = speed / maxSpeed;
  var dx = dt * 2 * speedPercent; // at top speed, should be able to cross from left to right (-1 to 1) in 1 second
  var startPosition = position;

  // scoreFinal = hud.puntos.value;
  // console.log(hud.puntos.value);

  updateCars(dt, playerSegment, playerW);
  inicia();
  position = Util.increase(position, dt * speed, trackLength);
  // console.log(position+" "+playerX+" "+speed);

  if ($cuadro.style.display == "block") {
    keyFaster = false;
    keyLeft = false;
    keyRight = false;
  } else {
    okey = false;
  }

  if (preguntas_correctas > 0) {
  }
  if (incorrectasPRE > 1) {
    // console.log("INCORRECTA FIN");
    gasolina = -5;
    incorrectasPRE = 0;
  }
  if (okey) {
    //console.log("correcto amigo!!!");

    recargaOIL(8);
  }
  if (speed > 10999) {
    bloqueo = false;
    llenadoOK = false;
  }

  //*****************************************************ITEMS EN EL CAMPO!!!! nitros
  if (position > 7000 && position < 7100) {
    if (playerX > -0.1 && playerX < 0.3) {
      if (!nomas) {
        speed = 12000;
        recargaGAS();
        Game.playTurbo();
        items++;
        nomas = true;
        contDeath = 0;
      }
    }
  }
  if (position > 299398 && position < 299600) {
    if (playerX > -0.1 && playerX < 0.3) {
      if (!nomas) {
        speed = 12000;
        recargaGAS();
        Game.playTurbo();
        items++;
        nomas = true;
        contDeath = 0;
      }
    }
  }
  if (position > 499000 && position < 499500) {
    if (playerX > -0.1 && playerX < 0.3) {
      if (!nomas) {
        speed = 12000;
        recargaOIL(16);
        Game.playTurbo();
        items++;
        nomas = true;
        contDeath = 0;
      }
    }
  }

  //****************************************************************preguntas  */

  if (position > 119200 && position < 119400) {
    bloqueoPregunta();
  }
  if (position > 399300 && position < 399500) {
    bloqueoPregunta();
  }

  if (position > 599000 && position < 599200) {
    bloqueoPregunta();
  }
  if (position > 799018 && position < 799218) {
    bloqueoPregunta();
  }
  if (position > 999141 && position < 999341) {
    bloqueoPregunta();
  }
  //************************************Gasolina ************************* */

  if (position > 198900 && position < 199100) {
    if (playerX > -0.35 && playerX < 0.35) {
      recargaOIL(11);
    }
  }

  if (position > 359000 && position < 359237) {
    if (playerX > -0.35 && playerX < 0.35) {
      recargaOIL(11);
    }
  }

  if (position > 579000 && position < 579250) {
    if (playerX > -0.35 && playerX < 0.35) {
      recargaOIL(11);
    }
  }
  if (position > 899280 && position < 899380) {
    if (playerX > -0.35 && playerX < 0.35) {
      recargaOIL(11);
    }
  }
  if (position > 1098924 && position < 1099300) {
    if (playerX > -0.35 && playerX < 0.35) {
      recargaOIL(9);
    }
  }
  //  console.log(gasolina);
  if (gasolina < 1) {
    if (!gameOver) {
      $item.style.background = "url(images/vacio.png)";
      $item.style.display = "block";
      gameOver = true;
      // console.log("Fin del Juego");
    }

    if (gasolina < -6) {
      finEnviarBD();
      $fin.style.display = "block";
      $item.style.display = "none";
    }
    if (gasolina < -8) {
      console.log("a1ca se ejecuta");
      finEnviarBD();
    }
    keyFaster = false;
  }
  //console.log(playerX);

  //*******************************************************
  if (keyLeft) playerX = playerX - dx;
  else if (keyRight) playerX = playerX + dx;

  playerX = playerX - dx * speedPercent * playerSegment.curve * centrifugal;

  if (keyFaster) {
    Game.playMusic();
    $item2.style.display = "none";
    speed = Util.accelerate(speed, accel, dt);
  } else if (keySlower) speed = Util.accelerate(speed, breaking, dt);
  else speed = Util.accelerate(speed, decel, dt);

  if (playerX < -1 || playerX > 1) {
    if (speed > offRoadLimit) speed = Util.accelerate(speed, offRoadDecel, dt);

    for (n = 0; n < playerSegment.sprites.length; n++) {
      sprite = playerSegment.sprites[n];
      spriteW = sprite.source.w * SPRITES.SCALE;
      if (
        Util.overlap(
          playerX,
          playerW,
          sprite.offset + (spriteW / 2) * (sprite.offset > 0 ? 1 : -1),
          spriteW
        )
      ) {
        speed = maxSpeed / 5;
        position = Util.increase(
          playerSegment.p1.world.z,
          -playerZ,
          trackLength
        ); // stop in front of sprite (at front of segment)
        break;
      }
    }
  }

  for (n = 0; n < playerSegment.cars.length; n++) {
    car = playerSegment.cars[n];
    carW = car.sprite.w * SPRITES.SCALE;
    if (speed > car.speed) {
      if (Util.overlap(playerX, playerW, car.offset, carW, 0.8)) {
        speed = car.speed * (car.speed / speed);
        position = Util.increase(car.z, -playerZ, trackLength);
        //console.log(vuelta);
        speed = 0;
        gasolina -= 5 + vuelta;
        console.log(carW);
        Game.playChoke();
        // vidas++;
        if (carW == 0.48) {
          //car.speed=1000;
          console.log("CAMION!!");
          // keyFaster = false;
          //$pregunt.style.display="block";
        }
        /*
        if (vidas >= 3 && !finVidas) {
          finVidas = true;
          gasolina = 0;
        }
        */
        break;
      }
    }
  }

  playerX = Util.limit(playerX, -3, 3); // dont ever let it go too far out of bounds
  speed = Util.limit(speed, 0, maxSpeed); // or exceed maxSpeed

  skyOffset = Util.increase(
    skyOffset,
    (skySpeed * playerSegment.curve * (position - startPosition)) /
    segmentLength,
    1
  );
  hillOffset = Util.increase(
    hillOffset,
    (hillSpeed * playerSegment.curve * (position - startPosition)) /
    segmentLength,
    1
  );
  treeOffset = Util.increase(
    treeOffset,
    (treeSpeed * playerSegment.curve * (position - startPosition)) /
    segmentLength,
    1
  );

  if (position > playerZ && !gameOver) {
    if (currentLapTime && startPosition < playerZ) {
      // console.log("----------------------VUELTA---------------------------------"+vuelta);
      vuelta++;
      lastLapTime = currentLapTime;
      // currentLapTime = 0;
      if (lastLapTime <= Util.toFloat(Dom.storage.fast_lap_time)) {
        Dom.storage.fast_lap_time = lastLapTime;
        updateHud("fast_lap_time", formatTime(lastLapTime));
        Dom.addClassName("fast_lap_time", "fastest");
        Dom.addClassName("last_lap_time", "fastest");
        // console.log("----------------------MEJOR---------------------------------");
      } else {
        Dom.removeClassName("fast_lap_time", "fastest");
        Dom.removeClassName("last_lap_time", "fastest");
      }
      updateHud("last_lap_time", formatTime(lastLapTime));
      Dom.show("last_lap_time");
    } else {
      if (posActual != position) {
        posActual = position;
        currentLapTime += dt;
        segundos += dt;
      }
      contDeath++;

      if (contDeath > 100) {
        console.log(contDeath);
        nomas = false;
        contDeath = 0;
      }

      iniciar = true;

      if (segundos > 5 && !gameOver) {
        $item.style.display = "none";
      }
      //console.log(segundos);
    }
  }
  if (position > playerZ) {
    gasolina -= dt;
  }

  updateHud("speed", 5 * Math.round(speed / 500));
  //updateHud('current_lap_time', formatTime(currentLapTime));
  updateHud("current_lap_time", formatTime(currentLapTime));
  updateHud("preguntas", preguntas_correctas);

  if (gasolina < 1) {
    updateHud("combustible", Util.toInt(0, 0));
  } else {
    updateHud("combustible", Util.toInt(gasolina, 0));
  }

  if (preguntas_correctas != 0 && gameOver) {
    // puntaje = (preguntas_correctas * 100) + currentLapTime;
  } else {
    // console.log(position, scoreFinal+ " "+puntaje+" aca");

    puntaje = currentLapTime;
  }
  let multiplica = items + 1;
  bono = puntaje * multiplica;
  //console.log(bono);
  if (bono > datPoint) {
    localStorage.setItem("datpt", bono);
  }
  updateHud("puntos", Util.toInt(bono));
  updateHud("preguntas", Util.toInt(items));
}
//**************************************************************************
function bloqueoPregunta() {
  if (!bloqueo) {
    // $cuadro.style.display = "block";
    // const $btns = document.getElementById("btns");
    // keyFaster = true;
    // bloqueo = true;
    // speed = 0;
  }
}
function inicia() { }

let canvasA = document.getElementById("canvas");

function canvas_read_mouse(canvasA, e) {
  let canvasRect = canvas.getBoundingClientRect();
}

function on_canvas_mouse_down(e) {
  canvas_read_mouse(canvasA, e);
  canvasA.tc_md = true;
}

function on_canvas_mouse_up(e) {
  canvasA.tc_md = false;
}

function on_canvas_mouse_move(e) {
  canvas_read_mouse(canvasA, e);
}

function canvas_read_touch(canvasA, e) {
  let canvasRect = canvasA.getBoundingClientRect();
  let touch = event.touches[0];
  // console.log(touch.pageY + " / " + touch.pageX);
  if (touch.pageX < 250) {
    keyLeft = true;
    keyRight = false;
  }
  if (touch.pageX > 300) {
    keyRight = true;
    keyLeft = false;
  }
  if (touch.pageY > 500) {
    keyFaster = false;
  }
}

function on_canvas_touch_start(e) {
  canvas_read_touch(canvasA, e);
  canvasA.tc_md = true;
}

function on_canvas_touch_end(e) {
  canvasA.tc_md = false;
  //console.log("centro");
  keyFaster = true;
  keyLeft = false;
  keyRight = false;
}

function on_canvas_touch_move(e) {
  canvas_read_touch(canvasA, e);
}

canvasA.addEventListener(
  "mousedown",
  (e) => {
    on_canvas_mouse_down(e);
  },
  false
);
canvasA.addEventListener(
  "mouseup",
  (e) => {
    on_canvas_mouse_up(e);
  },
  false
);
canvasA.addEventListener(
  "mousemove",
  (e) => {
    on_canvas_mouse_move(e);
  },
  false
);
canvasA.addEventListener(
  "touchstart",
  (e) => {
    on_canvas_touch_start(e);
  },
  false
);
canvasA.addEventListener(
  "touchend",
  (e) => {
    on_canvas_touch_end(e);
  },
  false
);
canvasA.addEventListener(
  "touchmove",
  (e) => {
    on_canvas_touch_move(e);
  },
  false
);
//-------------------------------------------------------------------------

function updateCars(dt, playerSegment, playerW) {
  var n, car, oldSegment, newSegment;
  for (n = 0; n < cars.length; n++) {
    car = cars[n];
    oldSegment = findSegment(car.z);
    car.offset =
      car.offset + updateCarOffset(car, oldSegment, playerSegment, playerW);
    car.z = Util.increase(car.z, dt * car.speed, trackLength);
    car.percent = Util.percentRemaining(car.z, segmentLength); // useful for interpolation during rendering phase
    newSegment = findSegment(car.z);
    if (oldSegment != newSegment) {
      index = oldSegment.cars.indexOf(car);
      oldSegment.cars.splice(index, 1);
      newSegment.cars.push(car);
    }
  }
}

function updateCarOffset(car, carSegment, playerSegment, playerW) {
  var i,
    j,
    dir,
    segment,
    otherCar,
    otherCarW,
    lookahead = 20,
    carW = car.sprite.w * SPRITES.SCALE;

  // optimization, dont bother steering around other cars when 'out of sight' of the player
  if (carSegment.index - playerSegment.index > drawDistance) return 0;

  for (i = 1; i < lookahead; i++) {
    segment = segments[(carSegment.index + i) % segments.length];

    if (
      segment === playerSegment &&
      car.speed > speed &&
      Util.overlap(playerX, playerW, car.offset, carW, 1.2)
    ) {
      if (playerX > 0.5) dir = -1;
      else if (playerX < -0.5) dir = 1;
      else dir = car.offset > playerX ? 1 : -1;
      return (((dir * 1) / i) * (car.speed - speed)) / maxSpeed; // the closer the cars (smaller i) and the greated the speed ratio, the larger the offset
    }

    for (j = 0; j < segment.cars.length; j++) {
      otherCar = segment.cars[j];
      otherCarW = otherCar.sprite.w * SPRITES.SCALE;
      if (
        car.speed > otherCar.speed &&
        Util.overlap(car.offset, carW, otherCar.offset, otherCarW, 1.2)
      ) {
        if (otherCar.offset > 0.5) dir = -1;
        else if (otherCar.offset < -0.5) dir = 1;
        else dir = car.offset > otherCar.offset ? 1 : -1;
        return (((dir * 1) / i) * (car.speed - otherCar.speed)) / maxSpeed;
      }
    }
  }

  // if no cars ahead, but I have somehow ended up off road, then steer back on
  if (car.offset < -0.9) return 0.1;
  else if (car.offset > 0.9) return -0.1;
  else return 0;
}

//-------------------------------------------------------------------------

function updateHud(key, value) {
  // accessing DOM can be slow, so only do it if value has changed
  if (hud[key].value !== value) {
    hud[key].value = value;
    Dom.set(hud[key].dom, value);
  }
}

function formatTime(dt) {
  var minutes = Math.floor(dt / 60);
  var seconds = Math.floor(dt - minutes * 60);
  var tenths = Math.floor(10 * (dt - Math.floor(dt)));
  if (minutes > 0)
    return minutes + "." + (seconds < 10 ? "0" : "") + seconds + "." + tenths;
  else return seconds + "." + tenths;
}

//=========================================================================
// RENDER THE GAME WORLD
//=========================================================================
var img = new Image(); //Creates an HTMLImageElement
img.src = "images/izq.png";
var img2 = new Image(); //Creates an HTMLImageElement
img2.src = "images/der.png";
var img3 = new Image();
img3.src = "images/corazon.png";
var img4 = new Image();
img4.src = "images/live.png";

var dibujar = false;
var finVidas = false;
vidas = valorP;
if (vidas > 3) {
  vidas = 3;
}
function render() {
  var baseSegment = findSegment(position);
  var basePercent = Util.percentRemaining(position, segmentLength);
  var playerSegment = findSegment(position + playerZ);
  var playerPercent = Util.percentRemaining(position + playerZ, segmentLength);
  var playerY = Util.interpolate(
    playerSegment.p1.world.y,
    playerSegment.p2.world.y,
    playerPercent
  );
  var maxy = height;

  var x = 0;
  var dx = -(baseSegment.curve * basePercent);

  ctx.clearRect(0, 0, width, height);

  Render.background(
    ctx,
    background,
    width,
    height,
    BACKGROUND.SKY,
    skyOffset,
    resolution * skySpeed * playerY
  );
  Render.background(
    ctx,
    background,
    width,
    height,
    BACKGROUND.HILLS,
    hillOffset,
    resolution * hillSpeed * playerY
  );
  Render.background(
    ctx,
    background,
    width,
    height,
    BACKGROUND.TREES,
    treeOffset,
    resolution * treeSpeed * playerY
  );
  // Render.sprite(ctx, background, 130, 130, BACKGROUND.IZQUIERDA, 0, 10);

  if (celu) {
    let altura = 90;
    ctx.drawImage(img, width / 5, 100);
    ctx.drawImage(img2, width / 2.1, 100);
    ctx.drawImage(img3, 310, altura);
    ctx.drawImage(img3, 360, altura);
    ctx.drawImage(img3, 410, altura);
    //  ctx.drawImage(img3, 460, altura);
    // ctx.drawImage(img3, 510, altura);
    switch (vidas) {
      case 1:
        ctx.drawImage(img4, 310, altura);
        break;
      case 2:
        ctx.drawImage(img4, 310, altura);
        ctx.drawImage(img4, 360, altura);
        break;
      case 3:
        ctx.drawImage(img4, 310, altura);
        ctx.drawImage(img4, 360, altura);
        ctx.drawImage(img4, 410, altura);
        break;
        /*
      case 4:
        ctx.drawImage(img4, 510, altura);
        ctx.drawImage(img4, 460, altura);
        ctx.drawImage(img4, 410, altura);
        ctx.drawImage(img4, 360, altura);
        break;
      case 5:
        ctx.drawImage(img4, 510, altura);
        ctx.drawImage(img4, 460, altura);
        ctx.drawImage(img4, 410, altura);
        */
        // ctx.drawImage(img4, 360, altura);
        // ctx.drawImage(img4, 310, altura);
        break;
    }
  } else {
    if (!dibujar) {
      // ctx.globalAlpha = 0.5;
      ctx.drawImage(img3, 110, 120);
      ctx.drawImage(img3, 160, 120);
      ctx.drawImage(img3, 210, 120);
      //  ctx.drawImage(img3, 260, 120);
      //   ctx.drawImage(img3, 310, 120);
      //dibujar=true;
    }
    switch (vidas) {
      case 1:
        ctx.drawImage(img4, 110, 120);
        break;
      case 2:
        ctx.drawImage(img4, 110, 120);
        ctx.drawImage(img4, 160, 120);
        break;
      case 3:
        ctx.drawImage(img4, 110, 120);
        ctx.drawImage(img4, 160, 120);
        ctx.drawImage(img4, 210, 120);
        break;
        /*
      case 4:
        ctx.drawImage(img4, 160, 120);
        ctx.drawImage(img4, 210, 120);
        ctx.drawImage(img4, 260, 120);
        ctx.drawImage(img4, 310, 120);
        
        break;
      case 5:
        ctx.drawImage(img4, 110, 120);
        ctx.drawImage(img4, 160, 120);
        ctx.drawImage(img4, 210, 120);
        */
        // ctx.drawImage(img4, 260, 120);
        // ctx.drawImage(img4, 310, 120);


        break;
    }
    console.log(vidas);
  }


  var n, i, segment, car, sprite, spriteScale, spriteX, spriteY;

  for (n = 0; n < drawDistance; n++) {
    segment = segments[(baseSegment.index + n) % segments.length];
    segment.looped = segment.index < baseSegment.index;
    segment.fog = Util.exponentialFog(n / drawDistance, fogDensity);
    segment.clip = maxy;

    Util.project(
      segment.p1,
      playerX * roadWidth - x,
      playerY + cameraHeight,
      position - (segment.looped ? trackLength : 0),
      cameraDepth,
      width,
      height,
      roadWidth
    );
    Util.project(
      segment.p2,
      playerX * roadWidth - x - dx,
      playerY + cameraHeight,
      position - (segment.looped ? trackLength : 0),
      cameraDepth,
      width,
      height,
      roadWidth
    );

    x = x + dx;
    dx = dx + segment.curve;

    if (
      segment.p1.camera.z <= cameraDepth || // behind us
      segment.p2.screen.y >= segment.p1.screen.y || // back face cull
      segment.p2.screen.y >= maxy
    )
      // clip by (already rendered) hill
      continue;

    Render.segment(
      ctx,
      width,
      lanes,
      segment.p1.screen.x,
      segment.p1.screen.y,
      segment.p1.screen.w,
      segment.p2.screen.x,
      segment.p2.screen.y,
      segment.p2.screen.w,
      segment.fog,
      segment.color
    );

    maxy = segment.p1.screen.y;
  }

  for (n = drawDistance - 1; n > 0; n--) {
    segment = segments[(baseSegment.index + n) % segments.length];

    for (i = 0; i < segment.cars.length; i++) {
      car = segment.cars[i];
      sprite = car.sprite;
      spriteScale = Util.interpolate(
        segment.p1.screen.scale,
        segment.p2.screen.scale,
        car.percent
      );
      spriteX =
        Util.interpolate(
          segment.p1.screen.x,
          segment.p2.screen.x,
          car.percent
        ) +
        (spriteScale * car.offset * roadWidth * width) / 2;
      spriteY = Util.interpolate(
        segment.p1.screen.y,
        segment.p2.screen.y,
        car.percent
      );
      Render.sprite(
        ctx,
        width,
        height,
        resolution,
        roadWidth,
        sprites,
        car.sprite,
        spriteScale,
        spriteX,
        spriteY,
        -0.5,
        -1,
        segment.clip
      );
    }

    for (i = 0; i < segment.sprites.length; i++) {
      sprite = segment.sprites[i];
      spriteScale = segment.p1.screen.scale;
      spriteX =
        segment.p1.screen.x +
        (spriteScale * sprite.offset * roadWidth * width) / 2;
      spriteY = segment.p1.screen.y;
      Render.sprite(
        ctx,
        width,
        height,
        resolution,
        roadWidth,
        sprites,
        sprite.source,
        spriteScale,
        spriteX,
        spriteY,
        sprite.offset < 0 ? -1 : 0,
        -1,
        segment.clip
      );
    }

    if (segment == playerSegment) {
      Render.player(
        ctx,
        width,
        height,
        resolution,
        roadWidth,
        sprites,
        speed / maxSpeed,
        cameraDepth / playerZ,
        width / 2,
        height / 2 -
        ((cameraDepth / playerZ) *
          Util.interpolate(
            playerSegment.p1.camera.y,
            playerSegment.p2.camera.y,
            playerPercent
          ) *
          height) /
        2,
        speed * (keyLeft ? -1 : keyRight ? 1 : 0),
        playerSegment.p2.world.y - playerSegment.p1.world.y
      );
    }
  }
}

function findSegment(z) {
  return segments[Math.floor(z / segmentLength) % segments.length];
}

//=========================================================================
// BUILD ROAD GEOMETRY
//=========================================================================

function lastY() {
  return segments.length == 0 ? 0 : segments[segments.length - 1].p2.world.y;
}

function addSegment(curve, y) {
  var n = segments.length;
  segments.push({
    index: n,
    p1: { world: { y: lastY(), z: n * segmentLength }, camera: {}, screen: {} },
    p2: { world: { y: y, z: (n + 1) * segmentLength }, camera: {}, screen: {} },
    curve: curve,
    sprites: [],
    cars: [],
    color: Math.floor(n / rumbleLength) % 2 ? COLORS.DARK : COLORS.LIGHT,
  });
}

function addSprite(n, sprite, offset) {
  segments[n].sprites.push({ source: sprite, offset: offset });
}

function addRoad(enter, hold, leave, curve, y) {
  var startY = lastY();
  var endY = startY + Util.toInt(y, 0) * segmentLength;
  var n,
    total = enter + hold + leave;
  for (n = 0; n < enter; n++)
    addSegment(
      Util.easeIn(0, curve, n / enter),
      Util.easeInOut(startY, endY, n / total)
    );
  for (n = 0; n < hold; n++)
    addSegment(curve, Util.easeInOut(startY, endY, (enter + n) / total));
  for (n = 0; n < leave; n++)
    addSegment(
      Util.easeInOut(curve, 0, n / leave),
      Util.easeInOut(startY, endY, (enter + hold + n) / total)
    );
}

var ROAD = {
  LENGTH: { NONE: 0, SHORT: 25, MEDIUM: 50, LONG: 100 },
  HILL: { NONE: 0, LOW: 20, MEDIUM: 40, HIGH: 60 },
  CURVE: { NONE: 0, EASY: 2, MEDIUM: 4, HARD: 6 },
};

function addStraight(num) {
  num = num || ROAD.LENGTH.MEDIUM;
  addRoad(num, num, num, 0, 0);
}

function addHill(num, height) {
  num = num || ROAD.LENGTH.MEDIUM;
  height = height || ROAD.HILL.MEDIUM;
  addRoad(num, num, num, 0, height);
}

function addCurve(num, curve, height) {
  num = num || ROAD.LENGTH.MEDIUM;
  curve = curve || ROAD.CURVE.MEDIUM;
  height = height || ROAD.HILL.NONE;
  addRoad(num, num, num, curve, height);
}

function addLowRollingHills(num, height) {
  num = num || ROAD.LENGTH.SHORT;
  height = height || ROAD.HILL.LOW;
  addRoad(num, num, num, 0, height / 2);
  addRoad(num, num, num, 0, -height);
  addRoad(num, num, num, ROAD.CURVE.EASY, height);
  addRoad(num, num, num, 0, 0);
  addRoad(num, num, num, -ROAD.CURVE.EASY, height / 2);
  addRoad(num, num, num, 0, 0);
}

function addSCurves() {
  addRoad(
    ROAD.LENGTH.MEDIUM,
    ROAD.LENGTH.MEDIUM,
    ROAD.LENGTH.MEDIUM,
    -ROAD.CURVE.EASY,
    ROAD.HILL.NONE
  );
  addRoad(
    ROAD.LENGTH.MEDIUM,
    ROAD.LENGTH.MEDIUM,
    ROAD.LENGTH.MEDIUM,
    ROAD.CURVE.MEDIUM,
    ROAD.HILL.MEDIUM
  );
  addRoad(
    ROAD.LENGTH.MEDIUM,
    ROAD.LENGTH.MEDIUM,
    ROAD.LENGTH.MEDIUM,
    ROAD.CURVE.EASY,
    -ROAD.HILL.LOW
  );
  addRoad(
    ROAD.LENGTH.MEDIUM,
    ROAD.LENGTH.MEDIUM,
    ROAD.LENGTH.MEDIUM,
    -ROAD.CURVE.EASY,
    ROAD.HILL.MEDIUM
  );
  addRoad(
    ROAD.LENGTH.MEDIUM,
    ROAD.LENGTH.MEDIUM,
    ROAD.LENGTH.MEDIUM,
    -ROAD.CURVE.MEDIUM,
    -ROAD.HILL.MEDIUM
  );
}

function addBumps() {
  addRoad(10, 10, 10, 0, 5);
  addRoad(10, 10, 10, 0, -2);
  addRoad(10, 10, 10, 0, -5);
  addRoad(10, 10, 10, 0, 8);
  addRoad(10, 10, 10, 0, 5);
  addRoad(10, 10, 10, 0, -7);
  addRoad(10, 10, 10, 0, 5);
  addRoad(10, 10, 10, 0, -2);
}

function addDownhillToEnd(num) {
  num = num || 200;
  addRoad(num, num, num, -ROAD.CURVE.EASY, -lastY() / segmentLength);
}

function resetRoad() {
  segments = [];

  addStraight(ROAD.LENGTH.SHORT);
  addLowRollingHills();
  addBumps();
  addSCurves();
  addCurve(ROAD.LENGTH.MEDIUM, ROAD.CURVE.MEDIUM, ROAD.HILL.LOW);
  addBumps();
  addLowRollingHills();
  addCurve(ROAD.LENGTH.LONG * 2, ROAD.CURVE.MEDIUM, ROAD.HILL.MEDIUM);
  addStraight();
  addHill(ROAD.LENGTH.MEDIUM, ROAD.HILL.HIGH);
  addSCurves();
  addCurve(ROAD.LENGTH.MEDIUM, -ROAD.CURVE.HARD, -ROAD.HILL.LOW);
  addCurve(ROAD.LENGTH.MEDIUM, ROAD.CURVE.HARD, ROAD.HILL.LOW);
  addStraight(ROAD.LENGTH.SHORT / 2);
  addCurve(ROAD.LENGTH.LONG, -ROAD.CURVE.MEDIUM, ROAD.HILL.NONE);
  addHill(ROAD.LENGTH.LONG, ROAD.HILL.HIGH);
  addCurve(ROAD.LENGTH.LONG, ROAD.CURVE.MEDIUM, -ROAD.HILL.LOW);
  addBumps();
  addHill(ROAD.LENGTH.LONG, -ROAD.HILL.MEDIUM);
  addStraight();
  addSCurves();
  addDownhillToEnd();

  resetSprites();
  resetCars();

  segments[findSegment(playerZ).index + 2].color = COLORS.START;
  segments[findSegment(playerZ).index + 3].color = COLORS.START;
  for (var n = 0; n < rumbleLength; n++)
    segments[segments.length - 1 - n].color = COLORS.FINISH;

  trackLength = segments.length * segmentLength;
}

function resetSprites() {
  var n, i;
  addSprite(5, SPRITES.META, -0.15);
  addSprite(5, SPRITES.META, 0.15);

  addSprite(15, SPRITES.tablero1, 1);
  addSprite(25, SPRITES.tablero2, 1);
  addSprite(38, SPRITES.tablero3, 1);
  addSprite(55, SPRITES.tablero4, 1);
  addSprite(75, SPRITES.tablero5, 1);
  addSprite(100, SPRITES.tablero6, 1);
  addSprite(130, SPRITES.tablero7, 1);
  addSprite(160, SPRITES.tablero8, 1);

  addSprite(15, SPRITES.tablero9, -1);
  addSprite(30, SPRITES.tablero10, -1);
  addSprite(50, SPRITES.tablero11, -1);
  addSprite(80, SPRITES.tablero12, -1);
  addSprite(120, SPRITES.tablero13, -1);
  addSprite(150, SPRITES.tablero14, -1);
  addSprite(190, SPRITES.tablero15, -1);
  addSprite(220, SPRITES.tablero16, -1);
  addSprite(250, SPRITES.tablero17, -1);

  addSprite(40, SPRITES.TURBO, 0);
  addSprite(1500, SPRITES.TURBO, 0);
  addSprite(2500, SPRITES.TURBO, 0);

  /*
        addSprite(600, SPRITES.BILLBOARD09, -0.01); addSprite(600, SPRITES.BILLBOARD09, 0); addSprite(600, SPRITES.BILLBOARD09, 0.5); addSprite(600, SPRITES.BILLBOARD09, -0.5);
        addSprite(2000, SPRITES.BILLBOARD09, -0.01); addSprite(2000, SPRITES.BILLBOARD09, 0); addSprite(2000, SPRITES.questPre, 0.5); addSprite(2000, SPRITES.questPre, -0.5);
        addSprite(3000, SPRITES.BILLBOARD09, -0.01); addSprite(3000, SPRITES.BILLBOARD09, 0); addSprite(3000, SPRITES.questPre, 0.5); addSprite(3000, SPRITES.questPre, -0.5);
        addSprite(4000, SPRITES.BILLBOARD09, -0.01); addSprite(4000, SPRITES.BILLBOARD09, 0); addSprite(4000, SPRITES.questPre, 0.5); addSprite(4000, SPRITES.questPre, -0.5);
        addSprite(5000, SPRITES.BILLBOARD09, -0.01); addSprite(5000, SPRITES.BILLBOARD09, 0); addSprite(5000, SPRITES.questPre, 0.5); addSprite(5000, SPRITES.questPre, -0.5);
        */

  addSprite(1000, SPRITES.BILLBOARD02, 0);
  addSprite(1800, SPRITES.amarillas, 0);
  addSprite(2900, SPRITES.itemJuego, 0);
  addSprite(4500, SPRITES.BILLBOARD02, 0);
  addSprite(5500, SPRITES.amarillas, 0);

  for (n = 10; n < 10; n += 4 + Math.floor(n / 100)) {
    addSprite(n, SPRITES.PALM_TREE, 1 + Math.random() * 0.5);
    addSprite(n, SPRITES.PALM_TREE, 1 + Math.random() * 2);
  }

  for (n = 200; n < 1000; n += 5) {
    addSprite(n, SPRITES.COLUMN, 1.1);
    addSprite(n + Util.randomInt(0, 5), SPRITES.TREE1, -1 - Math.random() * 2);
    addSprite(n + Util.randomInt(0, 5), SPRITES.TREE2, -1 - Math.random() * 2);
  }

  for (n = 100; n < segments.length; n += 3) {
    addSprite(
      n,
      Util.randomChoice(SPRITES.PLANTS),
      Util.randomChoice([1, -1]) * (2 + Math.random() * 5)
    );
  }

  var side, sprite, offset;
  for (n = 1000; n < segments.length - 50; n += 100) {
    side = Util.randomChoice([1, -1]);
    addSprite(
      n + Util.randomInt(0, 50),
      Util.randomChoice(SPRITES.BILLBOARDS),
      -side
    );

    for (i = 0; i < 20; i++) {
      sprite = Util.randomChoice(SPRITES.PLANTS);
      offset = side * (1.5 + Math.random());
      addSprite(n + Util.randomInt(0, 50), sprite, offset);
    }
  }
}

function resetCars() {
  cars = [];
  var n, car, segment, offset, z, sprite, speed;

  for (var n = 0; n < totalCars; n++) {
    offset = Math.random() * Util.randomChoice([-0.8, 0.8]);
    z = Math.floor(Math.random() * segments.length) * segmentLength;
    sprite = Util.randomChoice(SPRITES.CARS);
    speed =
      maxSpeed / 4 +
      (Math.random() * maxSpeed) / (sprite == SPRITES.SEMI ? 4 : 2);
    car = { offset: offset, z: z, sprite: sprite, speed: speed };
    segment = findSegment(car.z);
    segment.cars.push(car);
    cars.push(car);
  }
}

//=========================================================================
// THE GAME LOOP
//=========================================================================

Game.run({
  canvas: canvas,
  render: render,
  update: update,
  stats: stats,
  step: step,
  images: ["background", "sprites"],
  keys: [
    {
      keys: [KEY.LEFT, KEY.A],
      mode: "down",
      action: function () {
        keyLeft = true;
      },
    },
    {
      keys: [KEY.RIGHT, KEY.D],
      mode: "down",
      action: function () {
        keyRight = true;
      },
    },
    {
      keys: [KEY.UP, KEY.W],
      mode: "down",
      action: function () {
        keyFaster = true;
      },
    },
    {
      keys: [KEY.DOWN, KEY.S],
      mode: "down",
      action: function () {
        keySlower = true;
      },
    },
    {
      keys: [KEY.LEFT, KEY.A],
      mode: "up",
      action: function () {
        keyLeft = false;
      },
    },
    {
      keys: [KEY.RIGHT, KEY.D],
      mode: "up",
      action: function () {
        keyRight = false;
      },
    },
    {
      keys: [KEY.UP, KEY.W],
      mode: "up",
      action: function () {
        keyFaster = false;
      },
    },
    {
      keys: [KEY.DOWN, KEY.S],
      mode: "up",
      action: function () {
        keySlower = false;
      },
    },
  ],
  ready: function (images) {
    background = images[0];
    sprites = images[1];
    reset();
    Dom.storage.fast_lap_time = Dom.storage.fast_lap_time || 180;
    updateHud(
      "fast_lap_time",
      formatTime(Util.toFloat(Dom.storage.fast_lap_time))
    );
  },
});

function reset(options) {
  options = options || {};
  canvas.width = width = Util.toInt(options.width, width);
  canvas.height = height = Util.toInt(options.height, height);
  lanes = Util.toInt(options.lanes, lanes);
  roadWidth = Util.toInt(options.roadWidth, roadWidth);
  cameraHeight = Util.toInt(options.cameraHeight, cameraHeight);
  drawDistance = Util.toInt(options.drawDistance, drawDistance);
  fogDensity = Util.toInt(options.fogDensity, fogDensity);
  fieldOfView = Util.toInt(options.fieldOfView, fieldOfView);
  segmentLength = Util.toInt(options.segmentLength, segmentLength);
  rumbleLength = Util.toInt(options.rumbleLength, rumbleLength);
  cameraDepth = 1 / Math.tan(((fieldOfView / 2) * Math.PI) / 180);
  playerZ = cameraHeight * cameraDepth;
  resolution = height / 480; //480
  refreshTweakUI();

  if (segments.length == 0 || options.segmentLength || options.rumbleLength)
    resetRoad(); // only rebuild road when necessary
}

//=========================================================================
// TWEAK UI HANDLERS
//=========================================================================

Dom.on("resolution", "change", function (ev) {
  var w, h, ratio;
  switch (ev.target.options[ev.target.selectedIndex].value) {
    case "fine":
      w = 1280;
      h = 960;
      ratio = w / width;
      break;
    case "high":
      w = 1280;
      h = 960;
      ratio = w / width;
      break; //w = 1024; h = 768;
    case "medium":
      w = 640;
      h = 480;
      ratio = w / width;
      break;
    case "low":
      w = 480;
      h = 360;
      ratio = w / width;
      break;
  }
  reset({ width: w, height: h });
  Dom.blur(ev);
});

Dom.on("lanes", "change", function (ev) {
  Dom.blur(ev);
  reset({ lanes: ev.target.options[ev.target.selectedIndex].value });
});
Dom.on("roadWidth", "change", function (ev) {
  Dom.blur(ev);
  reset({
    roadWidth: Util.limit(
      Util.toInt(ev.target.value),
      Util.toInt(ev.target.getAttribute("min")),
      Util.toInt(ev.target.getAttribute("max"))
    ),
  });
});
Dom.on("cameraHeight", "change", function (ev) {
  Dom.blur(ev);
  reset({
    cameraHeight: Util.limit(
      Util.toInt(ev.target.value),
      Util.toInt(ev.target.getAttribute("min")),
      Util.toInt(ev.target.getAttribute("max"))
    ),
  });
});
Dom.on("drawDistance", "change", function (ev) {
  Dom.blur(ev);
  reset({
    drawDistance: Util.limit(
      Util.toInt(ev.target.value),
      Util.toInt(ev.target.getAttribute("min")),
      Util.toInt(ev.target.getAttribute("max"))
    ),
  });
});
Dom.on("fieldOfView", "change", function (ev) {
  Dom.blur(ev);
  reset({
    fieldOfView: Util.limit(
      Util.toInt(ev.target.value),
      Util.toInt(ev.target.getAttribute("min")),
      Util.toInt(ev.target.getAttribute("max"))
    ),
  });
});
Dom.on("fogDensity", "change", function (ev) {
  Dom.blur(ev);
  reset({
    fogDensity: Util.limit(
      Util.toInt(ev.target.value),
      Util.toInt(ev.target.getAttribute("min")),
      Util.toInt(ev.target.getAttribute("max"))
    ),
  });
});

function refreshTweakUI() {
  Dom.get("lanes").selectedIndex = lanes - 1;
  Dom.get("currentRoadWidth").innerHTML = Dom.get("roadWidth").value =
    roadWidth;
  Dom.get("currentCameraHeight").innerHTML = Dom.get("cameraHeight").value =
    cameraHeight;
  Dom.get("currentDrawDistance").innerHTML = Dom.get("drawDistance").value =
    drawDistance;
  Dom.get("currentFieldOfView").innerHTML = Dom.get("fieldOfView").value =
    fieldOfView;
  Dom.get("currentFogDensity").innerHTML = Dom.get("fogDensity").value =
    fogDensity;
}

//=========================================================================
