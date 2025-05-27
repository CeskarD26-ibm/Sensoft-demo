<?php
// Procesar POST para agregar usuario (esto va antes de cualquier salida HTML)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $apiUrl = 'http://backend:3000/users';

    $options = [
        'http' => [
            'header'  => "Content-type: application/json\r\n",
            'method'  => 'POST',
            'content' => json_encode(['name' => $name]),
        ],
    ];

    $context  = stream_context_create($options);
    file_get_contents($apiUrl, false, $context);

    // Redirigir para evitar reenvío de formulario
    header("Location: /");
    exit;
}

// Obtener datos desde la API
$response = file_get_contents('http://backend:3000/users');
$users = json_decode($response, true);
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Lista de Usuarios</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<nav class="navbar navbar-dark bg-dark mb-4">
  <div class="container">
    <span class="navbar-brand mb-0 h1">Gestión de Usuarios</span>
  </div>
</nav>

<div class="container">
  <div class="row mb-4">
    <div class="col-md-6">
      <h4>Usuarios registrados</h4>
      <table class="table table-striped">
        <thead>
          <tr><th>ID</th><th>Nombre</th></tr>
        </thead>
        <tbody>
          <?php foreach ($users as $user): ?>
            <tr>
              <td><?= $user['id'] ?></td>
              <td><?= htmlspecialchars($user['name']) ?></td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>

    <div class="col-md-6">
      <h4>Registrar nuevo usuario</h4>
      <form method="POST">
        <div class="mb-3">
          <label for="name" class="form-label">Nombre</label>
          <input type="text" class="form-control" name="name" required>
        </div>
        <button type="submit" class="btn btn-primary">Agregar</button>
      </form>
    </div>
  </div>
</div>

</body>
</html>
