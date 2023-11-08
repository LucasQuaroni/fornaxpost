<?php
$conn = new mysqli("localhost", "root", "", "fornaxpost");

//verifica si se proporcionó un número de serie en la URL.
if (isset($_GET['serial'])) {
    $serial = $_GET['serial'];

    //consulta para obtener los detalles del artefacto según el número de serie.
    $sql = "SELECT * FROM artefactos WHERE serial = '$serial'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $artefacto = $result->fetch_assoc();
    }
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalles del Artefacto</title>
</head>

<body>
    <h1>Detalles del Artefacto</h1>
    <?php if (isset($artefacto)): ?>
        <p><b>Número de Serie:</b>
            <?php echo $artefacto['serial']; ?>
        </p>
        <p><b>Modelo:</b>
            <?php echo $artefacto['modelo']; ?>
        </p>
        <p><b>Garantía:</b>
            <?php echo ($artefacto['garantia'] === 'S') ? 'Sí' : 'No'; ?>
        </p>
        <p><b>Vendedor:</b>
            <?php echo $artefacto['vendedor']; ?>
    <?php else: ?>
        <p>El artefacto no existe o se produjo un error al cargar los detalles.</p>
    <?php endif; ?>
</body>

</html>