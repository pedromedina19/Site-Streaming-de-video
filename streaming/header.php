<?php
	include("db.php");

	if (isset($_POST["login"])) {
		$email = ($_POST["email"]);
		$password = ($_POST["password"]);
		$verificar = mysqli_query($con,"SELECT * FROM users WHERE email='$email' AND password='$password'");
		if (mysqli_num_rows($verificar)<=0) {
			echo '<h3 id="erro">Informa&ccedil;&otilde;es de login inv&aacute;lidas!</h3>';
		}else{
			$user_info = mysqli_fetch_assoc($verificar);
			echo '<script>document.cookie = "id='.$user_info["id"].'; expires=Thu, 18 Dec 2999 12:00:00 UTC";</script>';
			echo '<script>document.cookie = "login='.$email.'; expires=Thu, 18 Dec 2999 12:00:00 UTC";</script>';
			echo '<script>document.cookie = "login2='.$password.'; expires=Thu, 18 Dec 2999 12:00:00 UTC";</script>';
			echo '<script>location.href="index.php";</script>';
		}
	}
?>
<!DOCTYPE html>
<html>
<head>
	<style type="text/css">
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
		#login{
			position: fixed;
			top: 0;
			right: 0;
			margin-top: 80px;
			margin-right: 10px;
			width: 330px;
			padding-top: 10px;
			padding-bottom: 10px;
			border-radius: 0.3em;
			box-shadow: 0 0 10px #666;
			background-color: #F9F9F9;
			display: none;
			text-align: left;
		}
		#login input[type="email"], #login input[type="password"]{
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
		#login input[type="email"]:hover, #login input[type="password"]:hover{
			border: 1px solid #1C7293;
		}
		#login input[type="submit"]{
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
		#login h3{
			display: block;
			margin: auto;
			width: 90%;
			text-align: center;
			margin-bottom: 10px;
			color: #333;
		}
		#login p{
			position: absolute;
			bottom: 0;
			right: 0;
			margin-right: 20px;
			color: #333;
			margin-bottom: 10px;
			cursor: pointer;
		}
	</style>
	<script type="text/javascript" src="js/js.js"></script>
</head>
<body>
	<?php
		if (isset($_COOKIE["login"]) && isset($_COOKIE["login2"])) {
			$user_id = $_COOKIE["id"];
			$email = $_COOKIE["login"];
			$password = $_COOKIE["login2"];
			$verificar = mysqli_query($con,"SELECT * FROM users WHERE email='$email' AND password='$password'");
			if (mysqli_num_rows($verificar)>=1) {
				?>
				<div class="menu">
					<img src="img/logo.png" id="logo" onclick="location.href = 'index.php'" />
					<button onclick="location.href = 'logout.php'">Sair</button>
					<button onclick="location.href = 'conta.php?id=<?php echo $user_id; ?>'">O meu canal</button>
					<button onclick="location.href = 'upload.php'">Publicar</button>
					<button onclick="location.href = 'index.php'">Populares</button>
					<button onclick="location.href = 'recentes.php'">Recentes</button>
					<form method="GET" action="pesquisa.php">
						<input type="text" name="search" placeholder="Pesquisar v&iacute;deos e contas..."><input type="submit" name="pesquisar" value="Pesquisar">
					</form>
				</div>
				<?php
				$log = "sim";
				$get_info = mysqli_fetch_assoc($verificar);
				if ($get_info["imagem"]=="" || $get_info["capa"]=="") {
					mysqli_query($con,"UPDATE users SET imagem='bg.jpeg', capa='bg.jpeg'");
				}
			}else{
				?>
				<div class="menu">
					<img src="img/logo.png" id="logo" onclick="location.href = 'index.php'" />
					<button onclick="logar();">Log in</button>
					<button onclick="location.href = 'index.php'">Populares</button>
					<button onclick="location.href = 'recentes.php'">Recentes</button>
					<form method="GET" action="pesquisa.php">
						<input type="text" name="search" placeholder="Pesquisar v&iacute;deos e contas..."><input type="submit" name="pesquisar" value="Pesquisar">
					</form>
				</div>
				<form id="login" method="POST">
					<h3>Iniciar sess&atilde;o</h3>
					<input type="email" name="email" placeholder="Endereço e-mail" />
					<input type="password" name="password" placeholder="senha" />
					<input type="submit" name="login" value="Entrar"><p onclick="location.href = 'registar.php'">N&atilde;o tenho conta</p>
				</form>
				<script type="text/javascript">
					function logar(){
						document.getElementById("login").style.display = "block";
					}
				</script>
				<?php
				$log = "nao";
			}
		}else{
			?>
			<div class="menu">
				<img src="img/logo.png" id="logo" onclick="location.href = 'index.php'" />
				<button onclick="logar();">Log in</button>
				<button onclick="location.href = 'index.php'">Populares</button>
				<button onclick="location.href = 'recentes.php'">Recentes</button>
				<form method="GET" action="pesquisa.php">
					<input type="text" name="search" placeholder="Pesquisar v&iacute;deos e contas..."><input type="submit" name="pesquisar" value="Pesquisar">
				</form>
			</div>
			<form id="login" method="POST">
				<h3>Iniciar sessão</h3>
				<input type="email" name="email" placeholder="Endereço e-mail" />
				<input type="password" name="password" placeholder="senha" />
				<input type="submit" name="login" value="Entrar"><p onclick="location.href = 'registar.php'">N&atilde;o tenho conta</p>
			</form>
			<script type="text/javascript">
				function logar(){
					document.getElementById("login").style.display = "block";
				}
			</script>
			<?php
			$log = "nao";
		}
	?>
</body>
</html>