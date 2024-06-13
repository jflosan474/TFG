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

// Variable para almacenar el mensaje de éxito o error
$mensaje = "";

// Verificar si se ha enviado el formulario de creación
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $usuario = $_POST['usuario'];
    $contrasena = $_POST['contrasena'];
    $nombre = $_POST['nombre'];
    $apellidos = $_POST['apellidos'];
    $edad = $_POST['edad'];
    $estatura = $_POST['estatura'];
    $telefono = $_POST['telefono'];
    $genero = $_POST['genero'];
    $yncyo_sub = $_POST['yncyo_sub'];
    $fyn_sub = $_POST['fyn_sub'];

    // Generar un ID de usuario aleatorio de 32 bytes (256 bits)
    $id_usuario = mt_rand(0, 2147483647);

    // Query para insertar un nuevo usuario
    $sql_insertar = "INSERT INTO Usuario (ID_usuario, usuario, contraseña, nombre, apellidos, edad, estatura, telefono, genero, yncyo_sub, fyn_sub) VALUES ('$id_usuario', '$usuario', '$contrasena', '$nombre', '$apellidos', $edad, $estatura, '$telefono', '$genero', '$yncyo_sub', '$fyn_sub')";

    if ($conn->query($sql_insertar) === TRUE) {
        $mensaje = "Usuario creado correctamente.";
        // Limpiar los valores después de la inserción
        $_POST = array();
    } else {
        $mensaje = "Error al crear el usuario: " . $conn->error;
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear Usuario</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f0f0;
            margin: 0;
            padding: 20px;
        }

        .container {
            max-width: 600px;
            margin: 0 auto;
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            border: 1px solid #ccc;
        }

        h2 {
            text-align: center;
            margin-bottom: 20px;
        }

        form {
            margin-bottom: 20px;
        }

        label {
            font-weight: bold;
            display: block;
            margin-bottom: 8px;
        }

        input[type="text"],
        input[type="password"],
        input[type="number"],
        input[type="tel"],
        select {
            width: calc(100% - 20px);
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 16px;
            box-sizing: border-box;
        }

        select {
            width: 100%;
            height: 40px;
        }

        input[type="submit"],
        input[type="button"] {
            padding: 12px 20px;
            background-color: #007BFF;
            color: white;
            border: none;
            cursor: pointer;
            border-radius: 4px;
            font-size: 16px;
            transition: background-color 0.3s;
            width: auto;
        }

        input[type="submit"]:hover,
        input[type="button"]:hover {
            background-color: #0056b3;
        }

        .button-container {
            text-align: center;
            margin-top: 20px;
        }

        .button-container a button {
            padding: 12px 20px;
            background-color: #6c757d;
            color: white;
            border: none;
            cursor: pointer;
            border-radius: 4px;
            font-size: 16px;
            text-decoration: none;
            transition: background-color 0.3s;
        }

        .button-container a button:hover {
            background-color: #5a6268;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Crear Usuario</h2>
        <?php
        if (!empty($mensaje)) {
            echo "<p>$mensaje</p>";
        }
        ?>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <label for="usuario">Usuario:</label>
            <input type="text" id="usuario" name="usuario" value="<?php if(isset($_POST['usuario'])) echo $_POST['usuario']; ?>" required>

            <label for="contrasena">Contraseña:</label>
            <input type="password" id="contrasena" name="contrasena" value="<?php if(isset($_POST['contrasena'])) echo $_POST['contrasena']; ?>" required>

            <label for="nombre">Nombre:</label>
            <input type="text" id="nombre" name="nombre" value="<?php if(isset($_POST['nombre'])) echo $_POST['nombre']; ?>" required>

            <label for="apellidos">Apellidos:</label>
            <input type="text" id="apellidos" name="apellidos" value="<?php if(isset($_POST['apellidos'])) echo $_POST['apellidos']; ?>" required>

            <label for="edad">Edad:</label>
            <input type="number" id="edad" name="edad" value="<?php if(isset($_POST['edad'])) echo $_POST['edad']; ?>" required>

            <label for="estatura">Estatura (metros):</label>
            <input type="number" id="estatura" name="estatura" step="0.01" value="<?php if(isset($_POST['estatura'])) echo $_POST['estatura']; ?>" required>

            <label for="telefono">Teléfono:</label>
            <input type="tel" id="telefono" name="telefono" value="<?php if(isset($_POST['telefono'])) echo $_POST['telefono']; ?>" required>

            <label for="genero">Género:</label>
            <select id="genero" name="genero" required>
                <option value="Masculino" <?php if(isset($_POST['genero']) && $_POST['genero'] == 'Masculino') echo 'selected'; ?>>Masculino</option>
                <option value="Femenino" <?php if(isset($_POST['genero']) && $_POST['genero'] == 'Femenino') echo 'selected'; ?>>Femenino</option>
                <option value="Otro" <?php if(isset($_POST['genero']) && $_POST['genero'] == 'Otro') echo 'selected'; ?>>Otro</option>
            </select>

            <label for="yncyo_sub">Fecha inicio Subscripción (YYYY-MM-DD):</label>
            <input type="text" id="yncyo_sub" name="yncyo_sub" value="<?php if(isset($_POST['yncyo_sub'])) echo $_POST['yncyo_sub']; ?>" required>

            <label for="fyn_sub">Fecha fin Subscripción (YYYY-MM-DD):</label>
            <input type="text" id="fyn_sub" name="fyn_sub" value="<?php if(isset($_POST['fyn_sub'])) echo $_POST['fyn_sub']; ?>" required>

            <input type="submit" value="Crear Usuario">
        </form>

        <div class="button-container">
            <a href="miembros_Dueño.php"><button>Volver</button></a>
        </div>
    </div>
</body>
</html>
