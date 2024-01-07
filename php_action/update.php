<?php
// Sessão
session_start();

// Conexão
require_once 'db_connect.php';

// Clear
function clear($input) {
	global $connect;

	$var = mysqli_escape_string($connect, $input);

	$var = htmlspecialchars($var);

	return $var;
}

if (isset($_POST['btn-editar'])) {
	$id = clear($_POST['id']);
	$tipo = clear($_POST['tipo']);
	$pergunta = clear($_POST['pergunta']);
	$resposta = clear($_POST['resposta']);

	// Validação de Campos vazios
	if (empty($pergunta) || empty($resposta)) {
		$_SESSION['mensagem'] = "Todos os campos devem ser preenchidos!";
		$_SESSION['tipo_mensagem'] = "warning";
		header('Location: ../home.php');
		return;
	}

	$sql = "UPDATE $tipo SET pergunta = '$pergunta', resposta = '$resposta' WHERE id = '$id'";

	// Validação de resposta
	if ($tipo == 'multiplasescolhas') {
		if (!preg_match("/^[a-eA-E]{1}$/", $resposta)) {
			$_SESSION['mensagem'] = "A resposta deve ser uma letra de A até E.";
			$_SESSION['tipo_mensagem'] = "warning";
			header('Location: ../home.php');
			return;
		}
	}

	if (mysqli_query($connect, $sql)) {
		$_SESSION['mensagem'] = "Atualizado com sucesso!";
		$_SESSION['tipo_mensagem'] = "success";
		header('Location: ../home.php');
	} else {
		$_SESSION['mensagem'] = "Erro ao atualizar";
		$_SESSION['tipo_mensagem'] = "warning";
		header('Location: ../home.php');
	}

}
