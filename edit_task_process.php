<?php
include 'db.php';
session_start();
if(isset($_SESSION['edit_task'])) {
	$query = $con->prepare('update tasks set description = ? where task_id = ?');
	$query->execute(array($_POST['description'], $_SESSION['edit_task']));
	unset($_SESSION['edit_task']);
	header('Location: index.php');
}

else header('Location: index.php');
