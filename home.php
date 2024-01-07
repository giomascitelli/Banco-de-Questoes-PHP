<?php
// Sessão
session_start();
// Conexão
include_once 'php_action/db_connect.php';

// Mensagem
include_once 'includes/message.php';

// Verificação
if (!isset($_SESSION['logado'])) {
	header('Location: index.php');
}

// Dados
	$id = $_SESSION['id_usuario'];
	$sql = "SELECT * FROM usuarios WHERE id = '$id'";
	$resultado = mysqli_query($connect, $sql);
	$dados = mysqli_fetch_array($resultado);
// Header
include_once 'includes/header.php';
?>

<div class="container">
  <div class="row">
    <div class="col-md-12 d-flex justify-content-center align-items-center mb-3">
      <h3 class="display-3">Banco de questões</h3>
    </div>

    <div class="d-flex justify-content-center">
      <p class="lead fs-3 me-3">Bem-vindo, <?php echo $dados['username'];?></p>
      <!-- Botão de logout -->
      <form action="php_action/logout.php" method="POST">
        <button type="submit" name="btn-logout" class="btn btn-danger"><i class="bi bi-box-arrow-left"></i></button>
      </form>
    </div>
  </div>
</div>

<div class="container">
  <div class="row">
    <div class="col-md-6">
      <table class="table table-hover" style="word-wrap: break-word;">
        <thead>
          <tr>
            <th>Questão multipla-escolha:</th>
            <th>Gabarito:</th>
            <th></th>
            <th></th>
          </tr>
        </thead>

        <!-- READ [multiplasescolhas] -->

        <tbody>
          <?php
			$sql = "SELECT * FROM multiplasescolhas";
			$resultado = mysqli_query($connect, $sql);

			if (mysqli_num_rows($resultado) > 0) {
				while ($dados = mysqli_fetch_array($resultado)) {

			?>

          <tr>
            <td style="word-wrap: break-word; min-width: 160px; max-width: 160px;"><?php echo $dados['pergunta'];?></td>
            <td style="word-wrap: break-word; min-width: 160px; max-width: 160px;"><?php echo $dados['resposta'];?></td>

            <!-- UPDATE [multiplasescolhas] -->

            <td><a href="editar.php?id=<?php echo $dados['id']; ?>" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#modaledit<?php echo $dados['id']; ?>"><i class="bi bi-pen"></i></a></td>

            <!-- Modal -->
            <div class="modal fade" id="modaledit<?php echo $dados['id']; ?>" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
              <div class="modal-dialog">
                <div class="modal-content">
                  <div class="modal-header">
                    <h1 class="modal-title fs-5" id="staticBackdropLabel">Editar questão</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
                  </div>
                  <div class="modal-body">
                    <!-- Início do formulário -->
                    <div class="modal-body">
                      <form action="php_action/update.php" method="POST">

                        <div class="form-group">

                          <div class="mb-3">
                            <label for="pergunta" class="form-label">Questão</label>
                            <textarea class="form-control" id="pergunta" name="pergunta" rows="3"><?php echo $dados['pergunta'];?></textarea>
                          </div>

                          <div class="mb-3">

                            <label for="resposta" class="form-label">Resposta</label>
                            <select class="form-select" aria-label="Select de respostas" name="resposta" id="resposta">
                              <option value="A" <?php if($dados['resposta'] == 'A') echo 'selected'; ?>>A</option>
                              <option value="B" <?php if($dados['resposta'] == 'B') echo 'selected'; ?>>B</option>
                              <option value="C" <?php if($dados['resposta'] == 'C') echo 'selected'; ?>>C</option>
                              <option value="D" <?php if($dados['resposta'] == 'D') echo 'selected'; ?>>D</option>
                              <option value="E" <?php if($dados['resposta'] == 'E') echo 'selected'; ?>>E</option>
                            </select>

                          </div>

                          <input type="hidden" name="id" value="<?php echo $dados['id']; ?>">
                          <input type="hidden" name="tipo" id="tipo" value="multiplasescolhas">

                        </div>

                        <div class="modal-footer">

                          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                          <button type="submit" name="btn-editar" class="btn btn-primary">Editar</button>

                        </div>
                      </form>
                    </div>
                    <!-- Fim do formulário -->
                  </div>
                </div>
              </div>
            </div>
    </div>

    <!-- FIM DO UPDATE [multiplasescolhas] -->

    <!-- DELETE [multiplasescolhas] -->

    <td><a href="#modal<?php echo $dados['id']; ?>" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#modal<?php echo $dados['id']; ?>"><i class="bi bi-trash"></i></a></td>

    <!-- Modal -->
    <div class="modal fade" id="modal<?php echo $dados['id']; ?>" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h1 class="modal-title fs-5" id="staticBackdropLabel">Excluir</h1>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
          </div>
          <div class="modal-body">
            Tem certeza que deseja excluir essa questão?
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
            <form action="php_action/delete.php" method="POST">
              <input type="hidden" name="id" value="<?php echo $dados['id']; ?>">
              <input type="hidden" name="tipo" id="tipo" value="multiplasescolhas">
              <button type="submit" name="btn-deletar" class="btn btn-danger">Excluir</button>
            </form>
          </div>
        </div>
      </div>
    </div>

    <!-- FIM DO DELETE [multiplasescolhas] -->

    </tr>
    <?php } } else {
    ?>
    <tr>
      <td>-</td>
      <td>-</td>
      <td>-</td>
      <td>-</td>
    </tr>
    <?php 
    		}
    	?>
    </tbody>
    </table>
  </div>
  <!-- FIM DO READ [multiplasescolhas] -->

  <div class="col-md-6">
    <table class="table table-hover" style="word-wrap: break-word;">
      <thead>
        <tr>
          <th>Questão discursiva:</th>
          <th>Gabarito:</th>
          <th></th>
          <th></th>
        </tr>
      </thead>

      <!-- READ [discursivas] -->

      <tbody>
        <?php
			$sql = "SELECT * FROM discursivas";
			$resultado = mysqli_query($connect, $sql);

			if (mysqli_num_rows($resultado) > 0) {
				while ($dados = mysqli_fetch_array($resultado)) {

			?>

        <tr>
          <td style="word-wrap: break-word; min-width: 160px; max-width: 160px;"><?php echo $dados['pergunta'];?></td>
          <td style="word-wrap: break-word; min-width: 160px; max-width: 160px;"><?php echo $dados['resposta'];?></td>

          <!-- UPDATE [discursivas] -->

          <td><a href="editar.php?id=<?php echo $dados['id']; ?>" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#modaledit<?php echo $dados['id']; ?>"><i class="bi bi-pen"></i></a></td>

          <!-- Modal -->
          <div class="modal fade" id="modaledit<?php echo $dados['id']; ?>" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog">
              <div class="modal-content">
                <div class="modal-header">
                  <h1 class="modal-title fs-5" id="staticBackdropLabel">Editar questão</h1>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
                </div>
                <div class="modal-body">
                  <!-- Início do formulário -->
                  <div class="modal-body">
                    <form action="php_action/update.php" method="POST">

                      <div class="form-group">

                        <div class="mb-3">
                          <label for="pergunta" class="form-label">Questão</label>
                          <textarea class="form-control" id="pergunta" name="pergunta" rows="3"><?php echo $dados['pergunta'];?></textarea>
                        </div>

                        <div class="mb-3">
                          <label for="resposta" class="form-label">Resposta</label>
                          <input type="text" name="resposta" class="form-control" id="resposta" value="<?php echo $dados['resposta'];?>">
                        </div>

                        <input type="hidden" name="id" value="<?php echo $dados['id']; ?>">
                        <input type="hidden" name="tipo" id="tipo" value="discursivas">

                      </div>

                      <div class="modal-footer">

                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                        <button type="submit" name="btn-editar" class="btn btn-primary">Editar</button>

                      </div>
                    </form>
                  </div>
                  <!-- Fim do formulário -->
                </div>
              </div>
            </div>
          </div>
  </div>

  <!-- FIM DO UPDATE [discursivas] -->

  <!-- DELETE [discursivas] -->

  <td><a href="#modal<?php echo $dados['id']; ?>" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#modal<?php echo $dados['id']; ?>"><i class="bi bi-trash"></i></a></td>

  <!-- Modal -->
  <div class="modal fade" id="modal<?php echo $dados['id']; ?>" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="staticBackdropLabel">Excluir</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
        </div>
        <div class="modal-body">
          Tem certeza que deseja excluir essa questão?
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
          <form action="php_action/delete.php" method="POST">
            <input type="hidden" name="id" value="<?php echo $dados['id']; ?>">
            <input type="hidden" name="tipo" id="tipo" value="discursivas">
            <button type="submit" name="btn-deletar" class="btn btn-danger">Excluir</button>
          </form>
        </div>
      </div>
    </div>
  </div>

  <!-- FIM DO DELETE [discursivas] -->

  </tr>
  <?php } } else {
    ?>
  <tr>
    <td>-</td>
    <td>-</td>
    <td>-</td>
    <td>-</td>
  </tr>
  <?php 
    		}
    		mysqli_close($connect);
    	?>
  </tbody>
  </table>
</div>
</div>
</div>

<!-- FIM DO READ [discursivas] -->

<div class="container">
  <div class="row">
    <div class="col-md-2"></div>

    <!-- CREATE [multiplasescolhas] -->

    <button type="button" class="btn btn-primary col-md-2" data-bs-toggle="modal" data-bs-target="#staticBackdrop">
      Adicionar questão multipla-escolha
    </button>

    <!-- Modal -->
    <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h1 class="modal-title fs-5" id="staticBackdropLabel">Adicionar uma questão</h1>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>

          <!-- Início do formulário -->

          <div class="modal-body">
            <form action="php_action/create.php" method="POST">
              <div class="form-group">

                <div class="mb-3">
                  <label for="pergunta" class="form-label">Questão</label>
                  <textarea class="form-control" id="pergunta" name="pergunta" rows="3"></textarea>
                </div>

                <div class="mb-3">

                  <label for="resposta" class="form-label">Resposta</label>
                  <select class="form-select" aria-label="Select de respostas" name="resposta" id="resposta">
                    <option value="A" selected>A</option>
                    <option value="B">B</option>
                    <option value="C">C</option>
                    <option value="D">D</option>
                    <option value="E">E</option>
                  </select>

                </div>

                <input type="hidden" name="tipo" id="tipo" value="multiplasescolhas">

              </div>

              <div class="modal-footer">

                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                <button type="submit" name="btn-cadastrar" class="btn btn-primary">Cadastrar</button>

              </div>
            </form>
          </div>

          <!-- Fim do formulário -->

        </div>
      </div>
    </div>

    <!-- FIM DO CREATE [multiplasescolhas] -->

    <div class="col-md-2"></div>
    <div class="col-md-2"></div>

    <!-- CREATE [discursivas] -->

    <button type="button" class="btn btn-primary col-md-2" data-bs-toggle="modal" data-bs-target="#tipoDiscursivas">
      Adicionar questão discursiva
    </button>

    <!-- Modal -->
    <div class="modal fade" id="tipoDiscursivas" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h1 class="modal-title fs-5" id="staticBackdropLabel">Adicionar uma questão</h1>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>

          <!-- Início do formulário -->

          <div class="modal-body">
            <form action="php_action/create.php" method="POST">
              <div class="form-group">

                <div class="mb-3">
                  <label for="pergunta" class="form-label">Questão</label>
                  <textarea class="form-control" id="pergunta" name="pergunta" rows="3"></textarea>
                </div>

                <div class="mb-3">
                  <label for="resposta" class="form-label">Resposta</label>
                  <input type="text" name="resposta" class="form-control" id="resposta">
                </div>

                <input type="hidden" name="tipo" id="tipo" value="discursivas">

              </div>

              <div class="modal-footer">

                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                <button type="submit" name="btn-cadastrar" class="btn btn-primary">Cadastrar</button>

              </div>
            </form>
          </div>

          <!-- Fim do formulário -->
        </div>
      </div>

      <!-- FIM DO CREATE [discursivas] -->

      <?php
// Footer
include_once 'includes/footer.php';

?>