<?php
// Sessão
session_start();

// Conexão
include_once 'db_connect.php';

// Clear
function clear($input) {
	global $connect;

	// Anti-SQL Injection
	$var = mysqli_escape_string($connect, $input);

	// Anti-XSS
	$var = htmlspecialchars($var);
	return $var;
}

if (isset($_POST['btn-cadastrar'])) {
	$pergunta = clear($_POST['pergunta']);
	$resposta = clear($_POST['resposta']);
	$tipo = $_POST['tipo'];

	// Validação de Campos vazios
	if (empty($pergunta) || empty($resposta)) {
		$_SESSION['mensagem'] = "Todos os campos devem ser preenchidos!";
		$_SESSION['tipo_mensagem'] = "warning";
		header('Location: ../home.php');
		return;
	}

	if($tipo == 'multiplasescolhas') {
		$sql = "INSERT INTO multiplasescolhas (pergunta, resposta) VALUES ('$pergunta', '$resposta')";

		// Validação da resposta
		if (!preg_match("/^[a-eA-E]{1}$/", $resposta)) {
			$_SESSION['mensagem'] = "A resposta deve ser uma letra de A até E.";
			$_SESSION['tipo_mensagem'] = "warning";
			header('Location: ../home.php');
			return;
		}

	} else {
		$sql = "INSERT INTO discursivas (pergunta, resposta) VALUES ('$pergunta', '$resposta')";
	}


	if (mysqli_query($connect, $sql)) {
		$_SESSION['mensagem'] = "Pergunta cadastrada com sucesso!";
		$_SESSION['tipo_mensagem'] = "success";
		header('Location: ../home.php');
	} else {
		$_SESSION['mensagem'] = "Erro ao cadastrar pergunta.";
		$_SESSION['tipo_mensagem'] = "warning";
		header('Location: ../home.php');
	}
}

