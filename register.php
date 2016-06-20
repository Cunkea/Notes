<?php
if(isset($_POST['submit'])){
	include_once 'spoj.php';

	$ime=trim($_POST['ime']);
	$prezime=trim($_POST['prezime']);
	$username=trim($_POST['username']);
	$password=trim($_POST['password']);
	$email=trim($_POST['email']);

	$veza = new PDO($dsn, $user, $pass);
	$veza->beginTransaction();

	$izraz = $veza->prepare("select * from korisnici where username=:username and password=:password");
	$izraz->bindValue(":username",  $_POST['username'] );
	$izraz->bindValue(":password",  $_POST['password'] );
	$izraz->execute();
	$rez = $izraz->fetch();

	if(empty($rez)){
		try {
			$veza = new PDO($dsn, $user, $pass);
			$veza->beginTransaction();
			$izraz = $veza->prepare("insert into korisnici (ime,prezime,username,email,password) values(:ime, :prezime, :username, :email, :password)");
			$izraz->bindValue(":ime",  $ime );
			$izraz->bindValue(":prezime",  $prezime );
			$izraz->bindValue(":email",  $email );
			$izraz->bindValue(":username",  $username );
			$izraz->bindValue(":password",  $password );
			$izraz->execute();

			$veza->commit();
			$veza=null;
			header("location: login.php");
		} catch (PDOException $e) {
				print_r($e);
		}
	}else{
		$test=false;	
	}
}
?>