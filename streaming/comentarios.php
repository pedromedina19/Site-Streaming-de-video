<?php
	include("db.php");
	if (isset($_COOKIE["login"]) && isset($_COOKIE["login2"])) {
		$user_id = $_COOKIE["id"];
		$email = $_COOKIE["login"];
		$password = $_COOKIE["login2"];
		$verificar = mysqli_query($con,"SELECT * FROM users WHERE email='$email' AND password='$password'");
		if (mysqli_num_rows($verificar)>=1) {
			$log = "sim";
		}else{
			$log = "nao";
		}
	}else{
		$log = "nao";
	}
	//Começo do código
	if (!isset($_GET["id"])) {
		echo "<script>location.href='index.php'</script>";
	}else{
		$id = mysqli_real_escape_string($con,$_GET["id"]);
		$verificar = mysqli_query($con,"SELECT * FROM videos WHERE id='$id'");
		if (mysqli_num_rows($verificar)<=0) {
			echo "<script>location.href='index.php'</script>";
		}
	}
	$info = mysqli_fetch_assoc($verificar);

	if (isset($_GET["comentar"]) && $log="sim") {
		$texto = htmlspecialchars($_POST["texto"]);
		$texto = mysqli_real_escape_string($con,$texto);
		if ($texto!="") {
			$insert = mysqli_query($con,"INSERT INTO comentarios (user,video,texto) VALUES ('$user_id','$id','$texto')");
			if ($insert) {
				return true;
			}else{
				return false;
			}
		}else{
			return false;
		}
	}
?>
<!DOCTYPE html>
<html>
	<style type="text/css">
		body{
			background-color: #444;
		}
	</style>
	<strong>Comentários</strong><br /><br />
	<?php
		$get_comments = mysqli_query($con,"SELECT * FROM comentarios WHERE video='$id' ORDER BY id DESC");
		if (mysqli_num_rows($get_comments)>=1) {
			while ($comment = mysqli_fetch_assoc($get_comments)) {
				$user = $comment["user"];
				$get_user = mysqli_query($con,"SELECT * FROM users WHERE id='$user'");
				$user = mysqli_fetch_assoc($get_user);
				?>
				<p><strong><?php echo $user["nome"]; ?></strong><br /><?php echo $comment["texto"]; ?></p>
				<?php
			}
		}else{
			echo "<h3>N&atilde;o h&aacute; coment&aacute;rios para apresentar</h3>";
		}
	?>
</body>
</html>