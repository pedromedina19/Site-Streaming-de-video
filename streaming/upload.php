<?php
	include("header.php");
	if ($log=="nao") {
		echo "<script>location.href='index.php'</script>";
	}
?>
<!DOCTYPE html>
<html>
<head>
	<style type="text/css">
		body{
			background-color: #444;
			text-align: center;
		}
		#capa{
			width: 100%;
			height: 100vh;
			object-fit: cover;
			position: fixed;
			top: 0;
			left: 0;
			z-index: -999;
			filter: blur(20px);
		}
		#imagem{
			display: block;
			margin: auto;
			margin-top: 50px;
			width: 200px;
			height: 200px;
			object-fit: cover;
			border-radius: 0.5em;
			cursor: pointer;
		}
		#insc{
			display: block;
			margin: auto;
			padding: 7px 13px;
			color: #FFF;
			font-weight: bold;
			background-color: #1C7293;
			cursor: pointer;
			border-radius: 0.3em;
			border: none;
			margin-top: 20px;
		}
		#insc:hover, #btn:hover{
			font-size: 16pt;
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
		#editar #field{
			display: block;
			margin: auto;
			width: 400px;
			height: 25px;
			padding-left: 10px;
			color: #333;
			border-radius: 0.2em;
			border: 1px solid #CCC;
			margin-top: 20px;
		}
		textarea{
			display: block;
			margin: auto;
			width: 400px;
			height: 250px;
			padding-left: 10px;
			color: #333;
			border-radius: 0.2em;
			border: 1px solid #CCC;
			margin-top: 10px;
		}
		#btn{
			padding: 5px;
			color: #FFF;
			font-weight: bold;
			background-color: #1C7293;
			cursor: pointer;
			border-radius: 0.3em;
			border: none;
			margin-top: 20px;
			width: 200px;
		}
		#aviso{
			display: block;
			margin: auto;
			background-color: #444;
			color: #FFF;
			padding: 15px 20px;
			border-radius: 0.3em;
			width: 80%;
			font-size: 16pt;
			font-weight: bold;
			margin-top: 15px;
			display: none;
		}
	</style>
</head>
<body>
	<div id="loading">
		<div id="cor"></div>
		<p>publicando o v&iacute;deo ...</p>
	</div>
	<p id="aviso">V&iacute;deo selecionado</p>
	<img src="uploads/<?php echo $get_info['capa']; ?>" id="capa">
	<form method="POST" name="upload" id="editar" enctype="multipart/form-data">
		<br /><br />
		<input type="file" name="file" id="file" onchange="avisar();" hidden />
		<input type="file" name="filethumb" id="file2" hidden />
		<label for="file" id="btn">Selecionar um v&iacute;deo</label>&nbsp;&nbsp;<label for="file2" id="btn">Selecionar uma thumnail</label>
		<input type="text" name="titulo" placeholder="T&iacute;tulo do vídeo..." id="field" />
		<textarea placeholder="Descri&ccedil;&atilde;o" name="descricao" maxlength="1000"></textarea>
		<input type="submit" id="insc" name="publicar" value="Publicar v&iacute;deo" />
	</form>
	<script type="text/javascript">
		$("form[name='upload']").submit(function(e){
			var formData = new FormData($(this)[0]);
			$.ajax({
				url: 'upload_php.php',
				type: "POST",
				data: formData,
				async: false,
				beforeSend: function(){
					$('#loading').fadeIn("fast");
				},
				success: function(data){
					location.href="conta.php?id=<?php echo $user_id ?>";
				},
				error: function(){
					$('#loading').fadeOut("fast");
				},
				cache: false,
				contentType: false,
	            processData: false
			});
			e.preventDefault();
		});
		function avisar(){
			$('#aviso').fadeIn("slow");
		}
	</script>
</html>