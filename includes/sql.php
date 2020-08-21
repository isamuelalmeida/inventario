<?php
require_once('includes/load.php');

/*--------------------------------------------------------------*/
/* Function for find all database table rows by table name
/*--------------------------------------------------------------*/
function find_all($table) {
 global $db;
 if(tableExists($table))
 {
   return find_by_sql("SELECT * FROM ".$db->escape($table));
 }
}

/*--------------------------------------------------------------*/
/* Function for Perform queries
/*--------------------------------------------------------------*/
function find_by_sql($sql)
{
  global $db;
  $result = $db->query($sql);
  $result_set = $db->while_loop($result);
  return $result_set;
}

/*--------------------------------------------------------------*/
/*  Function for Find data from table by id
/*--------------------------------------------------------------*/
function find_by_id($table,$id)
{
  global $db;
  $id = (int)$id;
  if(tableExists($table)){
    $sql = $db->query("SELECT * FROM {$db->escape($table)} WHERE id='{$db->escape($id)}' LIMIT 1");
    if($result = $db->fetch_assoc($sql))
      return $result;
    else
      return null;
  }
}

/*--------------------------------------------------------------*/
/* Function for Delete data from table by id
/*--------------------------------------------------------------*/
function delete_by_id($table,$id)
{
  global $db;
  if(tableExists($table))
  {
    $sql = "DELETE FROM ".$db->escape($table);
    $sql .= " WHERE id=". $db->escape($id);
    $sql .= " LIMIT 1";
    $db->query($sql);
    return ($db->affected_rows() === 1) ? true : false;
  }
}

/*--------------------------------------------------------------*/
/* Function for Count id  By table name
/*--------------------------------------------------------------*/
function count_by_id($table){
  global $db;
  if(tableExists($table))
  {
    $sql    = "SELECT COUNT(id) AS total FROM ".$db->escape($table);
    $result = $db->query($sql);
    return($db->fetch_assoc($result));
  }
}

/*--------------------------------------------------------------*/
/* Determine if database table exists
/*--------------------------------------------------------------*/
function tableExists($table){
  global $db;
  $table_exit = $db->query('SHOW TABLES FROM '.DB_NAME.' LIKE "'.$db->escape($table).'"');
  if($table_exit) {
    if($db->num_rows($table_exit) > 0)
      return true;
    else
      return false;
  }
}

/*--------------------------------------------------------------*/
 /* Login with the data provided in $_POST,
 /* coming from the login form.
 /*--------------------------------------------------------------*/
 function authenticate($username='', $password='') {
  global $db;
  $username = $db->escape($username);
  $password = $db->escape($password);
  $sql  = sprintf("SELECT id,username,password,user_level FROM users WHERE username ='%s' LIMIT 1", $username);
  $result = $db->query($sql);
  if($db->num_rows($result)){
    $user = $db->fetch_assoc($result);
    $password_request = sha1($password);
    if($password_request === $user['password'] ){
      return $user['id'];
    }
  }
  return false;
}


/*--------------------------------------------------------------*/
  /* Find current log in user by session id
  /*--------------------------------------------------------------*/
  function current_user(){
    static $current_user;
    global $db;
    if(!$current_user){
     if(isset($_SESSION['user_id'])):
       $user_id = intval($_SESSION['user_id']);
       $current_user = find_by_id('users',$user_id);
     endif;
   }
   return $current_user;
 }

 /*--------------------------------------------------------------*/
  /* Find all user by
  /* Joining users table and user gropus table
  /*--------------------------------------------------------------*/
  function find_all_user(){
    global $db;
    $results = array();
    $sql = "SELECT u.id,u.name,u.username,u.user_level,u.status,u.last_login,";
    $sql .="g.group_name ";
    $sql .="FROM users u ";
    $sql .="LEFT JOIN user_groups g ";
    $sql .="ON g.group_level=u.user_level ORDER BY u.name ASC";
    $result = find_by_sql($sql);
    return $result;
  }
  /*--------------------------------------------------------------*/
  /* Function to update the last log in of a user
  /*--------------------------------------------------------------*/

  function updateLastLogIn($user_id)
  {
    global $db;
    $date = make_date();
    $sql = "UPDATE users SET last_login='{$date}' WHERE id ='{$user_id}' LIMIT 1";
    $result = $db->query($sql);
    return ($result && $db->affected_rows() === 1 ? true : false);
  }

  /*--------------------------------------------------------------*/
  /* Find group level
  /*--------------------------------------------------------------*/
  function find_by_groupLevel($level)
  {
    global $db;
    $sql = "SELECT group_level,group_status FROM user_groups WHERE group_level = '{$db->escape($level)}' LIMIT 1 ";
    return find_by_sql($sql);
  }

  /*--------------------------------------------------------------*/
  /* Function for cheaking which user level has access to page
  /*--------------------------------------------------------------*/
  function page_require_level($require_level){
    global $session;
    $current_user = current_user();
    $login_level = find_by_groupLevel($current_user['user_level']);

    //if user not login
    if (!$session->isUserLoggedIn(true)):
      $session->msg('d','Por favor, faça o Login.');
      redirect('index.php', false);
      //if Group status Deactive
    elseif($login_level['0']['group_status'] === '0'):     
      if(!$session->logout()):
        $session->msg('d','Este nível de usuário está desabilitado.');
        redirect("index.php");        
      endif;
      //cheackin log in User level and Require level is Less than or equal to
    elseif($current_user['user_level'] <= (int)$require_level):
      return true;
    else:
      $session->msg("d", "Você não tem permissão para acessar esta página.");
      redirect('dashboard.php', false);
    endif;

}

/*--------------------------------------------------------------*/
   /* Function for Finding all equipment name
   /* JOIN with types_equips, suppliers, manufacturers and situations database table
   /*--------------------------------------------------------------*/
   function join_equipment_table(){
     global $db;
     $sql  =" SELECT e.id, e.tombo, e.specifications, e.obs, t_e.name AS type_equip,";
     $sql  .=" s.name AS supplier, m.name AS manufacturer, sit.name AS situation";
     $sql  .=" FROM equipments e";
     $sql  .=" INNER JOIN types_equips t_e ON t_e.id = e.types_equip_id";
     $sql  .=" INNER JOIN suppliers s ON s.id = e.supplier_id";
     $sql  .=" INNER JOIN manufacturers m ON m.id = e.manufacturer_id";
     $sql  .=" INNER JOIN situations sit ON sit.id = e.situation_id";
     $sql  .=" ORDER BY e.id ASC";
     return find_by_sql($sql);

   }

   /*--------------------------------------------------------------*/
  /* Function for Validate tombo of equipment
  /*--------------------------------------------------------------*/
  function validate_tombo($equipment_tombo){
   global $db;
   $sql = "SELECT tombo FROM equipments WHERE tombo = $equipment_tombo";
   $result = find_by_sql($sql);

   if(empty($result)){
    return false;
  }

  return true;
}

/*--------------------------------------------------------------*/
  /* Function for Finding all equipment name
  /* Request coming from ajax.php for auto suggest
  /*--------------------------------------------------------------*/
  function find_equipment_by_tombo($equipment_tombo){
   global $db;
   $e_tombo = remove_junk($db->escape($equipment_tombo));
   $sql  = "SELECT tombo FROM equipments";
   $sql .= " WHERE id NOT IN (SELECT equipment_id FROM loans)";
   $sql .= " AND tombo like '%$e_tombo%' LIMIT 5";
   $result = find_by_sql($sql);
   return $result;
 }

 /*--------------------------------------------------------------*/
  /* Function for Finding all equipment info by equipment tombo
  /* Request coming from ajax.php
  /*--------------------------------------------------------------*/
  function find_all_equipment_info_by_tombo($tombo){
    global $db;
    $sql  = "SELECT e.id,e.tombo,t_e.name AS type_equip FROM equipments e";
    $sql .= " INNER JOIN types_equips t_e ON t_e.id = e.types_equip_id";
    $sql .= " WHERE e.id NOT IN (SELECT equipment_id FROM loans)";    
    $sql .= " AND e.tombo ='{$tombo}'";
    return find_by_sql($sql);
  }

  /*--------------------------------------------------------------*/
  /* Function for Display Recent Equipment
  /*--------------------------------------------------------------*/
  function find_recent_equipment_added($limit){
    global $db;
    $sql  ="SELECT tombo,specifications";
    $sql .= " FROM equipments";
    $sql .= " ORDER BY created_at DESC LIMIT ".$db->escape((int)$limit);
    return find_by_sql($sql);
  }

  /*--------------------------------------------------------------*/
 /* Function for find all loans
 /*--------------------------------------------------------------*/
 function find_all_loan(){
   global $db;
   $sql  = "SELECT l.id,l.responsible_user,l.loan_date,e.tombo,e.specifications,s.name AS sector,t_e.name AS type_equip";
   $sql .= " FROM loans l";
   $sql .= " INNER JOIN equipments e ON e.id = l.equipment_id";
   $sql .= " INNER JOIN sectors s ON s.id = l.sector_id";
   $sql .= " INNER JOIN types_equips t_e ON t_e.id = e.types_equip_id";
   $sql .= " ORDER BY l.created_at DESC";   
   return find_by_sql($sql);
 }

 /*--------------------------------------------------------------*/
 /* Function for Display Recent Loan
 /*--------------------------------------------------------------*/
 function find_recent_loan_added($limit){
  global $db;
  $sql  ="SELECT l.id,l.responsible_user,l.loan_date,e.tombo,t_e.name AS type_equip";
  $sql .= " FROM loans l";
  $sql .= " INNER JOIN equipments e ON e.id = l.equipment_id";
  $sql  .=" INNER JOIN types_equips t_e ON t_e.id = e.types_equip_id";
  $sql .= " ORDER BY e.created_at DESC LIMIT ".$db->escape((int)$limit);
  return find_by_sql($sql);
}

 /*--------------------------------------------------------------*/
 /* Function for find all loan history
 /*--------------------------------------------------------------*/
 function find_all_loan_history(){
   global $db;
   $sql  = "SELECT l_h.id,l_h.responsible_user,l_h.loan_date,l_h.created_at,e.tombo,e.specifications,s.name AS sector,u.name AS create_user";
   $sql .= " FROM loan_historys l_h";
   $sql .= " INNER JOIN equipments e ON e.id = l_h.equipment_id";
   $sql .= " INNER JOIN sectors s ON s.id = l_h.sector_id";
   $sql .= " INNER JOIN users u ON u.id = l_h.created_by";
   $sql .= " ORDER BY l_h.created_at DESC";   
   return find_by_sql($sql);
}


?>
