<?php
	require("db.php");
	if (!isset($_GET["id"])) {
		echo "<script>location.href='index.php'</script>";
	}else{
		$id = mysqli_real_escape_string($con,$_GET["id"]);
		$verificar = mysqli_query($con,"SELECT * FROM users WHERE id='$id'");
		if (mysqli_num_rows($verificar)<=0) {
			echo "<script>location.href='index.php'</script>";
		}
		if (isset($_COOKIE["login"]) && isset($_COOKIE["login2"])) {
			$user_id = $_COOKIE["id"];
			$email = $_COOKIE["login"];
			$password = $_COOKIE["login2"];
			$verificar = mysqli_query($con,"SELECT * FROM users WHERE email='$email' AND password='$password'");
			if (mysqli_num_rows($verificar)<1) {
				echo "<script>location.href='index.php'</script>";
			}else{
				$log = "sim";
			}
		}
	}
	$info = mysqli_fetch_assoc($verificar);
	$count = mysqli_query($con,"SELECT * FROM inscritos WHERE conta='$id'");
?>
<!DOCTYPE html>
<html>
<body>
	<?php
		$get = mysqli_query($con,"SELECT * FROM inscritos WHERE user='$user_id' AND conta='$id'");
		if (isset($_GET["sub"]) && $id==$user_id) {
			return false;
		}elseif (isset($_GET["sub"]) && mysqli_num_rows($get)<=0) {
			$sub = mysqli_query($con,"INSERT INTO inscritos (user,conta) VALUES ('$user_id','$id')");
			if ($sub) {
				return true;
			}
		}elseif (isset($_GET["sub"]) && mysqli_num_rows($get)>0) {
			$sub = mysqli_query($con,"DELETE FROM inscritos WHERE user='$user_id' AND conta='$id'");
			if ($sub) {
				return true;
			}
		}elseif (isset($_GET["sub"])) {
			return false;
		}elseif ($id==$user_id) {
			?>
			<button id="insc">Editar a minha conta (<?php echo mysqli_num_rows($count); ?> Inscri&ccedil;&otilde;es)</button>
			<?php
		}elseif ($log=="nao") {
			?>
			<button id="insc" onclick="logar();"><?php echo mysqli_num_rows($count); ?> Inscri&ccedil;&otilde;es</button>
			<?php
		}elseif (mysqli_num_rows($get)>0) {
			?>
			<button id="insc" onclick="subscrever()">Inscrito (<?php echo mysqli_num_rows($count); ?> Inscri&ccedil;&otilde;es)</button>
			<?php
		}else{
			?>
			<button id="insc" onclick="subscrever()">Inscrever-se (<?php echo mysqli_num_rows($count); ?> Inscri&ccedil;&otilde;es)</button>
			<?php
		}
	?>
</html>