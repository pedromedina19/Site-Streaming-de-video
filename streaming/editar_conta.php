<?php
	include("header.php");
	if ($log=="nao") {
		echo "<script>location.href='index.php'</script>";
	}

	if (isset($_GET["editar"]) && $log=="sim") {
		# code...
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
			width: 200px;
			height: 25px;
			padding-left: 10px;
			color: #333;
			border-radius: 0.2em;
			border: 1px solid #CCC;
			margin-top: 10px;
		}
		#btn{
			display: block;
			padding-top: 5px;
			padding-bottom: 5px;
			color: #FFF;
			font-weight: bold;
			background-color: #1C7293;
			cursor: pointer;
			border-radius: 0.3em;
			border: none;
			margin-top: 20px;
			margin-left: 20px;
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
		<p>Editando conta atual ...</p>
	</div>
	<p id="aviso">Aten&ccedil;&atilde;o, as fotos ser&atilde;o carregadas assim que as altera&ccedil;&otilde;es forem salvas</p>
	<img src="uploads/<?php echo $get_info['capa']; ?>" id="capa">
	<form method="POST" name="editar" id="editar">
		<input type="file" name="capa" id="file2" onchange="avisar()" hidden />
		<label for="file2" id="btn">Alterar imagem de fundo</label>
		<input type="file" name="file" id="file" onchange="avisar()" hidden />
		<label for="file"><img src="uploads/<?php echo $get_info['imagem']; ?>" id="imagem"></label>
		<input type="text" name="nome" placeholder="Nome da conta..." id="field" value="<?php echo $get_info['nome']; ?>" />
		<input type="password" name="password" placeholder="Nova senha (opcional)" id="field" />
		<input type="submit" id="insc" name="editarConta" value="Salvar altera&ccedil;&otilde;es" />
	</form>
	<script type="text/javascript">
		$("form[name='editar']").submit(function(e){
			var formData = new FormData($(this)[0]);
			$.ajax({
				url: 'editar_conta_php.php',
				type: "POST",
				data: formData,
				async: false,
				beforeSend: function(){
					$('#loading').fadeIn("fast");
				},
				success: function(data){
					location.href="conta.php?id=<?php echo $user_id ?>";
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