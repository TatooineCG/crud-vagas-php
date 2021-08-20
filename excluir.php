<?php 

require __DIR__.'/vendor/autoload.php';

use \App\Entity\Vaga;

// VALIDAÇÃO DO ID
if(!isset($_GET['id']) or !is_numeric($_GET['id'])) {
    header('location: index.php?status=error');
    exit;
}

// CONSULTAR A VAGA
$objetoVaga = Vaga::getVaga($_GET['id']);

// VALIDAÇÃO DA VAGA
if(!$objetoVaga instanceof Vaga) {
    header('location: index.php?status=error');
    exit;
}

// VALIDAÇÃO DO POST
if(isset($_POST['excluir'])) {
    $objetoVaga->excluir();
    header('location: index.php?status=success');
    exit;
}

include __DIR__.'/includes/header.php';
include __DIR__.'/includes/confirmar-exclusao.php';
include __DIR__.'/includes/footer.php';