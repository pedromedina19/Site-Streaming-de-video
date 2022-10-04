<?php
	include("db.php");

	if (isset($_POST["registar"])) {
		$nome = $_POST["nome"];
		$email = ($_POST["email"]);
		$password = ($_POST["password"]);
		$rep_password = $_POST["rep_password"];
		$verificar = mysqli_query($con,"SELECT * FROM users WHERE email='$email'");
		if (mysqli_num_rows($verificar)>0) {
			echo '<h3 id="erro">Esta conta já existe</h3>';
		}elseif ($_POST["email"]=="") {
			echo '<h3 id="erro">É necessário escrever um e-mail!</h3>';
		}elseif ($_POST["nome"]=="") {
			echo '<h3 id="erro">É necessário escrever um nome para a conta!</h3>';
		}elseif ($_POST["password"]=="") {
			echo '<h3 id="erro">É necessário escrever uma palavra-passe!</h3>';
		}elseif ($_POST["password"]!=$rep_password) {
			echo '<h3 id="erro">As palavras-passe não coincidem!</h3>';
		}else{
			$nome = htmlspecialchars($nome);
			$nome = mysqli_real_escape_string($con,$nome);
			$inserir = mysqli_query($con,"INSERT INTO users (nome,email,password) VALUES ('$nome','$email','$password')");
			if ($inserir) {
				$get_user = mysqli_query($con,"SELECT * FROM users WHERE email='$email' AND password='$password'");
				$user_info = mysqli_fetch_assoc($get_user);
				echo '<script>document.cookie = "id='.$user_info["id"].'; expires=Thu, 18 Dec 2999 12:00:00 UTC";</script>';
				echo '<script>document.cookie = "login='.$email.'; expires=Thu, 18 Dec 2999 12:00:00 UTC";</script>';
				echo '<script>document.cookie = "login2='.$password.'; expires=Thu, 18 Dec 2999 12:00:00 UTC";</script>';
				echo '<script>location.href="index.php";</script>';
			}else{
				echo '<h3 id="erro">Erro ao criar a conta...</h3>';
			}
		}
	}
?>
<!DOCTYPE html>
<html>
<head>
	<style type="text/css">
		body{
			background-color: #444;
		}
		.menu{
			background-color: #272932;
			width: 100%;
			height: 70px;
		}
		.menu #logo{
			float: left;
			height: 70px;
			margin-left: 30px;
			cursor: pointer;
		}
		.menu button{
			float: right;;
			margin-right: 20px;
			height: 45px;
			padding: 7px 10px;
			border: none;
			border-radius: 0.2em;
			background-color: transparent;
			color: #FFF;
			margin-top: 12px;
			cursor: pointer;
		}
		.menu button:hover{
			background-color: #1C7293;
		}
		.menu form{
			padding-top: 20px;
			text-align: center;
		}
		.menu input[type="text"]{
			display: inline-block;
			height: 25px;
			padding-left: 10px;
			color: #333;
			border: none;
			border-radius: 0.2em;
			width: 300px;
			background-color: #F9F9F9;
			border-top-right-radius: 0px;
			border-bottom-right-radius: 0px;
		}
		.menu input[type="text"]:focus{
			box-shadow: 0 0 10px #1C7293;
		}
		.menu input[type="submit"]{
			height: 27px;
			width: 100px;
			color: #333;
			border: none;
			border-radius: 0.2em;
			background-color: #F9F9F9;
			border-top-left-radius: 0px;
			border-bottom-left-radius: 0px;
			font-weight: bold;
		}
		.menu input[type="submit"]:hover{
			background-color: #1C7293;
			color: #FFF;
			cursor: pointer;
		}
		#registar{
			width: 330px;
			padding-top: 10px;
			padding-bottom: 10px;
			border-radius: 0.3em;
			background-color: #F9F9F9;
			display: block;
			margin: auto;
		}
		#registar input[type="email"], #registar input[type="password"], #registar input[type="text"]{
			display: block;
			margin: auto;
			width: 300px;
			height: 25px;
			padding-left: 10px;
			color: #333;
			border-radius: 0.2em;
			border: 1px solid #CCC;
			margin-bottom: 10px;
		}
		#registar input[type="email"]:hover, #registar input[type="password"]:hover, #registar input[type="text"]:hover{
			border: 1px solid #1C7293;
		}
		#registar input[type="submit"]{
			display: inline-block;
			height: 25px;
			padding: 0px 8px;
			background-color: #1C7293;
			color: #FFF;
			border-radius: 0.2em;
			border: none;
			margin-left: 10px;
			cursor: pointer;
		}
		#registar h3{
			display: block;
			margin: auto;
			width: 90%;
			text-align: center;
			margin-bottom: 10px;
			color: #333;
		}
		#bg{
			position: fixed;
			top: 0;
			left: 0;
			width: 100%;
			height: 100vh;
			filter: blur(10px);
			z-index: -999;
			object-fit: cover;
		}
		h1{
			width: 100%;
			padding: 50px 20px;
			text-align: center;
			color: #FFF;
		}
		#erro{
			color: #FFF;
			width: 100%;
			padding: 50px 20px;
			text-align: center;
		}
	</style>
</head>
<body>
	<img src="img/bg.jpeg" id="bg" />
	<div class="menu">
		<img src="img/logo.png" id="logo" onclick="location.href = 'index.php'" />
		<button onclick="location.href = 'index.php'">Populares</button>
		<button>Recentes</button>
		<form>
			<input type="text" name="search" placeholder="Pesquisar vídeos..."><input type="submit" name="pesquisar" value="Pesquisar">
		</form>
	</div>
	<h1>Partilhar memórias é mais fácil que nunca</h1>
	<form id="registar" method="POST">
		<h3>Criar uma conta</h3>
		<input type="text" name="nome" placeholder="Nome da conta" />
		<input type="email" name="email" placeholder="Endereço e-mail" />
		<input type="password" name="password" placeholder="Palavra-passe" />
		<input type="password" name="rep_password" placeholder="Repetir palavra-passe" />
		<input type="submit" name="registar" value="Criar conta">
	</form>
</html>