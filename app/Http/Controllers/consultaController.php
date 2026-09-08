<?php
$qs = $_SERVER['QUERY_STRING'] ?? '';
header('Location: ../../../public/actions/consulta.php' . ($qs ? '?' . $qs : ''));
exit();
