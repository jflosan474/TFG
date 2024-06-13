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

echo "Conexión establecida correctamente<br>";

// Función para validar el login
function validarLogin($conn, $usuario, $contraseña) {
    // Escapar las entradas para prevenir SQL injection
    $usuario = mysqli_real_escape_string($conn, $usuario);
    $contraseña = mysqli_real_escape_string($conn, $contraseña);

    // Consultar la tabla Dueño
    $sql_dueño = "SELECT * FROM Dueño WHERE usuario='$usuario' AND contraseña='$contraseña'";
    $result_dueño = $conn->query($sql_dueño);

    // Consultar la tabla Usuario
    $sql_usuario = "SELECT * FROM Usuario WHERE usuario='$usuario' AND contraseña='$contraseña'";
    $result_usuario = $conn->query($sql_usuario);

    // Verificar si se encontró el usuario en alguna de las tablas
    if ($result_dueño->num_rows > 0) {
        return "Dueño";
    } elseif ($result_usuario->num_rows > 0) {
        return "Usuario";
    } else {
        return false;
    }
}

// Verificar si se enviaron datos de formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtener los datos del formulario
    $usuario = $_POST['usuario'];
    $contraseña = $_POST['contraseña'];

    // Validar el login
    $tipo_usuario = validarLogin($conn, $usuario, $contraseña);

    if ($tipo_usuario) {
        // Crear cookie para almacenar el nombre de usuario
        setcookie('usuario_logado', $usuario, time() + (86400 * 30), "/"); // Cookie válida por 30 días

        echo "Inicio de sesión exitoso como $tipo_usuario";
        // Aquí podrías redirigir al usuario a otra página
        // Por ejemplo:
        header("Location: dashboard_$tipo_usuario.php");
        exit();
    } else {
        echo "Usuario o contraseña incorrectos";
        header("Location: Index.php");
        exit();
    }
}

// Cerrar la conexión
$conn->close();
?>