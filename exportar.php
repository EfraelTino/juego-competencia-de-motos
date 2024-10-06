<!DOCTYPE html>
<html>

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Documento</title>
</head>

<body>
  <table border="1" cellspacing="1" cellpadding="2" width="100%">
    <caption style="background-color: MediumPurple; font-size: 20px; color: gray;">
      <b>REGISTRO DE INSCRITOS ANIVERSARIO HERO.</b>
    </caption>
    <tr>
      <td style="background-color: MediumPurple; font-size: 15px; color: white;">POS</td>
      <td style="background-color: MediumPurple; font-size: 15px; color: white;">NOMBRES</td>
      <td style="background-color: MediumPurple; font-size: 15px; color: white;">EMAIL</td>
      <td style="background-color: MediumPurple; font-size: 15px; color: white;">CIUDAD</td>
      <td style="background-color: MediumPurple; font-size: 15px; color: white;">CEDULA</td>
      <td style="background-color: MediumPurple; font-size: 15px; color: white;">PLACA</td>
      <td style="background-color: MediumPurple; font-size: 15px; color: white;">TELEFONO</td>
      <td style="background-color: MediumPurple; font-size: 15px; color: white;">PUNTAJE</td>
      <td style="background-color: MediumPurple; font-size: 15px; color: white;">IP</td>
      <td style="background-color: MediumPurple; font-size: 15px; color: white;">FACTURA</td>
      <td style="background-color: MediumPurple; font-size: 15px; color: white;">INTENTOS</td>
    </tr>
    <?php
    require 'logic/conexion.php';
    header('Content-Type: application/vnd.ms-excel;');
    header('Content-Disposition: attachment;filename="aniversariohero.xls"');

    // EXPORTAR TODOS LOS DATOS
    $consulta = "SELECT DISTINCT * FROM usuarios ORDER BY puntaje_alto DESC";
    $resultado = $dblink->query($consulta);
    $pos = 0;

    while ($row = $resultado->fetch_assoc()) {
      $pos++;
    ?>
      <tr>
        <td><?php echo $pos; ?></td>
        <td><?php echo $row['nombres']; ?></td>
        <td><?php echo $row['email']; ?></td>
        <td><?php echo $row['ciudad']; ?></td>
        <td><?php echo $row['cedula']; ?></td>
        <td><?php echo $row['placa']; ?></td>
        <td><?php echo $row['telefono']; ?></td>
        <td><?php echo $row['puntaje_alto']; ?></td>
        <td><?php echo $row['ip']; ?></td>
        <td><a href="<?php echo 'https://aniversariohero.com/beta/facturas/' . $row['factura'] . '.webp'; ?>" target="_blank">
            <?php echo 'https://aniversariohero.com/beta/facturas/' . $row['factura'] . '.webp'; ?>
          </a></td>

        <td><?php echo $row['intentos']; ?></td>
      </tr>
    <?php
    }
    ?>
  </table>
</body>

</html>