<?php ob_start();
$page_title = 'Relatório de Equipamentos';
$results = '';
  require_once('includes/load.php');
  // Checkin What level user has permission to view this page
   page_require_level(2);
?>
<?php
  if(isset($_POST['submit'])){
    $req_fields = array('equipment-tombo','equipment-specifications','equipment-sector','equipment-type_equip','equipment-supplier','equipment-manufacturer','equipment-situation');
    //validate_fields($req_fields);

    if(empty($errors)):
      $equip_tombo  = remove_junk($db->escape($_POST['equipment-tombo']));
      $equip_specifications  = remove_junk($db->escape($_POST['equipment-specifications']));
      $equip_type_equip   = remove_junk($db->escape($_POST['equipment-type_equip']));
      $equip_supplier   = remove_junk($db->escape($_POST['equipment-supplier']));
      $equip_manufacturer   = remove_junk($db->escape($_POST['equipment-manufacturer']));
      $equip_situation  = remove_junk($db->escape($_POST['equipment-situation']));

      $all_equips = find_by_sql("
        SELECT e.tombo,l.responsible_user,s.name AS sector,m.name AS manufacturer,sup.name AS supplier,t_h.name AS types_equip FROM equipments e 
        LEFT JOIN loans l ON l.equipment_id = e.id LEFT JOIN sectors s ON s.id = l.sector_id 
        INNER JOIN manufacturers m ON m.id = e.manufacturer_id 
        INNER JOIN suppliers sup ON sup.id = e.supplier_id 
        INNER JOIN types_equips t_h ON t_h.id = e.types_equip_id
        ");

    else:
      $session->msg("d", $errors);
      redirect('relatorios.php', false);
    endif;

  } else {
    $session->msg("d", "Desculpe, não foi possível gerar o relatório!");
    redirect('relatorios.php', false);
  }
?>
<!doctype html>
<html lang="pt-br">
 <head>
   <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
   <title>Relatório de Equipamentos</title>
     <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css"/>
   <style>
   @media print {
     html,body{
        font-size: 9.5pt;
        margin: 0;
        padding: 0;
     }.page-break {
       page-break-before:always;
       width: auto;
       margin: auto;
      }
    }
    .page-break{
      width: 980px;
      margin: 0 auto;
    }
     .head{
       margin: 40px 0;
       text-align: center;
     }.head h1,.head strong{
       padding: 10px 20px;
       display: block;
     }.head h1{
       margin: 0;
       border-bottom: 1px solid #212121;
     }.table>thead:first-child>tr:first-child>th{
       border-top: 1px solid #000;
      }
      table thead tr th {
       text-align: center;
       border: 1px solid #ededed;
     }table tbody tr td{
       vertical-align: middle;
     }.head,table.table thead tr th,table tbody tr td,table tfoot tr td{
       border: 1px solid #212121;
       white-space: nowrap;
     }.head h1,table thead tr th,table tfoot tr td{
       background-color: #f8f8f8;
     }
   </style>
</head>
<body>
  <?php if($all_equips): ?>
    <div class="page-break">
       <div class="head pull-">
           <h1>Relatório de Equipamentos</h1>
           <strong>Relatório gerado às <?= strftime('%H:%M em %d/%m/%Y', strtotime(make_date())) ?></strong>
       </div>
      <table class="table table-border">
        <thead>
          <tr>
              <th>#</th>             
              <th>Tombo</th>
              <th>Tipo de Equipamento</th>
              <th>Usuário Responsável</th>              
              <th>Setor</th>
              <th>Fabricante</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach($all_equips as $result): ?>
           <tr>
              <td class=""><?= count_id(); ?></td>              
              <td><?= remove_junk($result['tombo']);?></td>
              <td><?= remove_junk($result['types_equip']);?></td>              
              <td><?php if(empty($result['responsible_user'])): echo "SUINFOR"; else: echo remove_junk($result['responsible_user']); endif;?></td>
              <td><?php if(empty($result['sector'])): echo "SUINFOR"; else: echo remove_junk($result['sector']); endif;?></td>
              <td><?= remove_junk($result['manufacturer']);?></td>
          </tr>
        <?php endforeach; ?>
        </tbody>        
      </table>
    </div>
  <?php
    else:
        $session->msg("d", "Desculpe, nenhum equipamento encontrado!");
        redirect('relatorios.php', false);
     endif;
  ?>
</body>
</html>
<?php if(isset($db)) { $db->db_disconnect(); } ?>
