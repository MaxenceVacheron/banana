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
</head>

<body>
	<?php require '../view/header.php' ?>
	
	<main>
		<div id='navigator'>
			<h5 id='navigatorCurrentDir'></h5>
			<div id='navigatorDirNavigator'>

			</div>
			<div id='navigatorView'>
				<?php require '../view/navigator.php' ?>
			</div>
		</div>
	</main>
	<footer>Copyright © Maxence Vacheron <?php echo date("Y"); ?></footer> 
</body>


</html>