<?php

require_once __DIR__ . '/config/conexion.php';
require_login();

$tablas = [
    'pacientes' => 'paciente',
    'atenciones' => 'atencion_medica',
    'diagnosticos' => 'diagnostico',
    'tratamientos' => 'tratamiento',
];
$totales = array_fill_keys(array_keys($tablas), 0);

foreach ($tablas as $clave => $tabla) {
    $resultado = $conexion->query("SELECT COUNT(*) AS total FROM `$tabla`");
    if ($resultado) {
        $totales[$clave] = (int) $resultado->fetch_assoc()['total'];
    }
}

$ultimasAtenciones = fetch_atenciones($conexion);
$actividad = [];
$resultadoActividad = $conexion->query("
    SELECT DATE(fecha_atencion) AS dia, COUNT(*) AS total
    FROM atencion_medica
    WHERE fecha_atencion >= DATE_SUB(CURDATE(), INTERVAL 6 DAY)
    GROUP BY DATE(fecha_atencion)
    ORDER BY dia ASC
");
if ($resultadoActividad) {
    while ($fila = $resultadoActividad->fetch_assoc()) {
        $actividad[$fila['dia']] = (int) $fila['total'];
    }
}

$ultimosSieteDias = [];
$maxActividad = 1;
for ($i = 6; $i >= 0; $i--) {
    $dia = date('Y-m-d', strtotime("-$i days"));
    $total = $actividad[$dia] ?? 0;
    $ultimosSieteDias[] = ['fecha' => $dia, 'total' => $total];
    $maxActividad = max($maxActividad, $total);
}

app_header('Panel principal');
?>
<section class="dashboard-hero">
    <div>
        <span class="eyebrow">PANEL DE CONTROL</span>
        <h1>Resumen general</h1>
        <p>Bienvenido, <?php echo h($_SESSION['nombres'] ?? $_SESSION['usuario']); ?>. Aquí tienes una vista rápida de la actividad del sistema.</p>
    </div>
    <div class="hero-date">
        <span>HOY</span>
        <strong><?php echo date('d/m/Y'); ?></strong>
    </div>
</section>

<section class="stats-grid" aria-label="Indicadores generales">
    <article class="stat-card stat-blue">
        <div class="stat-top"><span>Pacientes</span><span class="stat-icon">♙</span></div>
        <strong><?php echo number_format($totales['pacientes']); ?></strong>
        <small>Personas registradas</small>
        <a href="<?php echo APP_URL; ?>/pacientes/listar.php">Ver pacientes →</a>
    </article>
    <article class="stat-card stat-cyan">
        <div class="stat-top"><span>Atenciones</span><span class="stat-icon">＋</span></div>
        <strong><?php echo number_format($totales['atenciones']); ?></strong>
        <small>Atenciones médicas registradas</small>
        <a href="<?php echo APP_URL; ?>/atenciones/nueva.php">Nueva atención →</a>
    </article>
    <article class="stat-card stat-violet">
        <div class="stat-top"><span>Diagnósticos</span><span class="stat-icon">⌕</span></div>
        <strong><?php echo number_format($totales['diagnosticos']); ?></strong>
        <small>Registros de diagnóstico</small>
        <a href="<?php echo APP_URL; ?>/diagnosticos/registrar.php">Registrar diagnóstico →</a>
    </article>
    <article class="stat-card stat-green">
        <div class="stat-top"><span>Tratamientos</span><span class="stat-icon">✚</span></div>
        <strong><?php echo number_format($totales['tratamientos']); ?></strong>
        <small>Planes de tratamiento</small>
        <a href="<?php echo APP_URL; ?>/tratamientos/registrar.php">Crear tratamiento →</a>
    </article>
</section>

<section class="dashboard-columns">
    <article class="content-card activity-card">
        <div class="section-heading">
            <div><span class="eyebrow">MOVIMIENTO</span><h2>Actividad de atenciones</h2></div>
            <span class="period-tag">Últimos 7 días</span>
        </div>
        <div class="chart" role="img" aria-label="Cantidad de atenciones por día durante los últimos siete días">
            <?php foreach ($ultimosSieteDias as $dia) {
                $alto = $dia['total'] > 0 ? max(8, (int) round(($dia['total'] / $maxActividad) * 100)) : 3;
            ?>
                <div class="chart-column">
                    <span class="chart-value"><?php echo $dia['total']; ?></span>
                    <div class="chart-track"><span style="height: <?php echo $alto; ?>%"></span></div>
                    <small><?php echo date('D', strtotime($dia['fecha'])); ?></small>
                </div>
            <?php } ?>
        </div>
        <p class="chart-note">El gráfico se actualiza automáticamente con las fechas registradas en la base de datos.</p>
    </article>

    <article class="content-card shortcuts-card">
        <div class="section-heading"><div><span class="eyebrow">ACCESOS RÁPIDOS</span><h2>¿Qué necesitas hacer?</h2></div></div>
        <a class="shortcut" href="<?php echo APP_URL; ?>/pacientes/registrar.php"><span class="shortcut-icon">＋</span><span><strong>Registrar paciente</strong><small>Crear ficha y abrir historia clínica</small></span><span class="shortcut-arrow">→</span></a>
        <a class="shortcut" href="<?php echo APP_URL; ?>/atenciones/nueva.php"><span class="shortcut-icon">▤</span><span><strong>Iniciar atención</strong><small>Registrar anamnesis y examen físico</small></span><span class="shortcut-arrow">→</span></a>
        <a class="shortcut" href="<?php echo APP_URL; ?>/triaje/registrar.php"><span class="shortcut-icon">♡</span><span><strong>Registrar triaje</strong><small>Guardar signos y medidas vitales</small></span><span class="shortcut-arrow">→</span></a>
    </article>
</section>

<section class="content-card recent-card">
    <div class="section-heading">
        <div><span class="eyebrow">SEGUIMIENTO</span><h2>Atenciones recientes</h2><p class="section-description">Últimos registros disponibles en el sistema.</p></div>
        <a class="text-link" href="<?php echo APP_URL; ?>/pacientes/listar.php">Consultar pacientes →</a>
    </div>
    <div class="table-wrap">
        <table>
            <thead><tr><th>Código</th><th>Paciente</th><th>DNI</th><th>Fecha</th><th>Estado</th><th></th></tr></thead>
            <tbody>
            <?php if ($ultimasAtenciones && $ultimasAtenciones->num_rows > 0) { ?>
                <?php while ($fila = $ultimasAtenciones->fetch_assoc()) { ?>
                    <tr>
                        <td><span class="record-id">#<?php echo h($fila['id_atencion']); ?></span></td>
                        <td><strong><?php echo h($fila['nombres'] . ' ' . $fila['apellidos']); ?></strong></td>
                        <td><?php echo h($fila['dni']); ?></td>
                        <td><?php echo h(date('d/m/Y', strtotime($fila['fecha_atencion']))); ?></td>
                        <td><span class="status-pill"><?php echo h($fila['estado'] ?: 'Registrada'); ?></span></td>
                        <td><a class="table-link" href="<?php echo APP_URL; ?>/historia_clinica/imprimir.php?id=<?php echo (int) $fila['id_atencion']; ?>">Ver ficha →</a></td>
                    </tr>
                <?php } ?>
            <?php } else { ?>
                <tr><td colspan="6" class="empty-state">Todavía no hay atenciones registradas.</td></tr>
            <?php } ?>
            </tbody>
        </table>
    </div>
</section>
<div class="dashboard-footer"><span>SUSALUD · Sistema de gestión de atención médica</span><span>Información de la base de datos en tiempo real</span></div>
<?php app_footer(); ?>
