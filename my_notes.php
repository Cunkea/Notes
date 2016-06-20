<?php
if(isset($_POST['submit'])){
	session_start();
	include_once 'spoj.php';
	include_once 'korisnik.php';
	$k=unserialize($_SESSION['korisnik']);
	$person=$k->getId();
	$naslov=trim($_POST['naslov']);
	$tekst=trim($_POST['tekst']);
	try {
		$veza = new PDO($dsn, $user, $pass);
		$veza->beginTransaction();
		$izraz = $veza->prepare("INSERT INTO `korisnici_notes` (`person`, `naslov`, `tekst`) VALUES (:person, :naslov, :tekst)");
		$izraz->bindValue(":person",  $person );
		$izraz->bindValue(":naslov",  $naslov );
		$izraz->bindValue(":tekst",  $tekst );
		$izraz->execute();

		$veza->commit();
		$veza=null;
		header("location: index.php");
	} catch (PDOException $e) {
			print_r($e);
	}
}
?>