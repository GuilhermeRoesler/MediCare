<?php
// Entry point legado — redireciona para public/actions
$qs = $_SERVER['QUERY_STRING'] ?? '';
header('Location: ../../../public/actions/paciente.php' . ($qs ? '?' . $qs : ''));
exit();
