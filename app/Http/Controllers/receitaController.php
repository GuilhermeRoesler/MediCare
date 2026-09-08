<?php
$qs = $_SERVER['QUERY_STRING'] ?? '';
header('Location: ../../../public/actions/receita.php' . ($qs ? '?' . $qs : ''));
exit();
