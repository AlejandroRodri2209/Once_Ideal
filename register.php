<?php
// Incluir archivo de conexión a la base de datos
include('conexion.php');  // Asegúrate de que el archivo 'conexion.php' esté en el mismo directorio

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Obtener los datos del formulario
    $usuario = $_POST['usuario'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $telefono = $_POST['telefono'];
    $direccion = $_POST['direccion'];
    
    // Correo del administrador (puedes cambiar esto por el correo real del administrador)
    $admin_email = "admin@tusitio.com"; // Correo del administrador

    // Verificar si el correo es el del administrador
    if ($email == $admin_email) {
        $rol = 'admin'; // Asignar rol de 'admin' si el correo coincide
    } else {
        $rol = 'usuario'; // Rol predeterminado como 'usuario'
    }

    $estado = 1; // Estado activo por defecto

    // Cifrar la contraseña antes de guardarla
    $password_hash = password_hash($password, PASSWORD_BCRYPT);

    // Insertar en la base de datos
    $query = "INSERT INTO usuarios (Usuario, Email, Password, Telefono, Direccion, Rol, Estado) 
              VALUES ('$usuario', '$email', '$password_hash', '$telefono', '$direccion', '$rol', '$estado')";

    if (mysqli_query($conexion, $query)) {
        // Registro exitoso, redirigir a login.html
        header("Location: login.html");
        exit(); // Es importante llamar a exit() después de header para evitar que el resto del código se ejecute.
    } else {
        echo "Error: " . mysqli_error($conexion);
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulario de Registro</title>
</head>
<body>

<h2>Formulario de Registro</h2>

<form action="register.php" method="POST">
    <label for="usuario">Nombre de usuario:</label>
    <input type="text" id="usuario" name="usuario" required><br><br>

    <label for="email">Correo electrónico:</label>
    <input type="email" id="email" name="email" required><br><br>

    <label for="password">Contraseña:</label>
    <input type="password" id="password" name="password" required><br><br>

    <label for="telefono">Teléfono:</label>
    <input type="text" id="telefono" name="telefono"><br><br>

    <label for="direccion">Dirección:</label>
    <input type="text" id="direccion" name="direccion"><br><br>

    <button type="submit">Registrarse</button>
</form>

</body>
</html>
