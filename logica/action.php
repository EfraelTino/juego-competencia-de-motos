<?php
require '../vendor/autoload.php';

use Intervention\Image\ImageManagerStatic as Image;
// Permitir solicitudes desde http://localhost:5173
date_default_timezone_set('America/Bogota');
$fechaActual = date('d/m/Y - h:i', time());

// Permitir solicitudes desde el frontend
//header("Access-Control-Allow-Origin: http://localhost/transitionrungamev2");
//header("Access-Control-Allow-Origin: http://localhost:8080/moto");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");
header("Access-Control-Allow-Credentials: true");
date_default_timezone_set('America/Bogota');

// Manejar la solicitud OPTIONS
if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
    // Enviar una respuesta 200 OK para solicitudes OPTIONS
    http_response_code(200);
    exit();
}

include "./Database.php";

$actions = new Database();


// INICIA CAMBIO
if (isset($_POST['action']) && $_POST['action'] == "registrar") {
    if (isset($_FILES['foto']) && $_FILES['foto']['error'] === UPLOAD_ERR_OK) {
        $nombre  = $_POST['nombre'];
        $email  = $_POST['email'];
        $ciudad  = $_POST['ciudad'];
        $cedula  = $_POST['cedula'];
        $placa  = $_POST['placa'];
        $telefono = $_POST['telefono'];
        $ip = $_SERVER['REMOTE_ADDR'];

        // Archivo subido
        $uploadedFile = $_FILES['foto'];
        $fileName = $uploadedFile['name'];
        $fileTmpName = $uploadedFile['tmp_name'];
        $extension_permitida = ['jpg', 'jpeg', 'png', 'webp'];

        $fileExtension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

        if (in_array($fileExtension, $extension_permitida)) {
            $fecha_actual = date('YmdHis');
            $nuevo_nombre = $telefono . '-' . $cedula . '.webp';
            $destino = '../facturas/' . $nuevo_nombre;

            // Usar Intervention Image para manejar la imagen
            $image = Image::make($fileTmpName);

            // Guardar la imagen en formato webp con compresión
            $image->encode('webp', 90)->save($destino);

            $sendUser = $actions->getDataWhere('usuarios', 'cedula', $cedula);
            if ($sendUser) {
                $response = array('success' => false, 'message' => 'Este usuario ya se encuentra registrado');
            } else {
                $camps = 'nombres, email, ciudad, cedula, placa, telefono, fecharegistro, ip, factura, intentos, puntaje';
                $vals = '?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?';
                $bind_param = 'sssssssssss';
                $data_camps = array($nombre, $email, $ciudad, $cedula, $placa, $telefono, $fecha_actual, $ip, $nuevo_nombre, 0, 0);

                $insertar = $actions->postInsert('usuarios', $camps, $bind_param, $vals, $data_camps);
                if ($insertar) {
                    $response = array('success' => true, 'message' => $insertar);
                } else {
                    $response = array('success' => false, 'message' => 'Error al registrar usuario, intente de nuevo');
                }
            }
        } else {
            $response = array('success' => false, 'message' => 'Extensión de archivo no permitida');
        }
    } else {
        // Error en la subida del archivo o no se envió archivo
        $response = array('success' => false, 'message' => 'No se ha enviado un archivo válido');
    }
    echo json_encode($response);
}
if (isset($_POST['action']) && $_POST['action'] == "actualizarIntento") {
    $documento = $_POST['cedula'];
    $intento = $_POST['intento'];
    $puntaje = $_POST['puntaje'];

    //traer el puntaje
    $getPuntaje = $actions->getDataWhere('usuarios', 'cedula', $documento);
    if ($getPuntaje) {

        $actualizar = "intentos=?, puntaje_alto=?";

        $condicion = "cedula=?";
        $params = [intval($intento), $puntaje, $documento];

        $strings = "iss"; // i=integer, s=string

        $update = $actions->updateDatas("usuarios", $actualizar, $condicion, $strings, ...$params);
        if ($update) {
            $response = array('success' => true, 'message' => 'Datos actualizados correctamente');
        } else {
            $response = array('success' => true, 'message' => 'No se pudo actualizar datos');
        }
    } else {
        $response = array('success' => false, 'message' => 'Usuario no encontrado');
    }
    echo json_encode($response);
}
