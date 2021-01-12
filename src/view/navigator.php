<?php 

require_once '../functions/navigator_functions.php' ;
require_once '../vendor/james-heinrich/getid3/getid3/getid3.php'; 

?>

<a href='/pages/index.php?listDirGO=true'>List Directory</a>

Songs are : <br>

<ul>

<?php 

if (isset($_GET['listDirGO'])) {

	$getID3 = new getID3;

	foreach (listDir('../data/mix24/synced/') as $item) {

		$file_info = $getID3->analyze($item);
		// try to extract the album artwork (if any)
		// find the artwork in the $file_info structure
		$artwork = null;
		// try the different places in which I've found artwork
		if (isset($file_info['id3v2']['APIC'][0]['data'])) {

			$artwork = $file_info['comments']['picture'][0]['data'];

		} elseif (isset($file_info['comments']['picture'][0]['data'])) {
			
			$artwork = $file_info['id3v2']['APIC'][0]['data'];
			
		}
		
		// did we find some artwork?
		if ($artwork) {
			// echo imagecreatefromstring($artwork);

			$cover = '<img src="data:image/png;base64, ' . base64_encode($artwork) . '"class=navigator-cover alt="cover" />';

		}

		// <pre>print_r($file_info['id3v2']) <pre>
		// echo $file_info['id3v2'][];
		echo '<pre>',print_r($file_info['id3v2']),'</pre>';
		echo $cover;

		die;
	}

}
?>

</ul>

<?php 

// Initialize getID3 engine

// Analyze file and store returned data in $ThisFileInfo



?>