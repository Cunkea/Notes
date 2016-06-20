<?php
	session_start();
	include_once 'spoj.php';
	if(!isset($_SESSION['logiran'])){
	header('location: login.php');
}else{
	include_once 'korisnik.php';
	$k=unserialize($_SESSION['korisnik']);
	$person=$k->getId();
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
				<li><a class="new" onclick="myFunction()">+ ADD NEW</a></li>
				<li><a class="outlink" style="float:right; padding-top:10px;" href="logout.php">LOG OUT</a></li>
				<li class="username"><span id="name" style="float:right; padding-right:25px; padding-top:10px;"><i class="fa fa-user" aria-hidden="true"></i>&nbsp;&nbsp;Welcome, <?php echo $k->getIme(); ?>!</span></li>
				<!-- <?php echo $k->getIme(); ?> ispisuje ime logiranog korisnika -->
			</div>
			<h3 style="text-align: center">Notes</h3>
			<div class="col-sm-11 col-sm-offset-1">
			<?php
			try {
  				$veza = new PDO($dsn, $user, $pass);
					$izraz = $veza->prepare("select * from korisnici_notes where person=:person;");
					$izraz->bindValue(":person",  $person );
					$izraz->execute();
					$rez = $izraz->fetchAll(PDO::FETCH_OBJ);
					foreach ($rez as $red){
					$dt = new DateTime($red->date);
			?>
			<div class="col-sm-3 note">
				<h4 class="naslov"><?php echo $red->naslov;?></h4>
				<p class="sadrzaj"><?php echo $red->tekst;?></p>

				<i><?php echo $dt->format("j. n. Y"); ?></i>
				<a type="submit" class="btn btn-info" href='edit.php?id=<?php echo $red->id;?>' >
				<i class="fa fa-pencil" aria-hidden="true"></i></i></a>

				<a type="submit" class="btn btn-info" role="button" href='delete.php?id=<?php echo $red->id;?>'>
				<i class="fa fa-times" aria-hidden="true"></i></a>
			</div>
			<div class="col-sm-1"></div>
			<?php 	
					}
				$veza=null;
			} catch (PDOException $e) {
				echo $e;
			}
			?>
			</div>

		<div class="modal" id="popup3">
  			<div class="modal-dialog" role="document">
    			<div class="modal-content">
      				<div class="modal-header">
        				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
          					<span aria-hidden="true" class="close" href="#" onclick="myFunctionClose()">&times;</span>
        				</button>
        				<h4 style="color:#737373"class="modal-title">Note it down</h4>
      				</div>
      				<div class="modal-body">
      					<form role="form" action="my_notes.php" id="form3" method="post">
      						<input type="text" id="naslovmodal" name="naslov" placeholder="Naslov"><br><br>
      						<textarea placeholder="Type here" id="tekstmodal" name="tekst" rows="8" cols="49"></textarea><br><p></p>

							<button type="submit" name="submit" class="btn btn-primary"><i class="fa fa-pencil-square-o" aria-hidden="true"></i>&nbsp;&nbsp;Create</button>
        				</form>
    				</div><!-- /.modal-content -->
  				</div><!-- /.modal-dialog -->
			</div><!-- /.modal -->
		</div>

	<script>
	function myFunction(){
	document.getElementById("popup3").style.display = "block";
	}


	function myFunctionClose(){
	document.getElementById("popup3").style.display = "none";
	}
	</script>


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