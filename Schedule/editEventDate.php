<?php

// Connexion à la base de données
require_once('bdd.php');

if (isset($_POST['Event'][0]) && isset($_POST['Event'][1]) && isset($_POST['Event'][2])){
	
	
	$id = $_POST['Event'][0];
	$start = $_POST['Event'][1];
	$end = $_POST['Event'][2];
	
	if (substr($id, 1,1)=== 'S') {
		$sql = "UPDATE solo_task SET task_start = '$start', task_finish= '$end' WHERE task_s_id = '$id'";
	}elseif(substr($id, 1,1) === 'G'){
		$sql = "UPDATE group_task SET task_start = '$start', task_finish = '$end' WHERE task_g_id = '$id'";
	}elseif(substr($id, 1,1) === 'C'){
		$sql = "UPDATE class_task SET task_start = '$start', task_finish = '$end' WHERE task_c_id = '$id'";
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
	}else{
		die ('OK');
	}

}
//header('Location: '.$_SERVER['HTTP_REFERER']);

	
?>
