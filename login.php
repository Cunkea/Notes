<html>
	<link rel="shortcut icon" href="images/e_note.ico">
<head>
	<meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- meta tagovi moraju biti prvi, sve ostalo ide ispod -->
    <title>e_Note</title>
	<script src="jquery-1.12.3.min.js"></script>
    <!-- Bootstrap -->
    <link rel="stylesheet" type="text/css" href="style.css">
    <link href="bootstrap.css" rel="stylesheet">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
    <link href='https://fonts.googleapis.com/css?family=Ubuntu' rel='stylesheet' type='text/css'>


</head>
<body style="background-image:url(images/enote_homepage_2.jpg)">



<div class="frame">
	<div class="login-box">
		<form action="" method="post">
			<input type="text" name="username" id="username" placeholder="Username" required><br>
			<input type="password" name="password" id="password" placeholder="Password" required><br>
			<input value="Log In" class="btn-default" name="Submit" type="submit">
			<br>
			<?php
			include_once 'spoj.php';
			if(isset($_POST['Submit'])){
				try {
					$veza = new PDO($dsn, $user, $pass);
					$veza->query("SET NAMES utf8");
					$izraz = $veza->prepare("select * from korisnici where username=:username and password=:password");
					$izraz->bindValue(":username",  $_POST['username'] );
					$izraz->bindValue(":password",  $_POST['password'] );
					$izraz->execute();
					$rez = $izraz->fetch();

					if(empty($rez)){
					?>
						<p style="color: red;">Neispravan username ili password!</p>
					<?php
					}else{
						include_once 'korisnik.php';
						$k = new korisnik(
								$rez['ime'],
								$rez['prezime'],
								$rez['username'],
								$rez['password'],
								$rez['email'],
								$rez['id']);
						
						session_start();
						$_SESSION['logiran']=true;
						$_SESSION['korisnik']=serialize($k);
						header("location: index.php");
					}

					$veza=null;
					} catch (PDOException $e) {
						print_r($e);
				}
			}
			?>
			<br><a href="#popup2" onclick="ShowBlock()">Don't have an Account?</a>
		</form>
		<div id="popup2" class="overlay">
			<div class="popup">
				<a id="closed" class="close" href="#" onclick="ShowNone()">&times;</a>

				<form role="form" id="form2" method="post" action="register.php"> 
					<h4><i class="fa fa-sign-in" aria-hidden="true"></i>&nbsp;&nbsp;Registration Form</h4>
					<div class="input-group input-group-sm">
  						<span class="input-group-addon" id="sizing-addon3"><i class="fa fa-asterisk" aria-hidden="true"></i></span>
  						<input type="text" name="ime" id="ime" class="form-control" placeholder="First Name" aria-describedby="sizing-addon3" required>
					</div><br>
					<div class="input-group input-group-sm">
  						<span class="input-group-addon" id="sizing-addon3"><i class="fa fa-asterisk" aria-hidden="true"></i></span>
  						<input type="text" name="prezime" id="prezime" class="form-control" placeholder="Last Name" aria-describedby="sizing-addon3" required>
					</div><br>
					<div class="input-group input-group-sm">
  						<span class="input-group-addon" id="sizing-addon3"><i class="fa fa-user" aria-hidden="true"></i></span>
  						<input type="text" name="username" id="username" class="form-control" placeholder="Username" aria-describedby="sizing-addon3" required>
					</div><br>
					<div class="input-group input-group-sm">
  						<span class="input-group-addon" id="sizing-addon3"><i class="fa fa-key" aria-hidden="true"></i></span>
  						<input type="password" name="password" id="password" class="form-control" placeholder="Password" aria-describedby="sizing-addon3" required>
					</div><br>
					<div class="input-group input-group-sm">
  						<span class="input-group-addon" id="sizing-addon3">@</span>
  						<input type="email" name="email" id="email" class="form-control" placeholder="E-mail" aria-describedby="sizing-addon3" required>
					</div>
					<br>
					<input class="btn-default" value="Register" name="submit" type="submit"><br>						
				</form>
			</div>
		</div>
	</div>
</div>


<script>
function ShowBlock(){
document.getElementById("popup2").style.display = "block";
}

function ShowNone(){
document.getElementById("popup2").style.display = "none";
}
</script>


</body>
</html>