<?php
$qs = $_SERVER['QUERY_STRING'] ?? '';
header('Location: ../../../public/actions/pagamento.php' . ($qs ? '?' . $qs : ''));
exit();
