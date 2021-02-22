<?php 

require_once '../functions/navigator_functions.php' ;
require_once '../vendor/james-heinrich/getid3/getid3/getid3.php'; 

?>

<html>
<head>
<style type="text/css">

.navigator {
	background-color: #FFFFFF;
	max-width: 100% ;
	display: block;
	margin-left: auto;
	margin-right: auto;
}
@media (min-width: 777px) {
    .navigator {
        width: 66.66%;
    }
}

.listing:hover {
    box-shadow: inset 0 0 100px 100px rgba(255, 255, 255, 0.1);
	background-color: lightcyan ;
}


.songs-listing {
	border: 1px solid blueviolet;
	padding: 5% 5% 5% 5% ;
}

.unique-song-line {
	border: 1px solid blue;
	padding: 1em 1em 1em 1em  ;
	display: flex;
	flex-flow: row nowrap ;
}

.cover-field {
	order:1;
	border: 1px solid darksalmon;
	/* padding-right: 5em;	 */
	/* display: block; */
	width: 55%;
	/* height: 5%; */
	background-color: darkseagreen;
}

.navigator-cover {
	width: 100%;
}

.artist-field {
	order:2;
	border: 1px solid green;
	font-size: 1.2em;
	/* padding-right: 5em;	 */
	/* width: 22%; */
}

.title-field {
	order:3;
	border: 1px solid darkred;
	/* position: absolute; */
	/* right: 20%; */

}

</style>
</head>


<div class="navigator">
<a href='/pages/music.php?musicView=true' style="float: right;">See Imported Songs</a>
<?php 


if (isset($_GET['musicView'])) {


	$_SESSION['musicView'] = $_GET['musicView'] ;

	$songsInfo = getSongsInfo('../data/mix24/synced/');

	$html .= "<div class='listing songs-listing'>";
	foreach ($songsInfo as $songInfo){
		$artist = "";
		// print_r($songInfo);
		$html .= "<div class='unique-song-line'>";
		// $artist = var_dump($songInfo[0]);
		$html .= "<span class='cover-field'> $songInfo[2]</span>";
		$html .= "<span class='artist-field'>$songInfo[0]</span>";
		$html .= "<span class='title-field'> $songInfo[1]</span>";
		$html .= "</div><br>";
	}
	$html .= "</div>";
	echo $html;
}

?>

</div>
</html>
