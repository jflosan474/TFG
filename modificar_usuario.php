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

// Verificar si se ha enviado el formulario de modificación
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id_usuario = $_POST['id_usuario'];
    $usuario = $_POST['usuario'];
    $contrasena = $_POST['contrasena'];
    $nombre = $_POST['nombre'];
    $apellidos = $_POST['apellidos'];
    $edad = $_POST['edad'];
    $estatura = $_POST['estatura'];
    $telefono = $_POST['telefono'];
    $genero = $_POST['genero'];
    $yncyo_sub = $_POST['yncyo_sub'];
    $fyn_sub = $_POST['fyn_sub']; // Nuevo campo añadido

    // Query para actualizar los datos del usuario
    $sql_actualizar = "UPDATE Usuario SET usuario='$usuario', contraseña='$contrasena', nombre='$nombre', apellidos='$apellidos', edad=$edad, estatura=$estatura, telefono='$telefono', genero='$genero', yncyo_sub='$yncyo_sub', fyn_sub='$fyn_sub' WHERE ID_usuario=$id_usuario";

    if ($conn->query($sql_actualizar) === TRUE) {
        $mensaje = "Usuario actualizado correctamente.";
    } else {
        $mensaje = "Error al actualizar el usuario: " . $conn->error;
    }
}

// Obtener el ID del usuario desde la URL o el formulario POST
if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['id_usuario'])) {
    $id_usuario = $_GET['id_usuario'];
} elseif ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['id_usuario'])) {
    $id_usuario = $_POST['id_usuario'];
} else {
    $mensaje = "ID de usuario no especificado.";
}

// Query para obtener los datos del usuario
$sql = "SELECT * FROM Usuario WHERE ID_usuario=$id_usuario";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $usuario = $result->fetch_assoc();
} else {
    $mensaje = "Usuario no encontrado.";
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modificar Usuario</title>
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
            max-width: 600px;
            margin: 0 auto;
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            border: 1px solid #ccc;
        }

        label {
            font-weight: bold;
            margin-bottom: 5px;
            display: block;
        }

        input[type="text"],
        input[type="password"],
        input[type="number"],
        input[type="tel"],
        select {
            width: calc(100% - 20px);
            padding: 8px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 14px;
        }

        select {
            width: 100%;
        }

        input[type="submit"],
        input[type="button"] {
            margin-top: 10px;
            padding: 10px 20px;
            background-color: #007BFF;
            color: white;
            border: none;
            cursor: pointer;
            border-radius: 4px;
            font-size: 16px;
        }

        input[type="submit"]:hover,
        input[type="button"]:hover {
            background-color: #0056b3;
        }

        .button-container {
            text-align: center;
            margin-top: 20px;
        }

        .button-container button {
            padding: 10px 20px;
            background-color: #6c757d;
            color: white;
            border: none;
            cursor: pointer;
            border-radius: 4px;
            font-size: 16px;
            text-decoration: none;
            transition: background-color 0.3s ease;
        }

        .button-container button:hover {
            background-color: #5a6268;
        }
    </style>
</head>
<body>
    <h2>Modificar Usuario</h2>
    
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        <input type="hidden" name="id_usuario" value="<?php echo $usuario['ID_usuario']; ?>">

        <label for="usuario">Usuario:</label>
        <input type="text" id="usuario" name="usuario" value="<?php echo $usuario['usuario']; ?>" required>

        <label for="contrasena">Contraseña:</label>
        <input type="password" id="contrasena" name="contrasena" value="<?php echo $usuario['contraseña']; ?>" required>

        <label for="nombre">Nombre:</label>
        <input type="text" id="nombre" name="nombre" value="<?php echo $usuario['nombre']; ?>" required>

        <label for="apellidos">Apellidos:</label>
        <input type="text" id="apellidos" name="apellidos" value="<?php echo $usuario['apellidos']; ?>" required>

        <label for="edad">Edad:</label>
        <input type="number" id="edad" name="edad" value="<?php echo $usuario['edad']; ?>" required>

        <label for="estatura">Estatura (metros):</label>
        <input type="number" id="estatura" name="estatura" step="0.01" value="<?php echo $usuario['estatura']; ?>" required>

        <label for="telefono">Teléfono:</label>
        <input type="tel" id="telefono" name="telefono" value="<?php echo $usuario['telefono']; ?>" required>

        <label for="genero">Género:</label>
        <select id="genero" name="genero" required>
            <option value="Masculino" <?php if ($usuario['genero'] == 'Masculino') echo 'selected'; ?>>Masculino</option>
            <option value="Femenino" <?php if ($usuario['genero'] == 'Femenino') echo 'selected'; ?>>Femenino</option>
            <option value="Otro" <?php if ($usuario['genero'] == 'Otro') echo 'selected'; ?>>Otro</option>
        </select>

        <label for="yncyo_sub">Fecha inicio Subscripcion (YYYY-MM-DD):</label>
        <input type="text" id="yncyo_sub" name="yncyo_sub" value="<?php echo $usuario['yncyo_sub']; ?>" required>

        <label for="fyn_sub">Fecha fin Subscripcion (YYYY-MM-DD):</label>
        <input type="text" id="fyn_sub" name="fyn_sub" value="<?php echo $usuario['fyn_sub']; ?>" required>

        <input type="submit" value="Guardar Cambios">
    </form>

    <div class="button-container">
        <a href="miembros_Dueño.php"><button>Volver</button></a>
    </div>
</body>
</html>