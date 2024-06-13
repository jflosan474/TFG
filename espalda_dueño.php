<?php
// Configurar la cookie de categoría con valor 1
setcookie('id_categorya', 1, time() + (86400 * 30), "/"); // Valor 1 para la categoría de espalda

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id_entrenamiento'])) {
    $id_entrenamiento = intval($_POST['id_entrenamiento']);

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

    // Iniciar transacción
    $conn->begin_transaction();

    try {
        // Eliminar los ejercicios asociados
        $sql_delete_exercises = "DELETE FROM Ejercycyo WHERE ID_entrenamiento = ?";
        $stmt_exercises = $conn->prepare($sql_delete_exercises);
        $stmt_exercises->bind_param("i", $id_entrenamiento);
        $stmt_exercises->execute();

        // Eliminar el entrenamiento
        $sql_delete_training = "DELETE FROM Entrenamiento WHERE ID_entrenamiento = ?";
        $stmt_training = $conn->prepare($sql_delete_training);
        $stmt_training->bind_param("i", $id_entrenamiento);
        $stmt_training->execute();

        // Confirmar transacción
        $conn->commit();
    } catch (Exception $e) {
        // Revertir transacción en caso de error
        $conn->rollback();
        echo "Error al eliminar el entrenamiento: " . $e->getMessage();
    }

    // Cerrar la conexión
    $stmt_exercises->close();
    $stmt_training->close();
    $conn->close();

    // Redirigir de nuevo a la página principal
    header("Location: " . $_SERVER['PHP_SELF']);
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Entrenamientos de Espalda</title>
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

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        table, th, td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: center;
        }

        th {
            background-color: #f2f2f2;
        }

        .btn-visualizar, .btn-eliminar {
            padding: 8px 16px;
            font-size: 14px;
            border: none;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .btn-visualizar {
            background-color: #007bff;
            color: white;
        }

        .btn-eliminar {
            background-color: #dc3545;
            color: white;
        }

        .btn-visualizar:hover {
            background-color: #0056b3;
        }

        .btn-eliminar:hover {
            background-color: #c82333;
        }

        .btn-crear, .btn-volver {
            display: inline-block;
            margin: 10px;
            padding: 12px 24px;
            font-size: 16px;
            background-color: #28a745;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            text-decoration: none;
            text-align: center;
            transition: background-color 0.3s ease;
        }

        .btn-crear:hover {
            background-color: #218838;
        }

        .btn-volver {
            background-color: #6c757d;
        }

        .btn-volver:hover {
            background-color: #5a6268;
        }

        .button-container {
            text-align: center;
            margin-top: 20px;
        }
    </style>
    <script>
        function eliminar(id_entrenamiento) {
            if (confirm("¿Estás seguro de que deseas eliminar este entrenamiento?")) {
                var form = document.createElement("form");
                form.method = "POST";
                form.action = "<?php echo $_SERVER['PHP_SELF']; ?>";
                
                var input = document.createElement("input");
                input.type = "hidden";
                input.name = "id_entrenamiento";
                input.value = id_entrenamiento;
                
                form.appendChild(input);
                document.body.appendChild(form);
                form.submit();
            }
        }
    </script>
</head>
<body>
    <h2>Entrenamientos de Espalda</h2>
    <div class="button-container">
        <a href="crear_entrenamiento_form.php" class="btn-crear">Crear Entrenamiento</a>
        <a href="entrenamientos_Dueño.php" class="btn-volver">Volver a la selección de categorías</a>
    </div>
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

    // Consulta SQL para obtener los entrenamientos de espalda
    $sql = "SELECT * FROM Entrenamiento WHERE ID_categorya = 1"; // Suponiendo que el ID de la categoría de espalda es 1

    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // Mostrar los resultados en una tabla con opciones de visualizar y eliminar
        echo "<table>";
        echo "<tr><th>Nombre</th><th>Visualizar</th><th>Eliminar</th></tr>";
        while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>".$row["nombre"]."</td>";
            echo "<td><a href='ejercicios_dueño.php?id_entrenamiento=".$row["ID_entrenamiento"]."'><button class='btn-visualizar'>Visualizar</button></a></td>";
            echo "<td><button class='btn-eliminar' onclick='eliminar(".$row["ID_entrenamiento"].")'>Eliminar</button></td>";
            echo "</tr>";
        }
        echo "</table>";
    } else {
        echo "No se encontraron entrenamientos de espalda";
    }

    // Cerrar la conexión
    $conn->close();
    ?>

    
</body>
</html>