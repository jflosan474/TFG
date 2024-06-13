<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agregar Ejercicio</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f0f0;
            margin: 0;
            padding: 20px;
            color: #333;
        }

        .container {
            max-width: 500px;
            margin: 0 auto;
            background-color: #fff;
            padding: 20px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
        }

        h2 {
            text-align: center;
            color: #333;
            margin-bottom: 20px;
        }

        label {
            display: block;
            margin-bottom: 8px;
            font-weight: bold;
        }

        input[type="text"], input[type="number"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
        }

        input[type="submit"] {
            width: 100%;
            padding: 10px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
        }

        input[type="submit"]:hover {
            background-color: #45a049;
        }

        .back-link {
            display: block;
            text-align: center;
            margin-top: 20px;
            color: #007bff;
            text-decoration: none;
        }

        .back-link:hover {
            text-decoration: underline;
        }

        .message {
            text-align: center;
            margin-bottom: 20px;
            padding: 10px;
            background-color: #e7f3e7;
            color: #2e7d32;
            border: 1px solid #2e7d32;
            border-radius: 5px;
        }

        .error {
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Agregar Ejercicio</h2>

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
            die("<div class='message error'>Conexión fallida: " . $conn->connect_error . "</div>");
        }

        // Obtener el ID del entrenamiento de la URL
        $id_entrenamiento = $_GET['id_entrenamiento'];

        // Verificar si se enviaron datos del formulario para agregar el ejercicio
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $nombre = $_POST['nombre'];
            $seryes = $_POST['seryes'];
            $repetyciones = $_POST['repetyciones'];

            // Insertar los datos del nuevo ejercicio en la base de datos
            $sql = "INSERT INTO Ejercycyo (nombre, seryes, repetyciones, ID_entrenamiento) VALUES ('$nombre', $seryes, $repetyciones, $id_entrenamiento)";

            if ($conn->query($sql) === TRUE) {
                echo "<div class='message'>Ejercicio agregado correctamente</div>";
            } else {
                echo "<div class='message error'>Error agregando el ejercicio: " . $conn->error . "</div>";
            }
        }

        // Cerrar la conexión
        $conn->close();
        ?>

        <form action="" method="post">
            <label for="nombre">Nombre:</label>
            <input type="text" id="nombre" name="nombre" required>

            <label for="seryes">Series:</label>
            <input type="number" id="seryes" name="seryes" required>

            <label for="repetyciones">Repeticiones:</label>
            <input type="number" id="repetyciones" name="repetyciones" required>

            <input type="submit" value="Agregar Ejercicio">
        </form>

        <a class="back-link" href="ejercicios_dueño.php?id_entrenamiento=<?php echo $id_entrenamiento; ?>">Volver a los ejercicios</a>
    </div>
</body>
</html>
