<?php
$conn = new mysqli("localhost", "root", "", "fornaxpost");

// Verifica si se proporcionó un DNI en la URL.
if (isset($_GET['dni'])) {
    $dni = $_GET['dni'];

    // Realiza una consulta para obtener los detalles del cliente según el DNI.
    $sql = "SELECT * FROM clientes WHERE dni = '$dni'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $cliente = $result->fetch_assoc();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalles del Cliente</title>
    <!-- Agrega tus estilos CSS aquí -->
</head>
<body>
    <h1>Detalles del Cliente</h1>
    <?php if (isset($cliente)): ?>
        <p><b>DNI:</b> <?php echo $cliente['dni']; ?></p>
        <p><b>Nombre y Apellido:</b> <?php echo $cliente['nombreYapellido']; ?></p>
        <p><b>Domicilio:</b> <?php echo $cliente['domicilio']; ?></p>
        <p><b>Teléfono:</b> <?php echo $cliente['telefono']; ?></p>
        <p><b>Correo Electrónico:</b> <?php echo $cliente['email']; ?></p>
        <!-- Agrega más detalles según sea necesario. -->
    <?php else: ?>
        <p>El cliente no existe o se produjo un error al cargar los detalles.</p>
    <?php endif; ?>
</body>
</html>
