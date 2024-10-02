<?php
require './logica/Database.php';
$actions = new Database();

if (!isset($_GET['d']) || !isset($_GET['p'])) {
    echo json_encode(['success' => false, 'message' => 'No se encontraron datos']);
    exit(); // Salir del script si faltan los parámetros
}

$puntaje = $_GET['p'];
$documento = $_GET['d'];

try {
    // Obtener los datos del usuario
    $getData = $actions->getDataWhere('usuarios', 'cedula', $documento);
    if (!$getData || !isset($getData[0])) {
        echo json_encode(['success' => false, 'message' => 'Usuario no encontrado']);
        exit();
    }

    // Obtener el puntaje actual y los intentos
    $puntajedb = $getData[0]['puntaje'];
    $intentos = intval($getData[0]['intentos']); // Convertir a entero

    // Depuración: verificar valor de intentos
    var_dump($intentos); // Imprime el valor para ver si es correcto
    if($intentos <3){
        header('Location: .juego.php?');
    }
   else if ($intentos >= 3) {
        header('Location: ranking.php');
        exit(); // Asegurarse de que el script se detenga después de la redirección
    } else {
        // Concatenar el nuevo puntaje con el existente
        $puntajeguardar = $puntajedb . ',' . $puntaje;
        // Convertir la cadena en un array
        $puntajesArray = explode(',', $puntajedb);

        // Filtrar la cadena "Array" si está presente
        $puntajesArray = array_filter($puntajesArray, function ($value) {
            return is_numeric($value); // Filtrar solo valores numéricos
        });
        $mayorPuntaje = max($puntajesArray);
        $puntajeDef = $mayorPuntaje >= $puntaje ? $mayorPuntaje : $puntaje;
        echo "El mayor puntaje es: " . $mayorPuntaje;
        $actualizar = "puntaje=?, puntaje_alto=?";
        $condicion = "cedula=?";
        $params = [$puntajeguardar, $puntajeDef, $documento];
        $strings = "sss";

        // Ejecutar la actualización
        $update = $actions->updateDatas("usuarios", $actualizar, $condicion, $strings, ...$params);
        if ($update) {

            echo json_encode(['success' => true, 'message' => 'Puntaje actualizado: ' . $puntajedb]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Error al actualizar puntaje']);
        }
    }
} catch (\Throwable $th) {
    echo "error: " . $th->getMessage();
}
