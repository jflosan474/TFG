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

$mensaje = '';

// Verificar si se ha especificado el ID de usuario a modificar
if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['id_usuario'])) {
    $id_usuario = $_GET['id_usuario'];
} else {
    // Redirigir a la página anterior si no se proporcionó un ID válido
    header("Location: index.php");
    exit();
}

// Consulta para obtener los datos del usuario
$sql = "SELECT * FROM Usuario WHERE ID_usuario=$id_usuario";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $usuario = $result->fetch_assoc();
} else {
    // Redirigir si el usuario no existe
    header("Location: index.php");
    exit();
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

        .form-container {
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
    <div class="form-container">
        <h2>Datos del Usuario</h2>
        
        <?php if (!empty($mensaje)) { ?>
            <p><?php echo $mensaje; ?></p>
        <?php } ?>
        
        <form>
            <label for="usuario">Usuario:</label>
            <input type="text" id="usuario" name="usuario" value="<?php echo $usuario['usuario']; ?>" readonly>

            <label for="contrasena">Contraseña:</label>
            <input type="password" id="contrasena" name="contrasena" value="<?php echo $usuario['contraseña']; ?>" readonly>

            <label for="nombre">Nombre:</label>
            <input type="text" id="nombre" name="nombre" value="<?php echo $usuario['nombre']; ?>" readonly>

            <label for="apellidos">Apellidos:</label>
            <input type="text" id="apellidos" name="apellidos" value="<?php echo $usuario['apellidos']; ?>" readonly>

            <label for="edad">Edad:</label>
            <input type="number" id="edad" name="edad" value="<?php echo $usuario['edad']; ?>" readonly>

            <label for="estatura">Estatura (metros):</label>
            <input type="number" id="estatura" name="estatura" step="0.01" value="<?php echo $usuario['estatura']; ?>" readonly>

            <label for="telefono">Teléfono:</label>
            <input type="tel" id="telefono" name="telefono" value="<?php echo $usuario['telefono']; ?>" readonly>

            <label for="genero">Género:</label>
            <input type="text" id="genero" name="genero" value="<?php echo $usuario['genero']; ?>" readonly>

            <label for="yncyo_sub">Fecha inicio Subscripcion (YYYY-MM-DD):</label>
            <input type="text" id="yncyo_sub" name="yncyo_sub" value="<?php echo $usuario['yncyo_sub']; ?>" readonly>

            <label for="fyn_sub">Fecha fin Subscripcion (YYYY-MM-DD):</label>
            <input type="text" id="fyn_sub" name="fyn_sub" value="<?php echo $usuario['fyn_sub']; ?>" readonly>

        </form>

        <div class="button-container">
            <a href="dashboard_Usuario.php"><button>Volver</button></a>
        </div>
    </div>
</body>
</html>
