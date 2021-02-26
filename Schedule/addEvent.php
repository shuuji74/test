<?php

// Connexion à la base de données
require_once('bdd.php');

//echo $_POST['title'];
if (isset($_POST['title']) && isset($_POST['start']) && isset($_POST['end']) && isset($_POST['color']) && isset($_POST['task']) && isset($_POST['task_priority'])){
	
	setcookie('id',10001,time()+60*60*24*7);

	$title = $_POST['title'];
	$start = $_POST['start'];
	$end = $_POST['end'];
	$color = $_POST['color'];
	$task = $_POST['task'];
	$priority = $_POST['task_priority'];

    $tasks = explode(",",$task);
	
	if ($tasks[1] == 's') {
		$result = $bdd->query("SELECT * FROM solo_task;");
	  
	}elseif($tasks[1] == 'g'){
		$result = $bdd->query("SELECT * FROM group_task;");
  
	}elseif($tasks[1] == 'c'){
		$result = $bdd->query("SELECT * FROM class_task;");
	}
	$task_id = 'task_'.$tasks[1].'_id';
	$products = [];
	if (isset($result)) {
		while($row = $result->fetch(PDO::FETCH_ASSOC)){
			$products[] = $row;
		}
	}
	
    if (empty($products)) {
      //タスクテーブルに何も入っていない場合の初期値を入れる処理
      $from['task_id'] = 'T'.strtoupper($tasks[1]).'10001';
    }else {
	  $last = array_keys($products);
      //タスクテーブルに値が入っている場合にする処理
      $from['task_id'] = 'T'.strtoupper($tasks[1]).(substr($products[end($last)][$task_id], -5)+1);
	}
    if ($tasks[1] == 's') {
      $sql = $bdd->query("INSERT INTO solo_task (task_s_id , task_name , task_priority , task_start , task_finish , color , member_id) VALUES ('" . $from['task_id'] . "' , '" . $title . "' , " . $priority . " , '" . $start . "' , '" . $end . "' , '" . $color . "' , " . $_COOKIE['id'] . ")");
      
    }elseif($tasks[1] == 'g'){
		$date = "INSERT INTO group_task (task_g_id , task_name , task_priority , task_start , task_finish , color , member_id , group_id) VALUES ('" . $from['task_id'] . "' , '" . $title . "' , " . $priority . " , '" . $start . "' , '" . $end . "' , '" . $color . "' , " . $_COOKIE['id'] . " , '" . $tasks[0] . "')";
      $sql = $bdd->query($date);

    }elseif($tasks[1] == 'c'){
      $sql = $bdd->query("INSERT INTO class_task (task_c_id , task_name , task_priority , task_start , task_finish , color , member_id , class_id) VALUES ('" . $from['task_id'] . "' , '" . $title . "' , " . $priority . " , '" . $start . "' , '" . $end . "' , '" . $color . "' , " . $_COOKIE['id'] . " , '" . $tasks[0] . "')");

    }
	// $sql = "INSERT INTO events(title, start, end, color) values ('$title', '$start', '$end', '$color')";
	//$req = $bdd->prepare($sql);
	//$req->execute();
	// echo $sql;

	// $query = $bdd->prepare( $sql );
	// if ($query == false) {
	//  print_r($bdd->errorInfo());
	//  die ('Erreur prepare');
	// }
	// $sth = $query->execute();
	// if ($sth == false) {
	//  print_r($query->errorInfo());
	//  die ('Erreur execute');
	// }

}

	header('Location: '.$_SERVER['HTTP_REFERER']);

?>
