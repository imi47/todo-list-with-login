<?php
include 'db.php';
session_start();
$_POST = array_map('trim', $_POST);
if(!empty($_POST['description'])) {
	$query = $con->prepare('insert into tasks (user_id, description) values (?,?)');
	$query->execute(array($_SESSION['user_id'], $_POST['description']));
	header('Location: index.php');
}

else header('Location: index.php');