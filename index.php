<?php
// Conexão
include_once 'php_action/db_connect.php';

// Mensagem
include_once 'includes/message.php';

// Clear
function clear($input) {
	global $connect;

	// Anti-SQL Injection
	$var = mysqli_escape_string($connect, $input);

	// Anti-XSS
	$var = htmlspecialchars($var);
	return $var;
}

if (isset($_POST['btn-entrar'])) {
	
	$username = clear($_POST['username']);
	$senha = clear($_POST['senha']);

	if (empty($username) || empty($senha)) {
		$_SESSION['mensagem'] = "Todos os campos precisam ser preenchidos.";
		$_SESSION['tipo_mensagem'] = "warning";
		header('Location: ../index.php');
		return;
	} else {
		$sql = "SELECT username FROM usuarios WHERE username = '$username'";
		$resultado = mysqli_query($connect, $sql);

		if (mysqli_num_rows($resultado) > 0) {
			$senha = md5($senha);
			$sql = "SELECT * FROM usuarios WHERE senha = '$senha' AND username = '$username'";
			$resultado = mysqli_query($connect, $sql);

			if (mysqli_num_rows($resultado) == 1) {
						$dados = mysqli_fetch_array($resultado);
						mysqli_close($connect);
						$_SESSION['logado'] = true;
						$_SESSION['id_usuario'] = $dados['id'];
						header('Location: home.php');
					} else {
						$_SESSION['mensagem'] = "Uma ou mais informações estão incorretas.";
						$_SESSION['tipo_mensagem'] = "danger";
					}
		} else {
			$_SESSION['mensagem'] = "Uma ou mais informações estão incorretas.";
			$_SESSION['tipo_mensagem'] = "danger";
		}
	}
}

// Header
include_once 'includes/header.php';

?>

<div class="container">
	<div class="row">
			<div class="col-md-12 d-flex justify-content-center align-items-center mb-3">
				<h3 class="display-3">Banco de questões
				</h3>

			</div>
			
			<p class="lead d-flex justify-content-center fs-3">Sistema para professores e alunos</p>
			
		
			<div class="col-md-3"></div>
			<div class="col-md-6 d-flex justify-content-center align-items-center rounded" style="background-color: #F6F6F6;">
				<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
				  <div class="mb-3 mt-3">
				    <label for="username" class="form-label">Username</label>
				    <input type="text" class="form-control" id="username" name="username">
				  </div>

				  <div class="mb-3">
				    <label for="senha" class="form-label">Senha</label>
				    <input type="password" class="form-control" id="senha" name="senha">
				  </div>

				  <button type="submit" class="btn btn-primary mb-3" name="btn-entrar">Entrar</button>

				</form>
			</div>
	</div>
</div>

<?php
include_once 'includes/footer.php';
?>