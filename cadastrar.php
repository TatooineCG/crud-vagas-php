<?php 

require __DIR__.'/vendor/autoload.php';

define('TITLE', 'Cadastrar vaga');

use \App\Entity\Vaga;
$objetoVaga = new Vaga;

// VALIDAÇÃO DO POST
if(isset($_POST['titulo'], $_POST['descricao'], $_POST['ativo'])) {
    $objetoVaga->titulo = $_POST['titulo'];
    $objetoVaga->descricao = $_POST['descricao'];
    $objetoVaga->ativo = $_POST['ativo'];

    $objetoVaga->cadastrarVaga();

    header('location: index.php?status=success');
    exit;
}

include __DIR__.'/includes/header.php';
include __DIR__.'/includes/formulario.php';
include __DIR__.'/includes/footer.php';