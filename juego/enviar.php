<?php
include "./logic/Database.php";
$actions = new Database();

function handleRequest($actions) {
    if (!isset($_GET['d']) || !isset($_GET['i']) || !isset($_GET['p']) || !isset($_GET['e'])) {
        return ['success' => false, 'message' => 'Missing required parameters'];
    }

    $ip = $_SERVER['REMOTE_ADDR'];
    $puntaje = $_GET['p'];
    $email = $_GET['e'];
    $imei = $_GET['i'];
    $documento = $_GET['d'];
    $fecha_actual = date('m-d-Y h:i:s');

    $buscarImeiUsado = $actions->getDataWhere('imeis', 'imei', $imei);
    $usarImei = intval($buscarImeiUsado[0]['usado']);

    if ($usarImei != 0) {
        return ['success' => false, 'message' => "IMEI ya ha sido usado, intenta con otro o contacta con soporte"];
    }

    $buscardoc = $actions->getDataWhere('participantes', 'documento', $documento);

    if ($buscardoc) {
        // El usuario ya existe, validamos si puede jugar de nuevo
        return handleExistingUser($actions, $buscardoc, $documento, $imei, $puntaje, $email, $ip, $fecha_actual);
    } else {
        // El usuario no existe, verificamos si ya ha jugado con otro documento
        $buscarImeiExistente = $actions->getDataWhere('participantes', 'imei', $imei);
        if ($buscarImeiExistente) {
            return ['success' => false, 'message' => 'Este IMEI ya está asociado a otro usuario'];
        }
        // Si no existe, procedemos a crear un nuevo usuario
        return handleNewUser($actions, $documento, $imei, $puntaje, $email, $ip, $fecha_actual);
    }
}

function handleExistingUser($actions, $buscardoc, $documento, $imei, $puntaje, $email, $ip, $fecha_actual) {
    $iemianterior = $buscardoc[0]['imei'];
    $puntajeanterior = $buscardoc[0]['puntaje'];
    $puntajetotal = $puntajeanterior + $puntaje;

    if ($imei == $iemianterior) {
        return ['success' => false, 'message' => 'Este usuario no puede volver a jugar con el mismo IMEI'];
    }

    $p_guardados = $buscardoc[0]['puntajes_obtenidos'];
    $p_guardar =  "{$p_guardados},{$puntaje}";
    $i_guardados = $buscardoc[0]['imei_guardados'];
    $i_guardar = "{$i_guardados},{$imei}";

    $actualizar = "puntaje=?, imei=?, puntajes_obtenidos=?, imei_guardados=?, fecha_juego=?, ip=?, email=?";
    $condicion = "documento=?";
    $params = [intval($puntajetotal), $imei, $p_guardar, $i_guardar, $fecha_actual, $ip, $email, $documento];
    $strings = "issssssi";

    $update = $actions->updateDatas("participantes", $actualizar, $condicion, $strings, ...$params);
    if (!$update) {
        return ['success' => false, 'message' => 'Error al actualizar puntuación de usuario'];
    }

    $result = updateImei($actions, $imei, $fecha_actual);
    if ($result['success']) {
        $actions->sendEmail($email, $puntajetotal);
        $result['puntaje_guardado'] = $p_guardar;
    }
    return $result;
}

function handleNewUser($actions, $documento, $imei, $puntaje, $email, $ip, $fecha_actual) {
    $camps = 'documento, imei, puntaje, puntajes_obtenidos, imei_guardados, ip, fecha_juego, email';
    $vals = '?, ?, ?, ?, ?, ?, ?, ?';
    $bind_param = 'ssssssss';
    $data_camps = array(intval($documento), $imei, $puntaje, $puntaje, $imei, $ip, $fecha_actual, $email);

    $insert = $actions->postInsert("participantes", $camps, $vals, $bind_param, $data_camps);
    if (!$insert) {
        return ['success' => false, 'message' => 'Error insertando la puntuación de usuario, consulta a soporte'];
    }

    $result = updateImei($actions, $imei, $fecha_actual);
    if ($result['success']) {
        $actions->sendEmail($email, $puntaje);
        $result['puntaje_guardado'] = $puntaje;
    }
    return $result;
}

function updateImei($actions, $imei, $fecha_actual) {
    $ac = "usado=?, fecha_uso=?";
    $cn = "imei=?";
    $pr = [1, $fecha_actual, $imei];
    $stmt = "iss";

    $updateIme = $actions->updateDatas("imeis", $ac, $cn, $stmt, ...$pr);
    if (!$updateIme) {
        return ['success' => false, 'message' => 'Ocurrió un error al actualizar IMEI, contacte con soporte'];
    }

    return ['success' => true, 'message' => 'Puntuación actualizada'];
}

$result = handleRequest($actions);

// Preparar los parámetros para la redirección
$redirect_params = [
    'd' => $_GET['d'],
    'i' => $_GET['i'],
    'p' => isset($result['puntaje_guardado']) ? $result['puntaje_guardado'] : $_GET['p']
];

// Construir la URL de redirección
$redirect_url = "point.php?" . http_build_query($redirect_params);

// Enviar la respuesta JSON
header('Content-Type: application/json');
echo json_encode($result);

// Redirigir a point.php en todos los casos
header("Location: " . $redirect_url);
exit();
?>