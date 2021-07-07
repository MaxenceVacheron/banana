<?php

namespace App\Controller;

use App\Entity\Album;
use App\Entity\Artist;
use App\Entity\Mood;
use App\Entity\Song;
use Doctrine\ORM\EntityManagerInterface;
use PhpParser\Node\Expr\Cast\Array_;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Constraints\Json;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;



class PlayerController extends AbstractController
{

	function __construct(EntityManagerInterface $em)
	{
		$this->em = $em;
	}

	/**
	 * @Route("/player", name="player", methods={"GET", "POST"})
	 */
	public function index(Request $request): Response
	{
		$askedQuery = $request->query->all();

		$artistsArray = [];
		$yearsArray = [];
		$albumsArray = [];
		$moodsArray = [];

		$moodRepo = $this->em->getRepository(Mood::class);
		$moods = $moodRepo->findAll();
		foreach ($moods as $mood) {
			$moodsArray[] = $mood->getName();
		}

		$artistRepo = $this->em->getRepository(Artist::class);
		$artists = $artistRepo->findAll();
		foreach ($artists as $artist) {
			$artistsArray[] = $artist->getName();
		}

		$albumRepo = $this->em->getRepository(Album::class);
		$albums = $albumRepo->findAll();
		foreach ($albums as $album) {
			$albumsArray[] = $album->getName();
		}

		$songRepo = $this->em->getRepository(Song::class);
		$songs = $songRepo->findAll();


		foreach ($songs as $song) {
			if (!in_array($song->getYear(), $yearsArray)) {
				$yearsArray[] = $song->getYear();
			}
		}

		return $this->render('player/index.html.twig', [
			'controller_name' => 'PlayerController',
			'askedQuery' => $askedQuery,
			'moods' => $moodsArray,
			'artists' => $artistsArray,
			'years' => $yearsArray,
			'albums' => $albumsArray,
		]);
	}


	/**
	 * @Route("/player/queue", name="queue", methods={"GET", "POST"})
	 */
	public function returnQueue(Request $request)
	{
		// $askedQuery = $request->toArray();
		$askedQuery = $request->query->all();
		// dd($askedQuery);
		$songRepo = $this->em->getRepository(Song::class);
		$moodRepo = $this->em->getRepository(Mood::class);
		$artistRepo = $this->em->getRepository(Artist::class);
		$albumRepo = $this->em->getRepository(Album::class);

		$askedMoods = array_key_exists('mood', $askedQuery) ? $askedQuery['mood'] : null;
		// dd($askedMoods);
		$askedArtists = array_key_exists('artist', $askedQuery) ? $askedQuery['artist'] : null;
		$askedAlbums = array_key_exists('album', $askedQuery) ? $askedQuery['album'] : null;
		$askedYears = array_key_exists('year', $askedQuery) ? $askedQuery['year'] : null;

		$songsQueue = [];

		if ($askedMoods) {
			foreach ($askedMoods as $askedMood) {
				$_askedMood = $moodRepo->findOneBy(['name' => $askedMood]);
				$songsLinkedtoMood = $_askedMood->getSongs()->getValues();

				foreach ($songsLinkedtoMood as $songLinkedtoMood) {

					$artistsArray = [];
					$songHasArt = $songLinkedtoMood->getSongHasArtists();
					foreach ($songHasArt as $sameSongDifArtist) {
						$artistType = $sameSongDifArtist->getArtistType()->getName();
						$artistsArray[$artistType][] = $sameSongDifArtist->getArtist()->getName();
					}

					$mltplMoods = $songLinkedtoMood->getMoods()->getValues();
					$moodNames = [];
					foreach ($mltplMoods as $unqMood) {
						$moodNames[] = $unqMood->getName();
					}

					$songsQueue[] =
						[
							'path' => substr($songLinkedtoMood->getPath(), 20),
							// 'path' => $songLinkedtoMood->getPath(),
							'title' => $songLinkedtoMood->getTitle(),
							'artists' => $artistsArray,
							'moods' => $moodNames,
							'album' => $songLinkedtoMood->getAlbums(),
						];
				}
			}
		}

		if ($askedArtists) {
			foreach ($askedArtists as $askedArtist) {

				$_askedArtist = $artistRepo->findOneBy(['name' => $askedArtist]);
				$songsHasLinkedtoArtist = $_askedArtist->getSongHasArtists()->getValues(); //ALL SONGSHASARTIST

				// dd($songsHasLinkedtoArtist);



				foreach ($songsHasLinkedtoArtist as $songLinkedToArtist_) {


					$songLinkedToArtist = $songLinkedToArtist_->getSong();



					// $artistsArray = [];
					// $songHasArt = $song->getSongHasArtists();
					// foreach ($songHasArt as $sameSongDifArtist) {
					// 	$artistType = $sameSongDifArtist->getArtistType()->getName();
					// 	$artistsArray[$artistType][] = $sameSongDifArtist->getArtist()->getName();
					// }

					$artistsArray = [];
					$songHasArt = $songLinkedToArtist->getSongHasArtists(); 
					foreach ($songHasArt as $sameSongDifArtist) {
						$artistType = $sameSongDifArtist->getArtistType()->getName();
						$artistsArray[$artistType][] = $sameSongDifArtist->getArtist()->getName();
					}

					$moodNames = [];
					$mltplMoods = $songLinkedToArtist->getMoods()->getValues();
					foreach ($mltplMoods as $unqMood) {
						$moodNames[] = $unqMood->getName();
					}

					$albumsArray = []; //ALL ALBUMS THE SONG IS IN
					$_albumsArray = $songLinkedToArtist->getAlbums()->getValues(); // OTHER ALBUMS THE SONG IS FEATURED IN

					foreach ($_albumsArray as $unqAlbum) {
						$albumsArrayUnqName = $unqAlbum->getName();
						$albumsArrayYear = $unqAlbum->getYear();

						$unqAlbumArtists = [];
						$albumsArrayArtists = $unqAlbum->getArtists()->getValues();
						foreach ($albumsArrayArtists as $unqAlbumArtist) {
							$unqAlbumArtists[] = $unqAlbumArtist->getName();
						}

						$albumsArray[$albumsArrayUnqName]['year'] = $albumsArrayYear;
						$albumsArray[$albumsArrayUnqName]['artists'] = $unqAlbumArtists;
					}


					$songsQueue[] =
						[
							'path' => substr($songLinkedToArtist->getPath(), 20),
							'title' => $songLinkedToArtist->getTitle(),
							'artists' => $artistsArray,
							'moods' => $moodNames,
							'albums' => $albumsArray,
						];
				}
			}
		}

		if ($askedAlbums) {

			foreach ($askedAlbums as $askedAlbum) {

				$_askedAlbum = $albumRepo->findOneBy(['name' => $askedAlbum]);
				$songsLinkedtoAlbum = $_askedAlbum->getSongs()->getValues();

				foreach ($songsLinkedtoAlbum as $songLinkedtoAlbum) {

					$artistsArray = [];
					$songHasArt = $songLinkedtoAlbum->getSongHasArtists(); 
					foreach ($songHasArt as $sameSongDifArtist) {
						$artistType = $sameSongDifArtist->getArtistType()->getName();
						$artistsArray[$artistType][] = $sameSongDifArtist->getArtist()->getName();
					}

					$moodNames = [];
					$mltplMoods = $songLinkedtoAlbum->getMoods()->getValues();
					foreach ($mltplMoods as $unqMood) {
						$moodNames[] = $unqMood->getName();
					}

					$albumsArray = []; //ALL ALBUMS THE SONG IS IN
					$_albumsArray = $songLinkedtoAlbum->getAlbums()->getValues(); // OTHER ALBUMS THE SONG IS FEATURED IN

					foreach ($_albumsArray as $unqAlbum) {
						$albumsArrayUnqName = $unqAlbum->getName();
						$albumsArrayYear = $unqAlbum->getYear();

						$unqAlbumArtists = [];
						$albumsArrayArtists = $unqAlbum->getArtists()->getValues();
						foreach ($albumsArrayArtists as $unqAlbumArtist) {
							$unqAlbumArtists[] = $unqAlbumArtist->getName();
						}

						$albumsArray[$albumsArrayUnqName]['year'] = $albumsArrayYear;
						$albumsArray[$albumsArrayUnqName]['artists'] = $unqAlbumArtists;
					}

					$songsQueue[] =
						[
							'path' => substr($songLinkedtoAlbum->getPath(), 20),
							// 'path' => $songLinkedtoAlbum->getPath(),
							'title' => $songLinkedtoAlbum->getTitle(),
							'artists' => $artistsArray,
							'moods' => $moodNames,
							'albums' => $albumsArray,
						];
				}
			}
		}

		if ($askedYears) {
			foreach ($askedYears as $askedYear) {
				foreach ($songRepo->findBy(['year' => $askedYear]) as $_song) {

					$artistsArray = [];
					$songHasArt = $_song->getSongHasArtists(); 
					foreach ($songHasArt as $sameSongDifArtist) {
						$artistType = $sameSongDifArtist->getArtistType()->getName();
						$artistsArray[$artistType][] = $sameSongDifArtist->getArtist()->getName();
					}

					$moodNames = [];
					$mltplMoods = $_song->getMoods()->getValues();
					foreach ($mltplMoods as $unqMood) {
						$moodNames[] = $unqMood->getName();
					}

					$albumsArray = []; //ALL ALBUMS THE SONG IS IN
					$_albumsArray = $_song->getAlbums()->getValues(); // OTHER ALBUMS THE SONG IS FEATURED IN

					foreach ($_albumsArray as $unqAlbum) {
						$albumsArrayUnqName = $unqAlbum->getName();
						$albumsArrayYear = $unqAlbum->getYear();

						$unqAlbumArtists = [];
						$albumsArrayArtists = $unqAlbum->getArtists()->getValues();
						foreach ($albumsArrayArtists as $unqAlbumArtist) {
							$unqAlbumArtists[] = $unqAlbumArtist->getName();
						}

						$albumsArray[$albumsArrayUnqName]['year'] = $albumsArrayYear;
						$albumsArray[$albumsArrayUnqName]['artists'] = $unqAlbumArtists;
					}

					$songsQueue[] =
						[
							'path' => substr($_song->getPath(), 20),
							// 'path' => $songLinkedtoAlbum->getPath(),
							'title' => $_song->getTitle(),
							'artists' => $artistsArray,
							'moods' => $moodNames,
							'albums' => $albumsArray,
						];
				}
			}
		}

		$songsQueue = array_unique($songsQueue, SORT_REGULAR); // SORT REGULAR MAKES THE THING WORKS BUT WOULD BEWARE DUNNO WHAT IT DOES EXACTLY
		shuffle($songsQueue);
		// dd($songsQueue);

		$response = new Response(json_encode($songsQueue, JSON_UNESCAPED_UNICODE));
		$response->headers->set('Access-Control-Allow-Origin', '*');
		$response->headers->set('Content-Type', 'application/json');
		return $response;
	}
}
