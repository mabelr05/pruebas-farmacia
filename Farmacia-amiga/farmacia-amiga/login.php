<?php
require_once "config/conexion.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Recuperar datos del formulario
    $email = $_POST["email"];
    $password = $_POST["password"];

    // Escapar los datos para prevenir inyecciones SQL
    $email = mysqli_real_escape_string($conexion, $email);

    // Consulta para verificar las credenciales
    $query = "SELECT * FROM usuarios WHERE email = '$email'";
    $result = mysqli_query($conexion, $query);
    
    if ($result) {
        $user = mysqli_fetch_assoc($result);
        if ($user && password_verify($password, $user["password"])) {
            // Iniciar sesión o realizar otras acciones
            session_start();
            $_SESSION["user"] = $user;
            // Redirigir a la página de inicio de sesión exitoso
            header("Location: index.php");
            session_start();
            $_SESSION ["user"]=$user;
            exit;
        } else {
            echo "Credenciales incorrectas";
            echo $user["password"];
        }
    } else {
        echo "Error en la consulta: " . mysqli_error($conexion);
    }
}
?>