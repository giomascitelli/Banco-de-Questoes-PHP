<?php
// Sessão
session_start();

// Conexão
include_once 'db_connect.php';

if (isset($_POST['btn-deletar'])) {
	$id = mysqli_escape_string($connect, $_POST['id']);
	$tipo = $_POST['tipo'];

	$sql = "DELETE FROM $tipo WHERE id = '$id'";

	if (mysqli_query($connect, $sql)) {
		$_SESSION['mensagem'] = "Questão deletada com sucesso!";
		$_SESSION['tipo_mensagem'] = "success";
		header('Location: ../home.php');
	} else {
		$_SESSION['mensagem'] = "Erro ao deletar questão.";
		$_SESSION['tipo_mensagem'] = "warning";
		header('Location: ../home.php');
	}
}