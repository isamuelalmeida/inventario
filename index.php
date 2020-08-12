<?php
  ob_start();
  require_once('includes/load.php');
  if($session->isUserLoggedIn(true)) { redirect('dashboard.php', false);}
?>
<?php include_once('layouts/header.php'); ?>
<div class="login-page">
    <div class="text-center">
       <h1>STC - Inventário</h1>
       <p>Entre para iniciar a sessão</p>
     </div>
     <?= display_msg($msg); ?>
      <form method="post" action="auth.php" class="clearfix">
        <div class="form-group">
              <label for="username" class="control-label">Usuário</label>
              <input type="name" class="form-control" name="username" placeholder="usuário">
        </div>
        <div class="form-group">
            <label for="Password" class="control-label">Senha</label>
            <input type="password" name= "password" class="form-control" placeholder="senha">
        </div>
        <div class="form-group">
                <button type="submit" class="btn btn-info  pull-right">Entrar</button>
        </div>
    </form>
</div>
<?php include_once('layouts/footer.php'); ?>
