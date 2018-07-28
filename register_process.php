<?php
include 'db.php';
session_start();
$_POST = array_map('trim', $_POST);
if(empty($_POST['username']) || empty($_POST['email']) || empty($_POST['password']) || empty($_POST['confirm_password'])) {
	$_SESSION['error'] = 'Please fill in all the fields.';
	header('Location: register.php');
}
if(strlen($_POST['password']) < 6) {
	$_SESSION['error'] = 'Password must be atleast 6 charecters';
	header('Location: register.php');
}
else if($_POST['password'] == $_POST['confirm_password']) {
	$stmt = $con->prepare('SELECT count(*) from users where username = ?');
	$stmt->execute(array($_POST['username']));
	if($stmt->fetchColumn()) {
		$_SESSION['error'] = 'Username already exists.';
		header('Location: register.php');
	}
	else {
		$stmt = $con->prepare('INSERT into users (username, email, password) VALUES (?,?,?)');
		if($stmt->execute(array($_POST['username'], $_POST['email'], password_hash($_POST['password'], PASSWORD_DEFAULT)))) {
			$_SESSION['success'] = 'Account created.';
			header('Location: register.php');
		}
		else {
			$_SESSION['error'] = 'There was a problem creating your account.';
			header('Location: register.php');
		}
	}
}
else {
	$_SESSION['error'] = 'Passwords must match.';
	header('Location: register.php');
}