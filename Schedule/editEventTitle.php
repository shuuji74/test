<?php

require_once('bdd.php');
if (isset($_POST['delete']) && isset($_POST['id'])){
	
	
	$id = $_POST['id'];

	if (substr($id, 1,1) === 'S') {
		$sql = "DELETE FROM solo_task WHERE task_s_id = '$id'";
	}elseif(substr($id, 1,1) === 'G'){
		$sql = "DELETE FROM group_task WHERE task_g_id = '$id'";
	}elseif(substr($id, 1,1) === 'C'){
		$sql = "DELETE FROM class_task WHERE task_c_id = '$id'";
	}

	$query = $bdd->prepare( $sql );
	if ($query == false) {
	 print_r($bdd->errorInfo());
	 die ('Erreur prepare');
	}
	$res = $query->execute();
	if ($res == false) {
	 print_r($query->errorInfo());
	 die ('Erreur execute');
	}
	
}elseif (isset($_POST['title']) && isset($_POST['color']) && isset($_POST['id']) && isset($_POST['task_priority'])){
	
	$id = $_POST['id'];
	$title = $_POST['title'];
	$color = $_POST['color'];
	$task_priority = $_POST['task_priority'];

	if (substr($id, 1,1)=== 'S') {
		$sql = "UPDATE solo_task SET task_name = '$title', color = '$color' , task_priority = $task_priority WHERE task_s_id = '$id'";
	}elseif(substr($id, 1,1) === 'G'){
		$sql = "UPDATE group_task SET task_name = '$title', color = '$color' , task_priority = $task_priority WHERE task_g_id = '$id'";
	}elseif(substr($id, 1,1) === 'C'){
		$sql = "UPDATE class_task SET task_name = '$title', color = '$color' , task_priority = $task_priority WHERE task_c_id = '$id'";
	}
	
	$query = $bdd->prepare( $sql );
	if ($query == false) {
	 print_r($bdd->errorInfo());
	 die ('Erreur prepare');
	}
	$sth = $query->execute();
	if ($sth == false) {
	 print_r($query->errorInfo());
	 die ('Erreur execute');
	}

}
header('Location: '.$_SERVER['HTTP_REFERER']);

	
?>
