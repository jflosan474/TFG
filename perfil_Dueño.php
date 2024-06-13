<?php
// Datos de conexión a la base de datos
$servername = "localhost";  // Cambia localhost por el servidor de tu base de datos si es diferente
$username = "root";
$password = "";
$dbname = "tfg_v_0_2";

// Crear conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar la conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

//echo "Conexión establecida correctamente<br>";

// Verificar si la cookie existe y obtener el nombre de usuario logado
$usuario_logado = isset($_COOKIE['usuario_logado']) ? $_COOKIE['usuario_logado'] : '';

// Consultar la base de datos para obtener los datos del dueño logado
if (!empty($usuario_logado)) {
    $sql = "SELECT * FROM Dueño WHERE usuario = '$usuario_logado'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // Obtener los datos del dueño
        $row = $result->fetch_assoc();
        $usuario = $row['usuario'];
        $contraseña = $row['contraseña'];

    } else {
        echo "No se encontraron datos para el usuario logado";
    }
} else {
    echo "No se ha encontrado la cookie de usuario logado";
}

// Cerrar la conexión
$conn->close();

// Si se ha enviado el formulario de modificación
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtener los datos del formulario
    $usuario = $_POST['usuario'];
    $contraseña = $_POST['contraseña'];

    // Crear conexión
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Verificar la conexión
    if ($conn->connect_error) {
        die("Conexión fallida: " . $conn->connect_error);
    }

    // Preparar consulta SQL para actualizar los datos del dueño
    $sql_update = "UPDATE Dueño SET usuario='$usuario', contraseña='$contraseña' WHERE usuario='$usuario_logado'";

    if ($conn->query($sql_update) === TRUE) {
        //echo "Datos actualizados correctamente";
        // Actualizar la cookie de usuario logueado si se cambió el usuario
        if ($usuario !== $usuario_logado) {
            setcookie('usuario_logado', $usuario, time() + (86400 * 30), "/"); // Cookie válida por 30 días
        }
    } else {
        echo "Error al actualizar los datos: " . $conn->error;
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
    <title>Perfil del Dueño</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f0f0;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .profile-container {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 90%;
            max-width: 600px;
            text-align: center;
        }

        h2 {
            margin-bottom: 20px;
            color: #333;
        }

        form {
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        label {
            font-weight: bold;
            margin-bottom: 8px;
        }

        input[type="text"], input[type="password"] {
            width: 100%;
            padding: 10px;
            margin: 5px 0;
            box-sizing: border-box;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        input[type="submit"], button {
            padding: 12px 20px;
            font-size: 16px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s ease;
            margin-top: 10px;
        }

        input[type="submit"]:hover, button:hover {
            background-color: #0056b3;
        }

        a {
            text-decoration: none;
            color: #333;
        }

        button {
            background-color: #6c757d;
        }

        button:hover {
            background-color: #5a6268;
        }
    </style>
</head>
<body>
    <div class="profile-container">
        <h2>Perfil del Dueño: <?php echo $usuario_logado; ?></h2>
        <form action="#" method="post">
            <label for="usuario">Usuario:</label><br>
            <input type="text" id="usuario" name="usuario" value="<?php echo htmlspecialchars($usuario); ?>"><br><br>

            <label for="contraseña">Contraseña:</label><br>
            <input type="password" id="contraseña" name="contraseña" value="<?php echo htmlspecialchars($contraseña); ?>"><br><br>

            <input type="submit" name="modificar" value="Modificar" onclick="return confirmarModificacion();">
        </form>
        <a href="dashboard_Dueño.php"><button>Volver al Panel</button></a>
    </div>

    <script>
        function confirmarModificacion() {
            return confirm("¿Estás seguro de que deseas modificar los datos?");
        }
    </script>
</body>
</html>