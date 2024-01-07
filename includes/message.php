<?php
// Sessão
if(session_status() == PHP_SESSION_NONE) {
	session_start();
}

if(isset($_SESSION['mensagem'])){ ?>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>

<div class="container position-fixed bottom-0 end-0">
  <div class="row justify-content-end">
    <div class="col-md-8"></div>
    <div class="col-md-4">
    <div class="alert alert-<?php echo $_SESSION['tipo_mensagem']; ?> alert-dismissible fade show" role="alert">
          <p><?php echo $_SESSION['mensagem']; ?></p>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
  </div>
  </div>
  </div>
  </div>

 <?php
 	}
 $_SESSION['mensagem'] = null;
?>