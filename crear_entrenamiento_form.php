<?php
// Datos de conexión a la base de datos
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "tfg_v_0_2";

// Función para generar un ID único de números aleatorios menores a 32 bits
function generarIDUnico($conn, $longitud = 10) {
    $maxIntentos = 5; // Número máximo de intentos para evitar un bucle infinito
    $id_unico = '';

    for ($intentos = 0; $intentos < $maxIntentos; $intentos++) {
        // Generar un número aleatorio dentro del rango de 0 a 2^31 - 1
        $id_unico = mt_rand(0, 2147483647); // 2^31 - 1

        // Verificar si el ID único ya existe en la base de datos
        $sql_verificar = "SELECT ID_entrenamiento FROM Entrenamiento WHERE ID_entrenamiento = ?";
        $stmt_verificar = $conn->prepare($sql_verificar);
        $stmt_verificar->bind_param("s", $id_unico);
        $stmt_verificar->execute();
        $stmt_verificar->store_result();

        if ($stmt_verificar->num_rows == 0) {
            // No hay conflicto, el ID único es válido
            return $id_unico;
        }
    }

    // Si no se pudo generar un ID único después de los intentos, manejar el error
    die("No se pudo generar un ID único después de varios intentos.");
}

// Manejo de la selección de categoría y creación de nuevo entrenamiento
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Conexión a la base de datos
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Verificar la conexión
    if ($conn->connect_error) {
        die("Conexión fallida: " . $conn->connect_error);
    }

    // Verificar si se ha enviado el formulario para crear un nuevo entrenamiento
    if (isset($_POST['nombre'])) {
        $nombre = $_POST['nombre'];

        // Obtener el ID de la categoría desde la cookie (si está configurada)
        $id_categorya = isset($_COOKIE['id_categorya']) ? $_COOKIE['id_categorya'] : null;

        // Verificar que se haya seleccionado una categoría
        if ($id_categorya === null) {
            die("Error: No se ha seleccionado una categoría.");
        }

        // Obtener el ID del dueño desde la cookie (ajustar según tu aplicación)
        $id_dueño = isset($_COOKIE['id_dueño']) ? $_COOKIE['id_dueño'] : 1; // Asegúrate de que esta cookie esté configurada correctamente

        // Generar un ID de entrenamiento único
        $id_entrenamiento = generarIDUnico($conn);

        // Insertar el nuevo entrenamiento en la base de datos
        $sql = "INSERT INTO Entrenamiento (ID_entrenamiento, nombre, ID_categorya, ID_Dueño) VALUES (?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssii", $id_entrenamiento, $nombre, $id_categorya, $id_dueño);

        if ($stmt->execute()) {
            // Obtener el nombre de la categoría
            $sql_category = "SELECT nombre FROM categorya WHERE ID_categorya = ?";
            $stmt_category = $conn->prepare($sql_category);
            $stmt_category->bind_param("i", $id_categorya);
            $stmt_category->execute();
            $result = $stmt_category->get_result();
            $category = $result->fetch_assoc();
            
            // Guardar el nombre de la categoría en una variable
            $redireccion = $category['nombre'];
            
            // Redirigir a la página correspondiente
            header("Location: " . $redireccion . "_Dueño.php");
            exit;
        } else {
            echo "Error al crear el entrenamiento: " . $stmt->error;
        }

        // Cerrar la conexión
        $stmt->close();
    }

    // Cerrar la conexión
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear Nuevo Entrenamiento</title>
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

        form {
            max-width: 400px;
            margin: 0 auto;
            padding: 20px;
            background-color: #fff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
        }

        label {
            display: block;
            margin-bottom: 8px;
            color: #555;
        }

        input[type="text"], input[type="submit"], button {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
            border-radius: 4px;
            border: 1px solid #ddd;
            box-sizing: border-box;
        }

        input[type="text"] {
            font-size: 16px;
        }

        input[type="submit"], button {
            background-color: #28a745;
            color: white;
            font-size: 16px;
            cursor: pointer;
            border: none;
            transition: background-color 0.3s ease;
        }

        input[type="submit"]:hover, button:hover {
            background-color: #218838;
        }

        button {
            background-color: #007bff;
        }

        button:hover {
            background-color: #0056b3;
        }

        .button-container {
            text-align: center;
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <h2>Crear Nuevo Entrenamiento</h2>
    <form action="" method="post">
        <label for="nombre">Nombre del Entrenamiento:</label>
        <input type="text" id="nombre" name="nombre" required>

        <input type="submit" value="Crear Entrenamiento">
    </form>
    <div class="button-container">
        <button type="button" onclick="window.history.back()">Volver</button>
    </div>
</body>
</html>
