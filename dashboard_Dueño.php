<?php
// Verificar si la cookie existe y obtener el nombre de usuario logado
$usuario_logado = isset($_COOKIE['usuario_logado']) ? $_COOKIE['usuario_logado'] : '';

// Verificar si el usuario está logado antes de mostrar el panel
if (empty($usuario_logado)) {
    header("Location: index.php");
    exit();
}

// Función para cerrar sesión
function cerrar_sesion() {
    // Eliminar la cookie de sesión
    setcookie('usuario_logado', '', time() - 3600, '/');
    // Redirigir al índice
    header("Location: index.php");
    exit();
}

// Verificar si se ha solicitado cerrar sesión
if (isset($_POST['cerrar_sesion'])) {
    cerrar_sesion();
}
?><!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel de Control</title>
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

        .panel-container {
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

        .buttons-container {
            display: flex;
            justify-content: center;
            flex-wrap: wrap; /* Para manejar múltiples líneas si es necesario */
            gap: 20px; /* Espacio entre botones */
            margin-bottom: 20px;
        }

        .buttons-container a {
            text-decoration: none;
        }

        .buttons-container button {
            display: flex;
            flex-direction: column;
            align-items: center;
            padding: 10px; /* Espaciado interior */
            font-size: 16px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            transition: background-color 0.3s ease;
            width: 200px; /* Ancho fijo para cada botón */
            height: 200px; /* Altura fija para cada botón */
        }

        .buttons-container button img {
            width: 150px; /* Ancho máximo de la imagen */
            height: 150px; /* Altura máxima de la imagen */
            object-fit: cover; /* Ajuste para cubrir completamente el área */
            border-radius: 50%; /* Forma circular si es necesario */
        }

        .buttons-container button span {
            margin-top: 10px; /* Espacio entre imagen y texto */
        }

        .buttons-container button:hover {
            background-color: #0056b3;
        }

        .logout-form {
            display: inline;
        }

        .logout-form button {
            background-color: #f44336;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .logout-form button:hover {
            background-color: #d32f2f;
        }
    </style>
</head>
<body>
    <div class="panel-container">
        <h2>Panel de Control del <?php echo $usuario_logado; ?></h2>
        
        <div class="buttons-container">
            <a href="perfil_Dueño.php">
                <button>
                    <img src="perfyl.png" alt="Perfil">
                    <span>Perfil</span>
                </button>
            </a>
            <a href="entrenamientos_Dueño.php">
                <button>
                    <img src="entreno.jpg" alt="Entrenamientos">
                    <span>Entrenamientos</span>
                </button>
            </a>
            <a href="miembros_Dueño.php">
                <button>
                    <img src="myembros.jpg" alt="Miembros y Subscripciones">
                    <span>Miembros y Subscripciones</span>
                </button>
            </a>
        </div>
        
        <!-- Formulario para cerrar sesión -->
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" class="logout-form">
            <input type="hidden" name="cerrar_sesion">
            <button type="submit">Cerrar Sesión</button>
        </form>
    </div>
</body>
</html>