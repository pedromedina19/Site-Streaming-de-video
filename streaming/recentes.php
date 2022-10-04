<?php
	include("header.php");
	$get_videos = mysqli_query($con,"SELECT * FROM videos ORDER BY id DESC");
?>
<!DOCTYPE html>
<html>
<head>
	<style type="text/css">
		h1{
			width: 100%;
			padding: 20px 10px;
			text-align: center;
			color: #1C7293;
		}
		#erro{
			color: #444;
			width: 100%;
			padding: 50px 20px;
			text-align: center;
		}
		#video{
			width: 200px;
			min-height: 200px;
			display: inline-block;
			margin-left: 20px;
			margin-bottom: 20px;
			text-align: center;
			border: 1px solid #CCC;
		}
		#video img{
			width: 100%;
			height: 125px;
			object-fit: cover;
			cursor: pointer;
		}
		#video h3{
			width: 100%;
			padding: 5px 10px;
			text-align: justify;
			cursor: pointer;
		}
		#video p{
			margin-top: 10px;
			width: 95%;
			text-align: right;
			font-size: 10pt;
			font-weight: bold;
			color: #666;
		}
	</style>
</head>
<body>
	<h1>Os vídeos mais recentes</h1>
	<br /><br />
	<div style="text-align: center;">
		<?php
			if (mysqli_num_rows($get_videos)<=0) {
				echo '<h3 id="erro">N&atilde;o h&aacute; conte&uacute;do para mostrar...</h3>';
			}else{
				while ($video=mysqli_fetch_assoc($get_videos)) {
					$user = $video["user"];
					$get_user = mysqli_query($con,"SELECT * FROM users WHERE id='$user'");
					$user_info = mysqli_fetch_assoc($get_user);
					$nome = $user_info["nome"];
					?>
					<div id="video">
						<img onclick="location.href = 'video.php?id=<?php echo $video["id"]; ?>'" src="uploads/<?php echo $video['imagem']; ?>" />
						<h3 onclick="location.href = 'video.php?id=<?php echo $video["id"]; ?>'"><?php echo $video["nome"]; ?></h3>
						<p>Publicado por <i style="cursor: pointer;" onclick="location.href = 'conta.php?id=<?php echo $user; ?>'"><?php echo $nome; ?></i></p>
					</div>
					<?php
				}

			}
		?>
	</div>
</body>
</html>