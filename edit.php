<?php
session_start();
include_once 'spoj.php';
if(!isset($_SESSION['logiran'])){
	header('location: login.php');
}else{
	include_once 'korisnik.php';
	$k=unserialize($_SESSION['korisnik']);
	$id=$_GET['id'];
}
if(isset($_POST['submit'])){
	$naslov=trim($_POST['naslov']);
	$tekst=trim($_POST['tekst']);
	try {
		$veza = new PDO($dsn, $user, $pass);
		$veza->beginTransaction();
		$izraz = $veza->prepare("UPDATE korisnici_notes SET naslov=:naslov, tekst=:tekst
								WHERE id=:id");
		$izraz->bindValue(":id",  $id );
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
	<html>
		<link rel="shortcut icon" href="images/e_note.ico">
	<head>
		<meta charset="utf-8">
	    <meta http-equiv="X-UA-Compatible" content="IE=edge">
	    <meta name="viewport" content="width=device-width, initial-scale=1">
	    <link rel="icon" href="../../favicon.ico">

	    <!-- meta tagovi moraju biti prvi, sve ostalo ide ispod -->
	    <title>e_Note</title>
		<script src="jquery-1.12.3.min.js"></script>
	    <!-- Bootstrap -->
	    <link rel="stylesheet" type="text/css" href="style.css">
	    <link href="bootstrap.css" rel="stylesheet">
	    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
	    <link href='https://fonts.googleapis.com/css?family=Ubuntu' rel='stylesheet' type='text/css'>
	</head>

	<body>

			<div class="navbar">
				<li><span style="font-size:25px; padding-right:50px;">e_Note</span></li>
				<li><a class="new" href="index.php">GO BACK</a></li>
				<li><a class="outlink" style="float:right; padding-top:10px;" href="logout.php">LOG OUT</a></li>
				<li class="username"><span id="name" style="float:right; padding-right:25px; padding-top:10px;"><i class="fa fa-user" aria-hidden="true"></i>&nbsp;&nbsp;Welcome, <?php echo $k->getIme(); ?>!</span></li>
				<!-- <?php echo $k->getIme(); ?> ispisuje ime logiranog korisnika -->
			</div>
			<?php
			try {
  				$veza = new PDO($dsn, $user, $pass);
					$izraz = $veza->prepare("select * from korisnici_notes where id=:id;");
					$izraz->bindValue(":id",  $id );
					$izraz->execute();
					$rez = $izraz->fetch();
						?> 
						<center>
	  			<div class="modal-dialog" role="document">
	    			<div class="modal-content">
	      				<div class="modal-header">
	        				<h4 style="color:#737373"class="modal-title">Edit note</h4>
	      				</div>
	      				<div class="modal-body">
	      					<form role="form" id="form3" method="post" action="">
	      						<input type="text" id="naslovmodal" name="naslov" value="<?php echo $rez['naslov']; ?>"><br><br>
	      						<textarea id="tekstmodal" name="tekst" rows="8" cols="49"><?php echo $rez['tekst']; ?> </textarea><br><p></p>

								<button type="submit" name="submit" class="btn btn-primary"><i class="fa fa-pencil-square-o" aria-hidden="true"></i>&nbsp;&nbsp;Change</button>
	        				</form>
	    				</div><!-- /.modal-content -->
	  				</div><!-- /.modal-dialog -->
				</div><!-- /.modal -->
				</center>
			<?php 	
				$veza=null;
			} catch (PDOException $e) {
				echo $e;
			}
			?>

	    <!-- Bootstrap core JavaScript
	    ================================================== -->
	    <!-- Placed at the end of the document so the pages load faster -->
	    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
	    <script>window.jQuery || document.write('<script src="../../assets/js/vendor/jquery.min.js"><\/script>')</script>
	    <script src="../../dist/js/bootstrap.min.js"></script>
	    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
	    <script src="../../assets/js/ie10-viewport-bug-workaround.js"></script>
	  </body>
	</body>
</html>