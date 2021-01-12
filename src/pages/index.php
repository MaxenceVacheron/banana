<!doctype html>

<html lang='en'>
<head>
  <meta charset='utf-8'>

  <title>The HTML5 Herald</title>
  <meta name='description' content='The HTML5 Herald'>
  <meta name='author' content='SitePoint'>

  <link rel='stylesheet' href='../css/main.css'>	
  <script src='../js/scripts.js'></script>
</head>

<body>
	<header>
		<span>
			<h1>Banana</h1>
			<span id='menu'>
			</span>
				<a href='../pages/index.php' id='navigatorButton'>To the Sea!</a>
				<a href='/download-manager.php' id='downloadManagerButton'>Download Manager</a>
			
		</span>
	</header>
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
