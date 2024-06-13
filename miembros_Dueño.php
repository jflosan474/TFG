<?php
// Datos de conexión a la base de datos
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "tfg_v_0_2";

// Crear conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar la conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Función para validar impago
function validar_impago($conn, $id_usuario) {
    // Obtener la fecha de suscripción del usuario y convertirla a DATE
    $sql = "SELECT fyn_sub FROM Usuario WHERE ID_usuario = $id_usuario";
    $result = $conn->query($sql);
    
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $fyn_sub_texto = $row['fyn_sub'];
        $fyn_sub_date = date_create_from_format('Y-m-d', $fyn_sub_texto); // Convertir a objeto DateTime
        $hoy = new DateTime(); // Fecha actual
        
        // Comparar las fechas
        return $fyn_sub_date < $hoy;
    } else {
        return false; // Si no se encuentra el usuario, devolvemos false
    }
}

// Función para marcar como pagado
function marcar_como_pagado($conn, $id_usuario) {
    $hoy = new DateTime(); // Fecha actual
    $yncyo_sub = $hoy->format('Y-m-d'); // Fecha actual en formato YYYY-MM-DD
    $fyn_sub = $hoy->modify('+1 month')->format('Y-m-d'); // Sumar 1 mes a la fecha actual y formatear
    
    $sql_pagar = "UPDATE Usuario SET yncyo_sub = '$yncyo_sub', fyn_sub = '$fyn_sub' WHERE ID_usuario = $id_usuario";
    
    if ($conn->query($sql_pagar) === TRUE) {
        echo "Usuario marcado como pagado correctamente.<br>";
    } else {
        echo "Error actualizando el pago del usuario: " . $conn->error . "<br>";
    }
}

// Eliminar usuario si se ha solicitado
if (isset($_GET['accion']) && $_GET['accion'] == 'eliminar' && isset($_GET['id_usuario'])) {
    $id_usuario = $_GET['id_usuario'];
    $sql_eliminar = "DELETE FROM Usuario WHERE ID_usuario = $id_usuario";
    if ($conn->query($sql_eliminar) === TRUE) {
        echo "Usuario eliminado correctamente.<br>";
    } else {
        echo "Error eliminando el usuario: " . $conn->error . "<br>";
    }
}

// Marcar usuario como pagado si se ha solicitado
if (isset($_POST['accion']) && $_POST['accion'] == 'pagar' && isset($_POST['id_usuario'])) {
    $id_usuario = $_POST['id_usuario'];
    marcar_como_pagado($conn, $id_usuario);
}

// Obtener la lista de usuarios
$sql = "SELECT ID_usuario, usuario, nombre, apellidos, fyn_sub FROM Usuario";
$result = $conn->query($sql);
$usuarios_impagados = [];
$usuarios_pagados = [];

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        // Validar si el usuario está impagado
        if (validar_impago($conn, $row["ID_usuario"])) {
            $usuarios_impagados[] = $row;
        } else {
            $usuarios_pagados[] = $row;
        }
    }
} else {
    echo "No se encontraron usuarios.";
}?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Miembros</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f0f0;
            margin: 0;
            padding: 20px;
        }

        h2 {
            text-align: center;
            color: #333;
            margin-bottom: 20px;
        }

        .container {
            display: flex;
            justify-content: space-between;
            margin-top: 20px;
        }

        .column {
            flex: 1;
            margin: 0 10px;
            background-color: white;
            border-radius: 8px;
            padding: 15px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        table, th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: center;
        }

        th {
            background-color: #f2f2f2;
        }

        .btn-modificar, .btn-eliminar, .btn-pagar {
            padding: 5px 10px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 12px;
            margin: 2px;
            cursor: pointer;
            border: none;
            border-radius: 4px;
            transition: background-color 0.3s ease;
        }

        .btn-modificar {
            background-color: #4CAF50; /* Green */
            color: white;
        }

        .btn-modificar:hover {
            background-color: #45a049;
        }

        .btn-eliminar {
            background-color: #f44336; /* Red */
            color: white;
        }

        .btn-eliminar:hover {
            background-color: #da190b;
        }

        .btn-pagar {
            background-color: #008CBA; /* Blue */
            color: white;
        }

        .btn-pagar:hover {
            background-color: #007ba7;
        }

        .btn-agregar {
            background-color: #007bff; /* Blue */
            color: white;
            border: none;
            padding: 10px 20px;
            text-decoration: none;
            display: inline-block;
            margin-top: 10px;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .btn-agregar:hover {
            background-color: #0056b3;
        }

        .button-container {
            text-align: center;
            margin-bottom: 20px;
        }

        .volver {
            margin-bottom: 10px;
        }

        .volver a {
            display: inline-block;
            background-color: #6c757d;
            color: white;
            padding: 10px 20px;
            text-decoration: none;
            border-radius: 4px;
            transition: background-color 0.3s ease;
        }

        .volver a:hover {
            background-color: #5a6268;
        }

    </style>
</head>
<body>
    <h2>Lista de Miembros</h2>
    <!-- Botón para agregar usuario y botón de volver -->
    <div class="button-container">
        <a href="dashboard_Dueño.php" class="volver">Volver</a>
        <a href="agregar_usuario.php" class="btn-agregar">Agregar Usuario</a>
    </div>

    <div class="container">
        <!-- Columna de Usuarios Impagados -->
        <div class="column">
            <h3>Impagados</h3>
            <?php
            if (count($usuarios_impagados) > 0) {
                echo "<table>";
                echo "<tr><th>Usuario</th><th>Nombre</th><th>Apellidos</th><th>Ultimo Pago</th><th>Pagar</th></tr>";
                foreach ($usuarios_impagados as $usuario) {
                    echo "<tr>";
                    echo "<td>".$usuario["usuario"]."</td>";
                    echo "<td>".$usuario["nombre"]."</td>";
                    echo "<td>".$usuario["apellidos"]."</td>";
                    echo "<td>".$usuario["fyn_sub"]."</td>";
                    echo "<td><form action='miembros_Dueño.php' method='post'>";
                    echo "<input type='hidden' name='accion' value='pagar'>";
                    echo "<input type='hidden' name='id_usuario' value='".$usuario["ID_usuario"]."'>";
                    echo "<button type='submit' class='btn-pagar'>Pagar</button></form></td>";
                    echo "</tr>";
                }
                echo "</table>";
            } else {
                echo "No se encontraron usuarios impagados.";
            }
            ?>
        </div>

        <!-- Columna de Usuarios Pagados -->
        <div class="column">
            <h3>Pagados</h3>
            <?php
            if (count($usuarios_pagados) > 0) {
                echo "<table>";
                echo "<tr><th>Usuario</th><th>Nombre</th><th>Apellidos</th><th>Fecha de Pago</th></tr>";
                foreach ($usuarios_pagados as $usuario) {
                    echo "<tr>";
                    echo "<td>".$usuario["usuario"]."</td>";
                    echo "<td>".$usuario["nombre"]."</td>";
                    echo "<td>".$usuario["apellidos"]."</td>";
                    echo "<td>".$usuario["fyn_sub"]."</td>";
                    echo "</tr>";
                }
                echo "</table>";
            } else {
                echo "No se encontraron usuarios pagados.";
            }
            ?>
        </div>

        <!-- Columna de Todos los Usuarios -->
        <div class="column">
            <h3>Todos los Usuarios</h3>
            <?php
            $result = $conn->query($sql); // Re-ejecutar la consulta para obtener todos los usuarios nuevamente

            if ($result->num_rows > 0) {
                echo "<table>";
                echo "<tr><th>Usuario</th><th>Nombre</th><th>Apellidos</th><th>Modificar</th><th>Eliminar</th></tr>";
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>".$row["usuario"]."</td>";
                    echo "<td>".$row["nombre"]."</td>";
                    echo "<td>".$row["apellidos"]."</td>";
                    echo "<td><a href='modificar_usuario.php?id_usuario=".$row["ID_usuario"]."'><button class='btn-modificar'>Modificar</button></a></td>";
                    echo "<td><a href='miembros_Dueño.php?accion=eliminar&id_usuario=".$row["ID_usuario"]."'><button class='btn-eliminar'>Eliminar</button></a></td>";
                    echo "</tr>";
                }
                echo "</table>";
            } else {
                echo "No se encontraron usuarios.";
            }

            // Cerrar la conexión
            $conn->close();
            ?>
        </div>
    </div>
</body>
</html>