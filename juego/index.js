let preguntas_aleatorias = true;
let mostrar_pantalla_juego_términado = true;
let reiniciar_puntos_al_reiniciar_el_juego = true;
var documento = 0;
var puntaje = 0;
var iniciar = false;
var numeroMax = 100;
var pre = document.getElementById("contenedor");
var caja = document.getElementById("quest");
var tipo_jugador = document.getElementById("tipo").innerHTML;
var id_jugador = document.getElementById("id_jugador").innerHTML;
var base_preguntas;
var interprete;



window.onload = function () {
  
  switch (nivel){ 
    case 0: base_preguntas = readText("base-preguntas0.json"); break;
    case 1: base_preguntas = readText("base-preguntas1.json"); break;
    case 2: base_preguntas = readText("base-preguntas2.json"); break;
    case 3: base_preguntas = readText("base-preguntas3.json"); break;
    default: base_preguntas = readText("base-preguntas0.json");
  }
  
  interprete_bp = JSON.parse(base_preguntas);
  mostrarCedula();
};
function mostrarCedula() {

}
let pregunta;
let posibles_respuestas;
btn_correspondiente = [
  select_id("btn1"),
  select_id("btn2"),
  select_id("btn3"),
  select_id("btn4")
];
let npreguntas = [];

let preguntas_hechas = 0;
var preguntas_correctas = 0;

function escogerPreguntaAleatoria() {
  let n;
  if (preguntas_aleatorias) {
    n = Math.floor(Math.random() * interprete_bp.length);
  } else {
    n = 0;
  }
 // console.log(npreguntas.length);
  while (npreguntas.includes(n)) {
    n++;
    if (n >= interprete_bp.length) {//interprete_bp.length
      n = 0;
    }

    if (npreguntas.length == interprete_bp.length) {// == interprete_bp.length
      //Aquí es donde el juego se reinicia
      
/*
      if (mostrar_pantalla_juego_términado) {
       // pre.style.display = "none";
        iniciar = false;
        swal.fire({
          title: "Juego finalizado",
          text:
            "Puntuación: " + preguntas_correctas + "/" + (numeroMax) + " Tiempo:" + puntaje,
          icon: "success"
        }).then((value) => {
          finEnviarBD();
        });


      }
      */

      if (reiniciar_puntos_al_reiniciar_el_juego) {
        // preguntas_correctas = 0
        // preguntas_hechas = 0
      }
      npreguntas = [];
    }
  }
  if (npreguntas.length == numeroMax) {
    //termiarJuego();
  }
  npreguntas.push(n);
  preguntas_hechas++;
  escogerPreguntaAleatoria(n);
}
function termiarJuego() {
  pre.style.display = "none";
  if (mostrar_pantalla_juego_términado) {
    iniciar = false;
    swal.fire({
      title: "Juego finalizado",
      text:
        "Puntuación: " + preguntas_correctas + "/" + (numeroMax) + " Tiempo:" + puntaje,
      icon: "success"
    }).then((value) => {

      finEnviarBD();
    });;
  }

}
function escogerPregunta(n) {
  pregunta = interprete_bp[n];
  select_id("categoria").innerHTML = pregunta.categoria;
  select_id("pregunta").innerHTML = pregunta.pregunta;
  select_id("numero").innerHTML = n;
  let pc = preguntas_correctas;
  if (preguntas_hechas > 1) {
    select_id("puntaje").innerHTML = pc + "/" + (numeroMax);
  } else {
    select_id("puntaje").innerHTML = "";
  }

  style("imagen").objectFit = pregunta.objectFit;
  desordenarRespuestas(pregunta);
  if (pregunta.imagen) {
   // console.log(pregunta.imagen);
    select_id("imagen").setAttribute("src", pregunta.imagen);
    style("imagen").height = "200px";
    style("imagen").width = "100%";
  } else {
    style("imagen").height = "0px";
    style("imagen").width = "0px";
    setTimeout(() => {
      select_id("imagen").setAttribute("src", "");
    }, 150);
  }
}
function reaparecer() {
  select_id("btn1").style.display = "flex";
  select_id("btn2").style.display = "flex";
  select_id("btn3").style.display = "flex";
  select_id("btn4").style.display = "flex";
}
function desordenarRespuestas(pregunta) {
  posibles_respuestas = [
    pregunta.respuesta,
    pregunta.incorrecta1,
    pregunta.incorrecta2,
    pregunta.incorrecta3,
  ];
  posibles_respuestas.sort(() => Math.random() - 0.5);
  reaparecer();

  if (posibles_respuestas[0] == "nop") {
    select_id("btn1").style.display = "none";
  }
  if (posibles_respuestas[1] == "nop") {
    select_id("btn2").style.display = "none";
  }
  if (posibles_respuestas[2] == "nop") {
    select_id("btn3").style.display = "none";
  }
  if (posibles_respuestas[3] == "nop") {
    select_id("btn4").style.display = "none";
  }

  //

  //console.log(" aca estoy" + posibles_respuestas[0]);
  select_id("btn1").innerHTML = posibles_respuestas[0];
  select_id("btn2").innerHTML = posibles_respuestas[1];
  select_id("btn3").innerHTML = posibles_respuestas[2];
  select_id("btn4").innerHTML = posibles_respuestas[3];
}

let suspender_botones = false;
var okey=false;
var incorrectasPRE=0;

function oprimir_btn(i) {
  if (suspender_botones) {
    return;
  }
  suspender_botones = true;
  if (posibles_respuestas[i] == pregunta.respuesta) {
    preguntas_correctas++;
    console.log(preguntas_correctas + " -*-------------");
    okey=true;
    btn_correspondiente[i].style.background = "lightgreen";
  } else {
    btn_correspondiente[i].style.background = "red";
    okey=false;
    incorrectasPRE++;
  }
  for (let j = 0; j < 4; j++) {
    if (posibles_respuestas[j] == pregunta.respuesta) {
      btn_correspondiente[j].style.background = "lightgreen";
      break;
    }
  }
  setTimeout(() => {
    reiniciar();
    suspender_botones = false;
  }, 1000);
}
var timeleft = 0;
var segundos = 0;


var myfunc = setInterval(function () {
  if (iniciar) {
    timeleft = timeleft + 1;
    document.getElementById("tiempor").innerHTML = segundos + ":" + timeleft;
    if (timeleft > 59) {
      timeleft = 0;
      segundos++;

    }
    puntaje = parseInt(segundos) + ":" + timeleft;
   // console.log(puntaje);
  }


}, 18)


function reiniciar() {
  caja.style.display="none";
  for (const btn of btn_correspondiente) {
   btn.style.background = "white";
  }
  escogerPreguntaAleatoria();
}

function select_id(id) {
  return document.getElementById(id);
}

function style(id) {
  return select_id(id).style;
}

function readText(ruta_local) {
  var texto = null;
  var xmlhttp = new XMLHttpRequest();
  xmlhttp.open("GET", ruta_local, false);
  xmlhttp.send();
  if (xmlhttp.status == 200) {
    texto = xmlhttp.responseText;
  }
  return texto;
}


