<?php

require_once __DIR__ . '/config/conexion.php';
require_login();

app_header('Prueba de conexion');
?>
<section class="panel">
    <h1>Conexion exitosa con SUSALUD</h1>
    <p class="muted">La aplicacion puede conectarse a la base de datos.</p>
</section>
<?php app_footer(); ?>
