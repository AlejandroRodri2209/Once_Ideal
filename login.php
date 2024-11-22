<?php
session_start(); // Iniciar la sesión
include 'conexion.php'; // Incluir la conexión a la base de datos

// Verificar si se ha enviado el formulario de login
if (isset($_POST['login'])) {
    // Obtener los datos del formulario y protegerlos contra inyecciones SQL
    $email = mysqli_real_escape_string($conexion, $_POST['email']);
    $password = mysqli_real_escape_string($conexion, $_POST['password']);
    
    // Verificar si el usuario con el correo electrónico existe en la base de datos
    $sql = "SELECT * FROM usuarios WHERE Email = '$email'";  // Asegúrate de que el nombre de la columna sea correcto
    $result = mysqli_query($conexion, $sql);
    
    // Verificar si hubo un error en la consulta
    if (!$result) {
        // Si hay un error en la consulta, mostrar el mensaje de error
        die('Error en la consulta SQL: ' . mysqli_error($conexion));
    }
    
    // Verificar si el usuario con ese correo electrónico existe
    if (mysqli_num_rows($result) > 0) {
        // Si el usuario existe, obtener los datos
        $usuario_data = mysqli_fetch_assoc($result);
        
        // Verificar si la contraseña es correcta usando password_verify
        if (password_verify($password, $usuario_data['Password'])) {
            // Iniciar sesión y almacenar los datos del usuario en la sesión
            $_SESSION['usuario'] = $usuario_data['Usuario'];
            $_SESSION['usuario_rol'] = $usuario_data['Rol'];
            
            // Redirigir al dashboard según el rol del usuario
            if ($_SESSION['usuario_rol'] == 'admin') {
                header("Location: dashboard.php");
                exit();
            } else {
                header("Location: dashboard.html");
                exit();
            }
        } else {
            // Si la contraseña es incorrecta
            echo '<div class="alert alert-danger">Contraseña incorrecta.</div>';
        }
    } else {
        // Si el correo no se encuentra en la base de datos
        echo '<div class="alert alert-danger">Usuario no encontrado.</div>';
    }
}
?>
<!-- HTML para el formulario de login -->
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inicio de Sesión</title>
</head>
<body>
    <div class="login-container">
        <h2>Iniciar sesión</h2>
        <form method="POST" action="">
            <div class="form-group">
                <label for="email">Correo Electrónico:</label>
                <input type="email" name="email" id="email" required>
            </div>
            <div class="form-group">
                <label for="password">Contraseña:</label>
                <input type="password" name="password" id="password" required>
            </div>
            <button type="submit" name="login">Iniciar sesión</button>
        </form>
    </div>
</body>
</html>

