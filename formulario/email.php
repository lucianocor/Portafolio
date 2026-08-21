
<?php

// procesar.php

// 1. Capturar los datos enviados por el formulario
$nombre  = $_POST['nombre'] ?? '';
$email   = $_POST['email'] ?? '';
$mensaje = $_POST['mensaje'] ?? '';

// 2. Imprimir en pantalla (usamos <br> para salto de línea en HTML)
echo "Nombre: " . htmlspecialchars($nombre) . "<br>";
echo "Email: " . htmlspecialchars($email) . "<br>";
echo "Mensaje: " . htmlspecialchars($mensaje) . "<br>";
?>