<?php

function listDir(string $dir) {
	$listing =[];

	foreach (glob($dir . '*') as $filename) {
		$listing[] = "$filename";
	}

	return $listing;
}

	// if (isset($_GET['listDirG'])) {
		// return listDir('data/mix24/synced/');
	// }
?>
