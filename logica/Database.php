<?php
class Database
{
    private $host = "localhost";
    // private $user = "root";
    private $user = "u694359124_hero";
    private $pass = "0Z]3^OOu";
    // private $pass = "";
    private $db = "u694359124_hero";
    // private $db = "hero";
    public $dbConnect;
    public function __construct()
    {
        $this->dbConnect = new mysqli($this->host, $this->user, $this->pass, $this->db);
        if ($this->dbConnect->connect_error) {
            die("Error en la conexión a la base de datos: " . $this->dbConnect->connect_error);
        }
    }
    public function getDbConnect()
    {
        return $this->dbConnect;
    }

    public function postInsert($table, $camps, $bind_param, $vals, $data_camps)
    {
        $respuesta = []; // Inicializar la respuesta
    
        $sql = "INSERT INTO $table ($camps) VALUES ($vals)";
    
        $stmt = mysqli_prepare($this->dbConnect, $sql);
        if (!$stmt) {
            // Si hay un error en la preparación de la consulta
            $respuesta["success"] = false;
            $respuesta["message"] = "Error en la preparación de la consulta: " . mysqli_error($this->dbConnect);
        } else {
            // Crear una referencia de los valores para bind_param
            $refs = [];
            foreach ($data_camps as $key => $value) {
                $refs[$key] = &$data_camps[$key]; // Hacer referencia a los valores
            }
    
            // Enlaza los parámetros y ejecuta la consulta
            if (!mysqli_stmt_bind_param($stmt, $bind_param, ...$refs)) {
                // Si hay un error al enlazar los parámetros
                $respuesta["success"] = false;
                $respuesta["message"] = "Error al enlazar los parámetros: " . mysqli_stmt_error($stmt);
            } else {
                // Ejecuta la consulta
                if (!mysqli_stmt_execute($stmt)) {
                    // Si hay un error al ejecutar la consulta
                    $respuesta["success"] = false;
                    $respuesta["message"] = "Error en la consulta: " . mysqli_error($this->dbConnect);
                } else {
                    // Si la consulta se ejecuta correctamente, obtener el ID del nuevo registro
                    $newId = mysqli_insert_id($this->dbConnect);
                    $respuesta["success"] = true;
                    $respuesta["message"] = "Consulta satisfactoria";
                    $respuesta["newId"] = $newId; // Agregar el ID del nuevo registro a la respuesta
                }
            }
            // Cierra el statement
            mysqli_stmt_close($stmt);
        }
        return json_encode($respuesta);
    }
    


    public function getData($table)
    {
        $data = array();
        $sql = "SELECT *FROM $table";
        $result = $this->dbConnect->query($sql);
        if (!$result) {
            throw new Exception("Error en la consulta :" . $this->dbConnect->error);
        } else {
            while ($row = $result->fetch_assoc()) {
                $data[] = $row;
            }
        }
        return $data;
    }
    public function getDataWhere($table, $condicion, $datacondicion)
    {
        $sql = "SELECT * FROM $table WHERE $condicion = ?";
        $stmt = mysqli_prepare($this->dbConnect, $sql);
        if (!$stmt) {
            throw new Exception("Error: " . $this->dbConnect->error);
        }
        mysqli_stmt_bind_param($stmt, "s", $datacondicion); // Solo se necesita un marcador de posición para el valor de la condición
        if (mysqli_stmt_execute($stmt)) { // Verifica si la ejecución fue exitosa
            $result = mysqli_stmt_get_result($stmt);
            $rows = mysqli_fetch_all($result, MYSQLI_ASSOC);
            // Registro de depuración
            if (empty($rows)) {
                error_log("No se encontraron podcasts para el usuario con ID: $datacondicion");
            }
            return $rows;
        } else {
            throw new Exception("Error al ejecutar la consulta" . $stmt->error);
        }
    }



    public function updateDatas($tabla, $actualizar, $condicion, $strings, ...$params)
    {
        $sql = "UPDATE $tabla SET $actualizar WHERE $condicion";
        $stmt = mysqli_prepare($this->dbConnect, $sql);
        if (!$stmt) {
            throw new Exception("Error en la preparación de la consulta: " . $this->dbConnect->error);
        }

        // Asignar valor a los parámetros
        mysqli_stmt_bind_param($stmt, $strings, ...$params);

        if (!mysqli_stmt_execute($stmt)) {
            throw new Exception("Error al ejecutar la consulta: " . $stmt->error);
        }

        $rows_affected = mysqli_stmt_affected_rows($stmt);

        mysqli_stmt_close($stmt); // Cerrar el statement

        return $rows_affected > 0; // Devolver verdadero si se han afectado filas, falso de lo contrario
    }
    public function getCamposSinCondicion($camposObtener, $table)
    {
        $data = array();
        $sql = "SELECT $camposObtener FROM $table";
        $result = $this->dbConnect->query($sql);
        if (!$result) {
            throw new Exception("Error en la consulta :" . $this->dbConnect->error);
        } else {
            while ($row = $result->fetch_assoc())
                $data[] = $row;
        }
        return $data;
    }
    public function searchData($table, $first, $second, $busqueda)
    {
        // Construye la consulta SQL con marcadores de posición
        $sql = "SELECT * FROM $table WHERE $first LIKE ? OR $second LIKE ?";

        // Prepara la consulta
        if ($stmt = $this->dbConnect->prepare($sql)) {
            // Construye los parámetros de búsqueda con comodines
            $searchTerm = '%' . $busqueda . '%';

            // Vincula los parámetros a la consulta preparada
            $stmt->bind_param('ss', $searchTerm, $searchTerm);

            // Ejecuta la consulta
            $stmt->execute();

            // Obtiene el resultado
            $result = $stmt->get_result();

            // Verifica si hay errores en la ejecución
            if (!$result) {
                throw new Exception("Error en la consulta: " . $stmt->error);
            }

            // Recorre los resultados y los almacena en un array
            $data = array();
            while ($row = $result->fetch_assoc()) {
                $data[] = $row;
            }

            // Cierra la consulta preparada
            $stmt->close();

            // Retorna los resultados
            return $data;
        } else {
            throw new Exception("Error en la preparación de la consulta: " . $this->dbConnect->error);
        }
    }
    public function getRanking()
    {
        $sql = "SELECT puntaje_alto, nombres FROM `usuarios` WHERE puntaje_arprobado = 1 ORDER BY puntaje_alto DESC LIMIT 10";

        $result = $this->dbConnect->query($sql);
        
        if (!$result) {
            throw new Exception("Error en la consulta: " . $this->dbConnect->error);
        } else {
            $data = []; // Initialize $data as an empty array
            while ($row = $result->fetch_assoc()) {
                $data[] = $row; // Populate $data with fetched rows
            }
        }
        
        return $data; // Return the array of results (can be empty)
    }
    

}
