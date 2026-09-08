<?php
$qs = $_SERVER['QUERY_STRING'] ?? '';
header('Location: ../../../public/actions/auth.php' . ($qs ? '?' . $qs : ''));
exit();
