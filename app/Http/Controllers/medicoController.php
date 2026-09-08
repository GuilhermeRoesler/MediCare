<?php
$qs = $_SERVER['QUERY_STRING'] ?? '';
header('Location: ../../../public/actions/medico.php' . ($qs ? '?' . $qs : ''));
exit();
