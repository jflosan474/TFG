<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Entrenamientos del Dueño</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f0f0;
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            height: 100vh;
        }

        h2 {
            text-align: center;
            color: #333;
            margin-bottom: 20px;
        }

        .categories-container {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 20px;
            margin-bottom: 20px;
        }

        .category-link {
            text-decoration: none;
            text-align: center;
        }

        .category-button {
            display: flex;
            flex-direction: column;
            align-items: center;
            padding: 10px;
            width: 200px; /* Ancho fijo para cada botón */
            border: none;
            border-radius: 8px;
            cursor: pointer;
            transition: background-color 0.3s ease;
            background-color: #007bff;
            color: white;
        }

        .category-button:hover {
            background-color: #0056b3;
        }

        .category-button img {
            width: 150px; /* Ancho máximo de la imagen */
            height: 150px; /* Altura máxima de la imagen */
            object-fit: cover; /* Ajuste para cubrir completamente el área */
            border-radius: 50%; /* Forma circular si es necesario */
            margin-bottom: 10px; /* Espacio entre la imagen y el texto */
        }

        .bottom-button {
            margin-top: auto;
            margin-bottom: 20px;
        }

        .bottom-button button {
            background-color: #6c757d;
            color: white;
            border: none;
            padding: 12px 20px;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .bottom-button button:hover {
            background-color: #5a6268;
        }
    </style>
</head>
<body>
    <h2>Seleccione una categoría de entrenamiento:</h2>

    <div class="categories-container">
        <a href="espalda_dueño.php" class="category-link">
            <button class="category-button">
                <img src="espalda.jpg" alt="Espalda">
                Espalda
            </button>
        </a>
        <a href="abdominales_dueño.php" class="category-link">
            <button class="category-button">
                <img src="abdomynales.jpg" alt="Abdominales">
                Abdominales
            </button>
        </a>
        <a href="hombros_dueño.php" class="category-link">
            <button class="category-button">
                <img src="hombro.jpg" alt="Hombros">
                Hombros
            </button>
        </a>
        <a href="piernas_dueño.php" class="category-link">
            <button class="category-button">
                <img src="pyerna.jpg" alt="Piernas">
                Piernas
            </button>
        </a>
        <a href="pecho_dueño.php" class="category-link">
            <button class="category-button">
                <img src="pecho.jpg" alt="Pecho">
                Pecho
            </button>
        </a>
    </div>

    <div class="bottom-button">
        <a href="dashboard_Dueño.php">
            <button>Volver al Panel</button>
        </a>
    </div>
</body>
</html>