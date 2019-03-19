<?php
// Allow from any origin
if (isset($_SERVER['HTTP_ORIGIN'])) {
  // Decide if the origin in $_SERVER['HTTP_ORIGIN'] is one
  // you want to allow, and if so:
  header("Access-Control-Allow-Origin: {$_SERVER['HTTP_ORIGIN']}");
  header('Access-Control-Allow-Credentials: true');
  header('Access-Control-Max-Age: 86400');    // cache for 1 day
}

// Access-Control headers are received during OPTIONS requests
if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
  if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_METHOD']))
      // may also be using PUT, PATCH, HEAD etc
      header("Access-Control-Allow-Methods: GET, POST, OPTIONS");         
  if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']))
      header("Access-Control-Allow-Headers: {$_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']}");
  exit(0);
}
$jsonresponse = array();
if(isset($_POST)){//Se valida que se reciba POST
  require('conf.php');
  $action = $_POST['action'];
	switch ($action) {
    case 'validate':
      $identification  = base64_decode(base64_decode($_POST['identification']));
      $identification  = sanarString($identification);
      $mktid  = base64_decode(base64_decode($_POST['mktid']));
      $mktid  = sanarString($mktid);
      if($identification == '' || $mktid == ''){
        $jsonresponse['status']='error';
        $jsonresponse['message']='Campo Identification no puede estar vacios';
      }else{
        try{
          $stmt = $conn_sql->prepare('SELECT * FROM mikrotiks WHERE id = :id LIMIT 1');
          $stmt->execute(array(
            ':id'=>$mktid
          ));
          $st = $stmt->rowCount();
          if($st>0){
            $stmt = $conn_sql->prepare('SELECT * FROM users WHERE identification = :id LIMIT 1');
            $stmt->execute(array(
              ':id'=>$identification
            ));
            $st = $stmt->rowCount();
            if($st>0){
              $datos = $stmt->fetch();
              $name = $datos['name'];
              $jsonresponse['status']='success';
              $jsonresponse['message']='Consulta realizada';
              $jsonresponse['datos']=array(
                'name'=>$name
              );
            }else{
              $jsonresponse['status']='error';
              $jsonresponse['message']='No hay usuarios con este número de documento';
              $jsonresponse['datos']=array('cedula'=>base64_encode(base64_encode($identification)));
            }
          }else{
            $jsonresponse['status']='unregister';
            $jsonresponse['message']='Mikrotik no registrado en sistema, consulte al administrador';
          }
        }catch(PDOException $e){
          $jsonresponse['status']='error';
          $jsonresponse['message']=$e->getMessage();
        }
      }
    break;

    case 'register':
      $identification  = base64_decode(base64_decode($_POST['identification']));
      $identification  = sanarString($identification);
      $name  = base64_decode(base64_decode($_POST['name']));
      $name  = sanarString($name);
      $phone  = base64_decode(base64_decode($_POST['phone']));
      $phone  = sanarString($phone);
      $email  = base64_decode(base64_decode($_POST['email']));
      $email  = sanarString($email);
      $birthday  = base64_decode(base64_decode($_POST['birthday']));
      $birthday  = sanarString($birthday);
      $mktid  = base64_decode(base64_decode($_POST['mktid']));
      $mktid  = sanarString($mktid);
      if($identification == '' || $name == '' || $phone == '' || $email == '' || $birthday == ''){
        $jsonresponse['status']='error';
        $jsonresponse['message']='Campos no pueden estar vacios';
      }else{
        try{
          $stmt = $conn_sql->prepare('INSERT INTO users (id, identification, name, phone, email, birthday, mktid, created) 
          VALUES (:id, :identification, :name, :phone, :email, :birthday, :mktid, :created)');
          $stmt->execute(array(
            ':id'=>null,
            ':identification'=>$identification,
            ':name'=>$name,
            ':phone'=>$phone,
            ':email'=>$email,
            ':birthday'=>$birthday,
            ':mktid'=>$mktid,
            ':created'=>date('d/m/Y')
          ));
          $jsonresponse['status']='success';
          $jsonresponse['message']='Bienvenido';
        }catch(PDOException $e){
          $jsonresponse['status']='error';
          $jsonresponse['message']=$e->getMessage();
        }
      }
    break;
  }
}else{
	$jsonresponse['status']='error';
	$jsonresponse['message']='No se ha recibido método POST';
}
header('Content-type: application/json; charset=utf-8');
echo json_encode($jsonresponse);
exit();
?>