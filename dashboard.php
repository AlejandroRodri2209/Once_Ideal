<?php
session_start();
include 'conexion.php';

// Verificar si el usuario está autenticado y tiene rol de administrador
if (!isset($_SESSION['usuario']) || $_SESSION['usuario_rol'] !== 'admin') {
    echo "No estás autenticado como admin.";  // Depurar
    header("Location: login.php"); // Redirigir al login si no es administrador
    exit();
}
// Crear nuevo usuario
if (isset($_POST['crear'])) {
    $usuario = mysqli_real_escape_string($conexion, $_POST['usuario']);
    $password = mysqli_real_escape_string($conexion, $_POST['password']);
    $rol = mysqli_real_escape_string($conexion, $_POST['rol']);
    
    // Hashear la contraseña
    $password_hash = password_hash($password, PASSWORD_DEFAULT);
    
    // Insertar el nuevo usuario en la base de datos
    $sql = "INSERT INTO usuarios (Usuario, Password, Rol) VALUES ('$usuario', '$password_hash', '$rol')";
    if (mysqli_query($conexion, $sql)) {
        echo '<div class="alert alert-success">Usuario creado con éxito.</div>';
    } else {
        echo '<div class="alert alert-danger">Error al crear el usuario: ' . mysqli_error($conexion) . '</div>';
    }
}

// Actualizar usuario
if (isset($_POST['actualizar'])) {
    $id = $_POST['id'];
    $usuario = mysqli_real_escape_string($conexion, $_POST['usuario']);
    $password = mysqli_real_escape_string($conexion, $_POST['password']);
    $rol = mysqli_real_escape_string($conexion, $_POST['rol']);

    // Hashear la nueva contraseña
    $password_hash = password_hash($password, PASSWORD_DEFAULT);

    // Actualizar el usuario en la base de datos
    $sql = "UPDATE usuarios SET Usuario='$usuario', Password='$password_hash', Rol='$rol' WHERE ID_Usuario='$id'";
    if (mysqli_query($conexion, $sql)) {
        echo '<div class="alert alert-success">Usuario actualizado con éxito.</div>';
    } else {
        echo '<div class="alert alert-danger">Error al actualizar el usuario: ' . mysqli_error($conexion) . '</div>';
    }
}

// Eliminar usuario
if (isset($_GET['eliminar'])) {
    $id = $_GET['eliminar'];

    // Verificar si el id existe antes de intentar eliminarlo
    if (isset($id) && is_numeric($id)) {
        $sql = "DELETE FROM usuarios WHERE ID_Usuario='$id'";
        if (mysqli_query($conexion, $sql)) {
            echo '<div class="alert alert-success">Usuario eliminado con éxito.</div>';
        } else {
            echo '<div class="alert alert-danger">Error al eliminar el usuario: ' . mysqli_error($conexion) . '</div>';
        }
    } else {
        echo '<div class="alert alert-danger">ID de usuario inválido.</div>';
    }
}

// Obtener todos los usuarios registrados
$sql = "SELECT * FROM usuarios";
$resultado = mysqli_query($conexion, $sql);
$usuarios = mysqli_fetch_all($resultado, MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard de Administración</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h1>Bienvenido al Dashboard de Administración</h1>
        <p>Gestiona usuarios, contenido y otras funcionalidades desde aquí.</p>
        <a href="login.html" class="btn btn-secondary">Cerrar sesión</a>

        <!-- Formulario para crear usuario -->
        <div class="mt-5">
            <h2>Crear Nuevo Usuario</h2>
            <form method="POST" action="dashboard.php">
                <div class="form-group">
                    <label for="usuario">Usuario:</label>
                    <input type="text" name="usuario" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="password">Contraseña:</label>
                    <input type="password" name="password" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="rol">Rol:</label>
                    <select name="rol" class="form-control" required>
                        <option value="admin">Administrador</option>
                        <option value="user">Usuario</option>
                    </select>
                </div>
                <button type="submit" name="crear" class="btn btn-primary">Crear Usuario</button>
            </form>
        </div>

        <!-- Mostrar lista de usuarios -->
        <div class="mt-5">
            <h2>Usuarios Registrados</h2>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Usuario</th>
                        <th>Rol</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($usuarios as $usuario): ?>
                        <tr>
                            <td><?php echo $usuario['ID_Usuario']; ?></td>
                            <td><?php echo $usuario['Usuario']; ?></td>
                            <td><?php echo $usuario['Rol']; ?></td>
                            <td>
                                <!-- Enlace para editar usuario -->
                                <button class="btn btn-warning btn-sm" data-toggle="modal" data-target="#editarModal<?php echo $usuario['ID_Usuario']; ?>">Editar</button>
                                <!-- Enlace para eliminar usuario -->
                                <a href="dashboard.php?eliminar=<?php echo $usuario['ID_Usuario']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('¿Estás seguro de eliminar este usuario?')">Eliminar</a>
                            </td>
                        </tr>

                        <!-- Modal para editar usuario -->
                        <div class="modal" id="editarModal<?php echo $usuario['ID_Usuario']; ?>" tabindex="-1" role="dialog">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Editar Usuario</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <form method="POST" action="dashboard.php">
                                            <input type="hidden" name="id" value="<?php echo $usuario['ID_Usuario']; ?>">
                                            <div class="form-group">
                                                <label for="usuario">Usuario:</label>
                                                <input type="text" name="usuario" class="form-control" value="<?php echo $usuario['Usuario']; ?>" required>
                                            </div>
                                            <div class="form-group">
                                                <label for="password">Contraseña:</label>
                                                <input type="password" name="password" class="form-control" required>
                                            </div>
                                            <div class="form-group">
                                                <label for="rol">Rol:</label>
                                                <select name="rol" class="form-control" required>
                                                    <option value="admin" <?php echo $usuario['Rol'] == 'admin' ? 'selected' : ''; ?>>Administrador</option>
                                                    <option value="user" <?php echo $usuario['Rol'] == 'user' ? 'selected' : ''; ?>>Usuario</option>
                                                </select>
                                            </div>
                                            <button type="submit" name="actualizar" class="btn btn-primary">Actualizar Usuario</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
