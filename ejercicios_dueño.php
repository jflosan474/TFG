<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ejercicios del Entrenamiento</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f0f0;
            margin: 0;
            padding: 20px;
            color: #333;
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
            background-color: #fff;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
        }

        table th, table td {
            border: 1px solid #ddd;
            padding: 12px;
            text-align: center;
        }

        table th {
            background-color: #f7f7f7;
        }

        table tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        .btn-modificar, .btn-eliminar, .btn-agregar {
            padding: 10px 15px;
            font-size: 14px;
            border-radius: 5px;
            border: none;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .btn-modificar {
            background-color: #4CAF50;
            color: white;
        }

        .btn-modificar:hover {
            background-color: #45a049;
        }

        .btn-eliminar {
            background-color: #f44336;
            color: white;
        }

        .btn-eliminar:hover {
            background-color: #e53935;
        }

        .btn-agregar {
            background-color: #008CBA;
            color: white;
            display: inline-block;
            margin: 20px 0;
        }

        .btn-agregar:hover {
            background-color: #007bb5;
        }

        a {
            color: #007bff;
            text-decoration: none;
        }

        a:hover {
            text-decoration: underline;
        }

        .container {
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
        }

        .volver {
            display: inline-block;
            margin-top: 20px;
            padding: 10px 15px;
            background-color: #6c757d;
            color: white;
            border: none;
            border-radius: 5px;
            text-align: center;
            text-decoration: none;
            transition: background-color 0.3s ease;
        }

        .volver:hover {
            background-color: #5a6268;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Ejercicios del Entrenamiento</h2>

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

        // Obtener el ID del entrenamiento de la URL
        if (isset($_GET['id_entrenamiento'])) {
            $id_entrenamiento = $_GET['id_entrenamiento'];
        } else {
            die("ID de entrenamiento no especificado.");
        }

        // Eliminar ejercicio si se ha solicitado
        if (isset($_GET['accion']) && $_GET['accion'] == 'eliminar' && isset($_GET['id_ejercicio'])) {
            $id_ejercicio = $_GET['id_ejercicio'];
            $sql_eliminar = "DELETE FROM Ejercycyo WHERE ID_Ejercycyo = $id_ejercicio";
            if ($conn->query($sql_eliminar) === TRUE) {
                echo "Ejercicio eliminado correctamente.<br>";
            } else {
                echo "Error eliminando el ejercicio: " . $conn->error . "<br>";
            }
        }

        // Consulta SQL para obtener los ejercicios del entrenamiento
        $sql = "SELECT * FROM Ejercycyo WHERE ID_entrenamiento = $id_entrenamiento";

        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            // Mostrar los resultados en una tabla
            echo "<table>";
            echo "<tr><th>Nombre</th><th>Series</th><th>Repeticiones</th><th>Modificar</th><th>Eliminar</th></tr>";
            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>".$row["nombre"]."</td>";
                echo "<td>".$row["seryes"]."</td>";
                echo "<td>".$row["repetyciones"]."</td>";
                echo "<td><a href='modificar_ejercicio.php?id_ejercicio=".$row["ID_Ejercycyo"]."'><button class='btn-modificar'>Modificar</button></a></td>";
                echo "<td><a href='ejercicios_dueño.php?id_entrenamiento=".$id_entrenamiento."&accion=eliminar&id_ejercicio=".$row["ID_Ejercycyo"]."'><button class='btn-eliminar'>Eliminar</button></a></td>";
                echo "</tr>";
            }
            echo "</table>";
        } else {
            echo "No se encontraron ejercicios para este entrenamiento";
        }
        // Obtener el nombre de la categoría
        $sql_categoria = "SELECT c.nombre 
                          FROM categorya c 
                          JOIN Entrenamiento e ON c.ID_categorya = e.ID_categorya 
                          WHERE e.ID_entrenamiento = ?";
        $stmt_categoria = $conn->prepare($sql_categoria);
        $stmt_categoria->bind_param("i", $id_entrenamiento);
        $stmt_categoria->execute();
        $result_categoria = $stmt_categoria->get_result();
        $categoria = $result_categoria->fetch_assoc();
        $redireccion = $categoria['nombre'];

        // Cerrar la conexión
        $conn->close();
        ?>

        <a href="agregar_ejercicio.php?id_entrenamiento=<?php echo $id_entrenamiento; ?>"><button class="btn-agregar">Agregar Ejercicio</button></a>

        <a href="<?php echo $redireccion; ?>_Dueño.php" class="volver">Volver a los entrenamientos</a>
    </div>
</body>
</html>
