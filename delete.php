<?php
session_start();
include_once 'spoj.php';
if(!isset($_SESSION['logiran'])){
	header('location: login.php');
}else{
	include_once 'korisnik.php';
	$k=unserialize($_SESSION['korisnik']);
	$id=$_GET['id'];
	$person=$k->getId();
}
try {
	$veza = new PDO($dsn, $user, $pass);
	$veza->beginTransaction();
	$izraz = $veza->prepare("Delete from korisnici_notes where id=:id and person=:person");
	$izraz->bindValue(":id",  $id );
	$izraz->bindValue(":person",  $person );
	$izraz->execute();

	$veza->commit();
	$veza=null;
	header("location: index.php");
} catch (PDOException $e) {
		print_r($e);
}