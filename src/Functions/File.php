<?php

namespace App\Functions;

use getID3;



// class File
// {	
// 	public function echoBite() {
// 		echo "Bite";
// 	}
// }

class File
{

	public function listDir(string $dir): array {
		$listing =[];
		
		foreach (glob($dir . '*') as $filename) {
			$listing[] = "$filename";
		}
	
		return $listing;
	}
	
	
	public function getStringCover($getID3fileObject) {
	
		
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


	
	public function getSongsInfo (string $strDir): array {
		$getID3 = new getID3();
		$songsInfo = [];
		foreach ($this->listDir($strDir) as $item) {
			$songInfo = [] ;


			$strFilePath = $item;



			$ID3_file_info = $getID3->analyze($item);
	
	
	
			//GETTING SONG ARTIST/////////////////////////////////////////////////////////////////////////////////////////////////////////
	
			$songArtist = $ID3_file_info['id3v2']['comments']['artist'][0] ?? null;
			
			if (!$songArtist) {
				$songArtist = $ID3_file_info['id3v2']['TPE1'][0]['data'] ?? null;
				if (!$songArtist) {
					$songArtist = 'Unknown Artist';
				}
			}
	
			$encoding = mb_detect_encoding($songArtist);
	
			if ($encoding) {
				$songArtist = iconv($encoding, "UTF-8", $songArtist);
				} else {
					$songArtist = iconv("UTF-16", "UTF-8", $songArtist);
				}
	
			//GETTING SONG TITLE/////////////////////////////////////////////////////////////////////////////////////////////////////////
			
			$songTitle = $ID3_file_info['id3v2']['TIT2'][0]['data'] ?? null;
	
			if (!$songTitle) {
				$songTitle = $ID3_file_info['id3v2']['comments']['title'][0] ?? null;
				if (!$songTitle) {
					$songTitle = substr(basename($strFilePath), 0, -4); // Outputs 1


				}
			}
	
			// $songTitle = strlen($songTitle) > 40 ? substr($songTitle,0,40)."..." : $songTitle; //Taile max du bousin
			
			$encoding = mb_detect_encoding($songTitle);
	
			if ($encoding) {
				try {
					$songTitle = iconv($encoding, "UTF-8", $songTitle);
				} catch (\Exception $e){
				}
				
				
			} else {
				// $songTitle = "Can't detect encoding...." . $songTitle;
				$songTitle = iconv("UTF-16", "UTF-8", $songTitle);
			}
	
			//////GETTING SONG COVER FOR EACH/////////////////////////////////////////////////////////////////////////////////
			$songArtwork = 'COVER';
			// $songArtwork = $this->getStringCover($ID3_file_info);
	
			/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

			$songInfo[] = $strFilePath;
			$songInfo[] = $songArtist;
			$songInfo[] = $songTitle;
			$songInfo[] = $songArtwork;
	
			$songsInfo[] = $songInfo;
		}
	
		return $songsInfo;
	
	}


	public function getSmartSongsInfo (string $strDir): array {
		$getID3 = new getID3();
		$songsInfo = [];
		foreach ($this->listDir($strDir) as $item) {
			$songInfo = [] ;


			$strFilePath = $item;

			$filename = substr(basename($strFilePath), 0, -4);
			$youtubeSlug = substr($filename, -11);

			$API_KEY   = "AIzaSyD3LExXsa3bOor8wzLTyZFqGep3vwnRvUQ";
			$videoList = json_decode(file_get_contents("https://www.googleapis.com/youtube/v3/videos?part=snippet&id={$youtubeSlug}&key={$API_KEY}"));
		

			// dd($videoList->items[0]->snippet);
			//Image
			//$videoList->items[0]->snippet->thumbnails->default;

			$ID3_file_info = $getID3->analyze($item);
	
	
	
			//GETTING SONG ARTIST/////////////////////////////////////////////////////////////////////////////////////////////////////////
	
			$songArtist = $ID3_file_info['id3v2']['comments']['artist'][0] ?? null;
			
			if (!$songArtist) {
				$songArtist = $ID3_file_info['id3v2']['TPE1'][0]['data'] ?? null;
				if (!$songArtist) {

					// dd($videoList);
					$songArtist = $videoList->items[0]->snippet->channelTitle ?? '';
					
				}
			}
	
			$encoding = mb_detect_encoding($songArtist);
	
			if ($encoding) {
				$songArtist = iconv($encoding, "UTF-8", $songArtist);
				} else {
					$songArtist = iconv("UTF-16", "UTF-8", $songArtist);
				}
				

			if (substr($songArtist, -5) == "Topic") {
				$songArtist = substr($songArtist, 0, -8);
			}

			if (substr($songArtist, -4) == "VEVO") {
				$songArtist = substr($songArtist, 0, -4);
			}
	
	
			//GETTING SONG TITLE/////////////////////////////////////////////////////////////////////////////////////////////////////////
			


		
			//Title
			$youtubeTitle = $videoList->items[0]->snippet->title ?? '';

			$songTitle = $ID3_file_info['id3v2']['TIT2'][0]['data'] ?? null;
	
			if (!$songTitle) {
				$songTitle = $ID3_file_info['id3v2']['comments']['title'][0] ?? null;
				if (!$songTitle) {
					$songTitle = $youtubeTitle ;
				}
			}
	
			$encoding = mb_detect_encoding($songTitle);
	
			if ($encoding) {
				try {
					$songTitle = iconv($encoding, "UTF-8", $songTitle);
				} catch (\Exception $e){
				}
				
				
			} else {
				$songTitle = iconv("UTF-16", "UTF-8", $songTitle);
			}

			if (substr($songTitle, 0, strlen($songArtist)) == $songArtist) {
				$songTitle = substr($songTitle, strlen(($songArtist)) + 3); // CUT "ARTIST" FROM "ARTIST - SONG FEAT. ARTBIS"
			}

			
			//////GETTING SONG COVER FOR EACH/////////////////////////////////////////////////////////////////////////////////
			$songArtwork = 'COVER';
			// $songArtwork = $this->getStringCover($ID3_file_info);
	
			/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

			$songInfo['path'] = $strFilePath;
			$songInfo['artist'] = $songArtist;
			$songInfo['title'] = $songTitle;
			$songInfo['artwork'] = $songArtwork;
	
			$songsInfo[] = $songInfo;
		}
		// dd($songsInfo);
		return $songsInfo;
	
	}
	
}

?>
	
