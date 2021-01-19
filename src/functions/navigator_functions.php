<?php

require_once '../vendor/james-heinrich/getid3/getid3/getid3.php'; 


function listDir(string $dir): array {
	$listing =[];

	foreach (glob($dir . '*') as $filename) {
		$listing[] = "$filename";
	}

	return $listing;
}


function getStringCover($getID3fileObject) {

	
	// try to extract the album artwork (if any)
	// find the artwork in the $getID3fileObject structure
	$artwork = null;
	// try the different places in which I've found artwork
	if (isset($getID3fileObject['id3v2']['APIC'][0]['data'])) {

		$artwork = $getID3fileObject['comments']['picture'][0]['data'];

	} elseif (isset($getID3fileObject['comments']['picture'][0]['data'])) {
		
		$artwork = $getID3fileObject['id3v2']['APIC'][0]['data'];
		
	}
	
	// did we find some artwork?
	return $artwork ? '<img src="data:image/png;base64, ' . base64_encode($artwork) . '"class=navigator-cover alt="ALTCOVER" />':'No art found';
	// return '<img src="data:image/png;base64, ' . base64_encode($artwork) . '"class=navigator-cover alt="ALTCOVER" />':'No art found';
	
}

function getSongsInfo (string $strDir){
	$getID3 = new getID3;
	$songsInfo = [];

	foreach (listDir($strDir) as $item) {

		$songInfo = [] ;
		$ID3_file_info = $getID3->analyze($item);




		//GETTING SONG ARTIST/////////////////////////////////////////////////////////////////////////////////////////////////////////

		$songArtist = $ID3_file_info['id3v2']['comments']['artist'][0];
		
		if (!$songArtist) {
			$songArtist = $ID3_file_info['id3v2']['TPE1'][0]['data'];
			if (!$songArtist) {
				$songArtist = 'No artist found';
			}
		}

		$encoding = mb_detect_encoding($songArtist);

		if ($encoding) {
			$songArtist = iconv($encoding, "UTF-8", $songArtist);
			} else {
				$songArtist = iconv("UTF-16", "UTF-8", $songArtist);
			}



		//GETTING SONG TITLE/////////////////////////////////////////////////////////////////////////////////////////////////////////
		
		$songTitle = $ID3_file_info['id3v2']['TIT2'][0]['data'];

		if (!$songTitle) {
			$songTitle = $ID3_file_info['id3v2']['comments']['title'][0];
			if (!$songTitle) {
				$songTitle = $item . "notitlefound";
			}
		}

		$songTitle = strlen($songTitle) > 40 ? substr($songTitle,0,40)."..." : $songTitle; //Taile max du bousin
		
		$encoding = mb_detect_encoding($songTitle);

		if ($encoding) {
		$songTitle = iconv($encoding, "UTF-8", $songTitle);
		} else {
			// $songTitle = "Can't detect encoding...." . $songTitle;
			$songTitle = iconv("UTF-16", "UTF-8", $songTitle);
		}


		//////GETTING SONG COVER FOR EACH/////////////////////////////////////////////////////////////////////////////////
		$songArtwork = getStringCover($ID3_file_info);

		/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

		$songInfo[] = $songArtist;
		$songInfo[] = $songTitle;
		$songInfo[] = $songArtwork;

		$songsInfo[] = $songInfo;
	}

	return $songsInfo;

}

?>
