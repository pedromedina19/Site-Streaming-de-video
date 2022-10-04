<?php
	include("header.php");
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
?>
<!DOCTYPE html>
<html>
<head>
	<style type="text/css">
		body{
			background-color: #444;
		}
		#fundo{
			width: 100%;
			height: 100vh;
			object-fit: cover;
			position: fixed;
			top: 0;
			left: 0;
			z-index: -999;
			filter: blur(20px);
		}
		video{
			display: block;
			margin: auto;
			max-width: 100%;
			max-height: 70vh;
			background-color: #222;
			border-bottom-left-radius: 0.5em;
			border-bottom-right-radius: 0.5em;
		}
		h1{
			display: block;
			margin: auto;
			width: 90%;
			text-align: center;
			font-weight: bold;
			padding: 10px 10px;
			color: #FFF;
		}
		#desc{
			display: block;
			margin: auto;
			width: 60%;
			padding: 20px 25px;
			background-color: #F9F9F9;
			border-radius: 0.3em;
			color: #333;
			margin-bottom: 30px;
		}
		h1 i{
			font-size: 12pt;
		}
		#comentarios{
			display: block;
			margin: auto;
			width: 60%;
			padding: 20px 25px;
			background-color: #F9F9F9;
			border-radius: 0.3em;
			color: #333;
			margin-bottom: 40px;
		}
		#comentarios p{
			border-top: 1px solid #CCC;
			padding-top: 10px;
			margin-bottom: 10px;
		}
		#comentarios textarea{
			display: block;
			margin: auto;
			width: 400px;
			height: 70px;
			resize: none;
			padding: 5px 7px;
			border-radius: 0.2em;
			margin-bottom: 5px;
		}
		#comentarios h3{
			color: #444;
			width: 100%;
			padding: 50px 20px;
			text-align: center;
		}
		#comentarios input{
			display: block;
			margin: auto;
			width: 400px;
			padding-top: 7px;
			padding-bottom: 7px;
			border-radius: 0.2em;
			margin-bottom: 10px;
			border: none;
			cursor: pointer;
		}
		#loading{
			position: fixed;
			top: 0;
			left: 0;
			width: 100%;
			height: 100vh;
			text-align: center;
			display: none;
			background-color: transparent;
		}
		#cor{
			position: absolute;
			width: 100%;
			height: 100vh;
			background-color: #000;
			opacity: 0.9;
			z-index: -1;
		}
		#loading p{
			color: #FFF;
			font-size: 36px;
			font-weight: bold;
			padding-top: 50vh;
		}
	</style>
</head>
<body>
	<div id="loading">
		<div id="cor"></div>
		<p>Carregando ....</p>
	</div>
	<img src="uploads/<?php echo $info["imagem"]; ?>" id="fundo">
	<video controls>
		<source src="uploads/<?php echo $info['local']; ?>" type="video/mp4">
		O seu navegador n&atilde;o suporta leitura de v&iacute;deos...
	</video>
	<h1><?php echo $info['nome']; ?> <i>(<?php echo $info['visualizacoes']; ?> visualiza&ccedil;&otilde;es)</i><p></p></h1>
	<p id="desc"><strong>Descri&ccedil;&atilde;o</strong><br /><br /><?php echo $info['descricao']; ?></p>
	<div id="comentarios">
		<strong>Coment&aacute;rios</strong><br /><br />
		<?php
			if ($log=="sim") {
				?><form method="POST" name="comentar"><textarea name="texto" placeholder="Escrever coment&aacute;rio..." maxlength="500"></textarea><input type="submit" name="comentar" value="Comentar"></form><?php
			}
			echo '<div id="comentario">';
			$get_comments = mysqli_query($con,"SELECT * FROM comentarios WHERE video='$id' ORDER BY id DESC");
			if (mysqli_num_rows($get_comments)>=1) {
				while ($comment = mysqli_fetch_assoc($get_comments)) {
					$user = $comment["user"];
					$get_user = mysqli_query($con,"SELECT * FROM users WHERE id='$user'");
					$user = mysqli_fetch_assoc($get_user);
					?>
					<p><strong><?php echo $user["nome"]; ?> disse:</strong><br /><?php echo $comment["texto"]; ?></p>
					<?php
				}
			}else{
				echo "<h3>N&atilde;o h&aacute; coment&aacute;rios para apresentar</h3>";
			}
			echo "</div>";
		?>
	</div>
	<script type="text/javascript">
		var interval = setInterval(function(){
			$.ajax({
				url: 'comentarios.php?id=<?php echo $id ?>',
				success: function(data){
					$('#comentario').html(data);
				},
				cache: false
			});
		}, 3000);
		$("form[name='comentar']").submit(function(e){
			var formData = new FormData($(this)[0]);
			$.ajax({
				url: 'comentarios.php?id=<?php echo $id ?>&comentar',
				type: "POST",
				data: formData,
				async: false,
				beforeSend: function(){
					$('#loading').fadeIn("fast");
				},
				success: function(){
					$.ajax({
						url: 'comentarios.php?id=<?php echo $id ?>',
						beforeSend: function(){
							$('#loading').fadeIn("fast");
						},
						success: function(data){
							$('#comentario').html(data);
							$('#loading').fadeOut("fast");
						},
						cache: false
					});
				},
				cache: false,
				contentType: false,
	            processData: false
			});
			e.preventDefault();
		});
	</script>
</body>
</html>