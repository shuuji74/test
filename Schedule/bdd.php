<?php
if(!isset($_COOKIE['id'])){
        setcookie('id','10001',time()+60*60*24*7);
}
$date = date("Y-m-d");
try
{
	$bdd = new PDO('mysql:host=localhost;dbname=hew;charset=utf8', 'root', '');
}
catch(Exception $e)
{
        die('Erreur : '.$e->getMessage());
}
