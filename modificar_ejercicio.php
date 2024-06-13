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

// Obtener el ID del ejercicio de la URL
$id_ejercicio = $_GET['id_ejercicio'];

// Verificar si se enviaron datos del formulario para actualizar el ejercicio
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = $_POST['nombre'];
    $seryes = $_POST['seryes'];
    $repetyciones = $_POST['repetyciones'];

    // Actualizar los datos del ejercicio en la base de datos
    $sql = "UPDATE Ejercycyo SET nombre='$nombre', seryes=$seryes, repetyciones=$repetyciones WHERE ID_Ejercycyo=$id_ejercicio";

    if ($conn->query($sql) === TRUE) {
        echo "<div class='message'>Ejercicio actualizado correctamente</div>";
    } else {
        echo "<div class='message error'>Error actualizando el ejercicio: " . $conn->error . "</div>";
    }
}

// Obtener los detalles del ejercicio para mostrarlos en el formulario
$sql = "SELECT * FROM Ejercycyo WHERE ID_Ejercycyo = $id_ejercicio";
$result = $conn->query($sql);
$ejercicio = $result->fetch_assoc();

// Cerrar la conexión
$conn->close();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modificar Ejercicio</title>
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
        <h2>Modificar Ejercicio</h2>

        <form action="" method="post">
            <label for="nombre">Nombre:</label>
            <input type="text" id="nombre" name="nombre" value="<?php echo $ejercicio['nombre']; ?>" required>

            <label for="seryes">Series:</label>
            <input type="number" id="seryes" name="seryes" value="<?php echo $ejercicio['seryes']; ?>" required>

            <label for="repetyciones">Repeticiones:</label>
            <input type="number" id="repetyciones" name="repetyciones" value="<?php echo $ejercicio['repetyciones']; ?>" required>

            <input type="submit" value="Actualizar">
        </form>

        <a class="back-link" href="ejercicios_dueño.php?id_entrenamiento=<?php echo $ejercicio['ID_entrenamiento']; ?>">Volver a los ejercicios</a>
    </div>
</body>
</html>
