<?php
session_start();

// Verificar si el usuario ha iniciado sesión
if (!isset($_SESSION['usuario'])) {
    header("Location: ../login/login.php");
    exit;
}

include("../../conexion.php");

$sql_reclamos_globales = "SELECT COUNT(*) as total FROM reclamos";
$sql_total_clientes = "SELECT COUNT(DISTINCT dni) as total FROM clientes";
$sql_total_trabajadores = "SELECT COUNT(*) as total FROM usuarios";

$result_reclamos_globales = mysqli_query($conn, $sql_reclamos_globales);
$result_total_clientes = mysqli_query($conn, $sql_total_clientes);
$result_total_trabajadores = mysqli_query($conn, $sql_total_trabajadores);

$row_reclamos_globales = mysqli_fetch_assoc($result_reclamos_globales);
$row_total_clientes = mysqli_fetch_assoc($result_total_clientes);
$row_total_trabajadores = mysqli_fetch_assoc($result_total_trabajadores);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Procesar fechas
    $fecha_inicio = $_POST['fecha_inicio'];
    $fecha_fin = $_POST['fecha_fin'];


    $sql_reclamos_totales = "SELECT COUNT(*) as total FROM reclamos WHERE fecha BETWEEN '$fecha_inicio' AND '$fecha_fin'";

    $sql_reclamos_finalizados = "SELECT COUNT(*) as finalizados FROM reclamos WHERE idestado = 'FIN' AND fecha BETWEEN '$fecha_inicio' AND '$fecha_fin'";

    $sql_reclamos_cancelados = "SELECT COUNT(*) as cancelados FROM reclamos WHERE idestado = 'CAN' AND fecha BETWEEN '$fecha_inicio' AND '$fecha_fin'";

    $sql_reclamos_pendientes = "SELECT COUNT(*) as pendientes FROM reclamos WHERE idestado != 'CAN' AND idestado != 'FIN' AND fecha BETWEEN '$fecha_inicio' AND '$fecha_fin'";


    $result_reclamos_totales = mysqli_query($conn, $sql_reclamos_totales);
    $result_reclamos_finalizados = mysqli_query($conn, $sql_reclamos_finalizados);
    $result_reclamos_cancelados = mysqli_query($conn, $sql_reclamos_cancelados);
    $result_reclamos_pendientes = mysqli_query($conn, $sql_reclamos_pendientes);

    $row_reclamos_totales = mysqli_fetch_assoc($result_reclamos_totales);
    $row_reclamos_finalizados = mysqli_fetch_assoc($result_reclamos_finalizados);
    $row_reclamos_cancelados = mysqli_fetch_assoc($result_reclamos_cancelados);
    $row_reclamos_pendientes = mysqli_fetch_assoc($result_reclamos_pendientes);

    // Calcular porcentaje
    $porcentaje_finalizados = ($row_reclamos_finalizados['finalizados'] / $row_reclamos_totales['total']) * 100;
    $porcentaje_cancelados = ($row_reclamos_cancelados['cancelados'] / $row_reclamos_totales['total']) * 100;
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Estadística</title>
    <link rel="stylesheet" href="../../estilos.css">
</head>

<body>
    <div class="header">
        <div class="logo">
            <img src="../../resources/logo-fornax-png.png">
        </div>
        <nav class="menu">
            <div class="nav-links">
                <a href="../admin.php">Volver</a>
            </div>
        </nav>
    </div>
    <br>
    <h1 align="center">Estadística</h1>
    <div class="estadisticas">
        <div class="fechas">
            <form action="estadistica.php" method="post">
                <div class="lineas">
                    <label for="fecha_inicio" class="subt">Fecha de inicio:</label>
                    <input type="date" name="fecha_inicio" id="fecha_inicio_input" required>
                </div>
                <div class="lineas">
                    <label for="fecha_fin" class="subt">Fecha de fin:</label>
                    <input type="date" name="fecha_fin" id="fecha_fin_input" required>
                </div>
                <input type="submit" class="button" value="Generar Estadísticas">
            </form>
        </div>
        <div class="tabla">
            <table>
                <tr>
                    <th>Descripción</th>
                    <th>Cantidad</th>
                </tr>
                <?php if (isset($row_reclamos_totales['total'])): ?>
                    <tr>
                        <td>Cantidad de reclamos realizados:</td>
                        <td>
                            <?php echo $row_reclamos_totales['total']; ?>
                        </td>
                    </tr>
                <?php endif; ?>

                <?php if (isset($row_reclamos_finalizados['finalizados'])): ?>
                    <tr>
                        <td>Cantidad de reclamos finalizados:</td>
                        <td>
                            <?php echo $row_reclamos_finalizados['finalizados']; ?>
                        </td>
                    </tr>
                <?php endif; ?>

                <?php if (isset($row_reclamos_cancelados['cancelados'])): ?>
                    <tr>
                        <td>Cantidad de reclamos cancelados:</td>
                        <td>
                            <?php echo $row_reclamos_cancelados['cancelados']; ?>
                        </td>
                    </tr>
                <?php endif; ?>

                <?php if (isset($row_reclamos_pendientes['pendientes'])): ?>
                    <tr>
                        <td>Cantidad de reclamos pendientes:</td>
                        <td>
                            <?php echo $row_reclamos_pendientes['pendientes']; ?>
                        </td>
                    </tr>
                <?php endif; ?>

                <?php if (isset($porcentaje_finalizados)): ?>
                    <tr>
                        <td>Porcentaje de reclamos finalizados:</td>
                        <td>
                            <?php echo $porcentaje_finalizados; ?>%
                        </td>
                    </tr>
                <?php endif; ?>

                <?php if (isset($porcentaje_cancelados)): ?>
                    <tr>
                        <td>Porcentaje de reclamos cancelados:</td>
                        <td>
                            <?php echo $porcentaje_cancelados; ?>%
                        </td>
                    </tr>
                <?php endif; ?>
            </table>
        </div>
    </div>
    <footer class="footer">
        <div class="footer-item">
            <p>Total global de reclamos:
                <?php echo $row_reclamos_globales['total']; ?>
            </p>
        </div>
        <div class="footer-item">
            <p>Clientes únicos que reclamaron:
                <?php echo $row_total_clientes['total']; ?>
            </p>
        </div>
        <div class="footer-item">
            <p>Trabajadores actuales:
                <?php echo $row_total_trabajadores['total']; ?>
            </p>
        </div>
    </footer>
</body>