<?php session_start();
?>

<!doctype html>

<html lang='en'>
<head>
  <meta charset='utf-8'>

  <title>Banana</title>
  <meta name='description' content='Banana'>
  <meta name='MaxenceVacheron' content='SitePoint'>

  <link rel='stylesheet' href='../css/main.css'>	
  <script src='../js/scripts.js'></script>
  <style>
	  #navigatorView {
		border: 1px yellow solid;
		display: flex;
		flex-flow: row nowrap;
	  }
	  #sourceMenu {
		border: 1px yellow solid;
		display: flex;
		flex-flow: column nowrap;
	  }
  </style>
</head>

<body>
	<?php require '../view/header.php' ?>
	<main>
		<div id='navigatorView'>
			<div id='sourceMenu'>
				<a href='/pages/download-manager.php?listCompleteDir=true'> FLS </a>
				<a href='/pages/download-manager.php?listYT=true'> YTB </a>
			</div>
			<div>
				<?php require '../view/dir_navigator.php' ?>
				<?php require '../view/yt_navigator.php' ?>
			</div>
		</div>
	</main>
	<footer>Copyright © Maxence Vacheron <?php echo date("Y"); ?></footer> 
</body>
</html>
