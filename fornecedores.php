<?php ob_start();
  $page_title = 'Todos os fornecedores';
  require_once('includes/load.php');
  // Checkin What level user has permission to view this page
  page_require_level(1);
  
  $all_suppliers = find_all('suppliers')
?>
<?php
 if(isset($_POST['add_supplier'])){
   $req_field = array('fornecedor-name');
   validate_fields($req_field);
   $supplier_name = remove_junk($db->escape($_POST['fornecedor-name']));
   if(empty($errors)){
      $sql  = "INSERT INTO suppliers (name)";
      $sql .= " VALUES ('{$supplier_name}')";
      if($db->query($sql)){
        $session->msg("s", "Fornecedor adicionado com sucesso!");
        redirect('fornecedores.php',false);
      } else {
        $session->msg("d", "Desculpe, falha ao cadastrar o fornecedor.");
        redirect('fornecedores.php',false);
      }
   } else {
     $session->msg("d", $errors);
     redirect('fornecedores.php',false);
   }
 }
?>
<?php include_once('layouts/header.php'); ?>

  <div class="row">
     <div class="col-md-12">
       <?= display_msg($msg); ?>
     </div>
  </div>
   <div class="row">
    <div class="col-md-5">
      <div class="panel panel-default">
        <div class="panel-heading">
          <strong>
            <span class="glyphicon glyphicon-th"></span>
            <span>Adicionar novo fornecedor</span>
         </strong>
        </div>
        <div class="panel-body">
          <form method="post" action="fornecedores.php">
            <div class="form-group">
                <input type="text" class="form-control" name="fornecedor-name" placeholder="Nome do fornecedor" required>
            </div>
            <button type="submit" name="add_supplier" class="btn btn-primary">Novo fornecedor</button>
        </form>
        </div>
      </div>
    </div>
    <div class="col-md-7">
    <div class="panel panel-default">
      <div class="panel-heading">
        <strong>
          <span class="glyphicon glyphicon-th"></span>
          <span>Todos os Fornecedores</span>
       </strong>
      </div>
        <div class="panel-body">
          <table class="table table-bordered table-striped table-hover">
            <thead>
                <tr>
                    <th class="text-center" style="width: 50px;">#</th>
                    <th>Fornecedores</th>
                    <th class="text-center" style="width: 100px;">Ações</th>
                </tr>
            </thead>
            <tbody>
              <?php foreach ($all_suppliers as $sup):?>
                <tr>
                    <td class="text-center"><?= count_id();?></td>
                    <td><?= remove_junk(ucfirst($sup['name'])); ?></td>
                    <td class="text-center">
                      <div class="btn-group">
                        <a href="editar_fornecedor.php?id=<?= (int)$sup['id'];?>"  class="btn btn-xs btn-warning" data-toggle="tooltip" title="Editar">
                          <span class="glyphicon glyphicon-edit"></span>
                        </a>
                        
                        <button title="Remover" type="button" class="btn btn-xs btn-danger" data-toggle="modal" data-target="#launchModal-<?= (int)$sup['id'];?>">
                          <i class="glyphicon glyphicon-remove"></i>
                        </button>
                        <?php $action="deletar_fornecedor.php"; $id=(int)$sup['id']; include('layouts/modal-confirmacao.php'); ?>
                      </div>
                    </td>

                </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
       </div>
    </div>
    </div>
   </div>
  </div>
  <?php include_once('layouts/footer.php'); ?>
