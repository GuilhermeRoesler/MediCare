<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once '../Receita.php';

$idReceita = $_POST['id'];

$receita = new Receita(null, null, null, null, null, null, null);

try {
    $receita->excluir($idReceita);
} catch (Exception $e) {
    // Log error if needed
}

header('Location: ../html/receitas.php');
exit();
?>