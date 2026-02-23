<?php
// 1. Definir la URL de la API de Pokémon
$url = "https://pokeapi.co/api/v2/pokemon?limit=20";

// 2. Obtener la lista de Pokémon usando file_get_contents()
$respuestaJson = file_get_contents($url);

// 3. Verificar si la llamada fue exitosa
if ($respuestaJson === FALSE) {
    $error = "No se pudo conectar con la API.";
    $pokemonLista = [];
} else {
    // 4. Decodificar el JSON a un array de PHP
    $datos = json_decode($respuestaJson, true);

    if ($datos && isset($datos['results'])) {
        $pokemonLista = $datos['results']; // Array con nombres y URLs
    } else {
        $error = "Error al procesar los datos de Pokémon.";
        $pokemonLista = [];
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pokédex - App PHP</title>
    <link rel="stylesheet" href="style/estiloTarea9DWES.css">
</head>
<body>
<div class="container">
    <header>
        <h1>Pokédex PHP</h1>
        <p class="subtitle">¡Los primeros 20 Pokémon!</p>
    </header>

    <?php if (!empty($error)): ?>
        <div class="error-mensaje"><?php echo $error; ?></div>
    <?php endif; ?>

    <div class="pokemon-grid">
        <?php if (!empty($pokemonLista)): ?>
            <?php foreach ($pokemonLista as $index => $pokemon):
                // Extraer el ID del Pokémon desde su URL
                $id = explode('/', rtrim($pokemon['url'], '/'));
                $id = end($id);

                // Construir URL de la imagen oficial de Pokémon
                $imagenUrl = "https://raw.githubusercontent.com/PokeAPI/sprites/master/sprites/pokemon/other/official-artwork/{$id}.png";

                // Capitalizar el nombre del Pokémon
                $nombre = ucfirst($pokemon['name']);
                ?>
                <div class="pokemon-card">
                    <div class="pokemon-imagen">
                        <img src="<?php echo $imagenUrl; ?>"
                             alt="<?php echo $nombre; ?>"
                             onerror="this.src='https://raw.githubusercontent.com/PokeAPI/sprites/master/sprites/pokemon/versions/generation-v/black-white/animated/<?php echo $id; ?>.gif'">
                    </div>
                    <div class="pokemon-info">
                        <span class="pokemon-id">#<?php echo str_pad($id, 3, '0', STR_PAD_LEFT); ?></span>
                        <h2 class="pokemon-nombre"><?php echo $nombre; ?></h2>
                        <a href="detalle.php?pokemon=<?php echo $pokemon['name']; ?>" class="btn-ver">Ver detalles</a>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p class="no-resultados">No se encontraron Pokémon. Intenta de nuevo más tarde.</p>
        <?php endif; ?>
    </div>

    <footer>
        <p>&copy; - ManuFer - Datos proporcionados por <a href="https://pokeapi.co/" target="_blank">PokeAPI</a></p>
    </footer>
</div>
</body>
</html>