<?php
session_start();

// Incluir el archivo de conexión
include('../conexion.php');

$usuario = mysqli_real_escape_string($conn, $_POST['user']);
$contra = mysqli_real_escape_string($conn, $_POST['pass']);

if ($usuario != "" && $contra != "") {
    $consulta = "SELECT * FROM usuarios WHERE usuario='$usuario' AND contra='$contra'";
    $resultado = $conn->query($consulta);
    $filas = $resultado->num_rows;

    if ($filas > 0) {
        $consulta_rol = "SELECT rol, idusuario FROM usuarios WHERE usuario='$usuario' AND contra='$contra'";
        $resultado_rol = $conn->query($consulta_rol);
        $datos_usuario = $resultado_rol->fetch_assoc();

        $rol = $datos_usuario['rol'];
        $idusuario = $datos_usuario['idusuario'];

        if ($rol == 'A') {
            $_SESSION['idusuario'] = $idusuario; // Almacena el ID del usuario en la sesión
            $_SESSION['usuario'] = $usuario;
            $_SESSION['es_admin'] = true;
            header("Location: ../admin/admin.php");
            exit;
        } elseif ($rol == 'C') {
            $_SESSION['idusuario'] = $idusuario; // Almacena el ID del chofer en la sesión
            $_SESSION['usuario'] = $usuario;
            header("Location: ../chofer/chofer.php");
            exit;
        } elseif ($rol == 'T') {
            $_SESSION['usuario'] = $usuario;
            $_SESSION['idusuario'] = $idusuario; // Almacena el ID del usuario en la sesión
            header("Location: ../tecnico/tecnico.php");
            exit;
        }
    } else {
        $_SESSION['error_message'] = "Credenciales incorrectas. Intente nuevamente";
        header("Location: ../login/login.php");
        exit;
    }
} else {
    $_SESSION['error_message'] = "Los campos de Usuario y Contraseña no pueden estar vacíos";
    header("Location: ../login/login.php");
    exit;
}
?>