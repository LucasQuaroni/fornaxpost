<?php
session_start();

$conexion = mysqli_connect("localhost", "root", "", "fornaxpost");
$usuario = mysqli_real_escape_string($conexion, $_POST['user']);
$contra = mysqli_real_escape_string($conexion, $_POST['pass']);

if ($usuario != "" && $contra != "") {
    $consulta = "SELECT * FROM usuarios WHERE usuario='$usuario' AND contra='$contra'";
    $resultado = mysqli_query($conexion, $consulta);
    $filas = mysqli_num_rows($resultado);

    if ($filas > 0) {
        $consulta_rol = "SELECT rol FROM usuarios WHERE usuario='$usuario' AND contra='$contra'";
        $resultado_rol = mysqli_query($conexion, $consulta_rol);
        $rol = mysqli_fetch_assoc($resultado_rol)['rol'];

        if ($rol == 'A') {
            $_SESSION['usuario'] = $usuario;
            $_SESSION['es_admin'] = true;
            header("Location: ../admin/admin.php");
            exit;
        } elseif ($rol == 'C') {
            $_SESSION['usuario'] = $usuario;
            header("Location: ../chofer/chofer.php");
            exit;
        } elseif ($rol == 'T') {
            $_SESSION['usuario'] = $usuario;
            header("Location: ../tecnico/tecnico.php");
            exit;
        } else {
            $_SESSION['error_message'] = "Error en la autenticación. Rol desconocido";
            header("Location: ../login/login.php");
            exit;
        }
    } else {
        $_SESSION['error_message'] = "Error en la autenticación. Usuario o contraseña incorrectos";
        header("Location: ../login/login.php");
        exit;
    }
} else {
    $_SESSION['error_message'] = "Los campos de Usuario y Contraseña no pueden estar vacíos";
    header("Location: ../login/login.php");
    exit;
}
?>
