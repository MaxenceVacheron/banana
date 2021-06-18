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

		urlencode('vriw');

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

		// dd($albumsArray);



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
				// dd($songsLinkedtoMood);
				foreach ($songsLinkedtoMood as $songLinkedtoMood) {

					// dd($songLinkedtoMood->getArtist()->getValues());
					// dd($songLinkedtoMood->getArtist()->getValues()[0]->getName()); // "Alpha Wann"

					$mltplArtists = $songLinkedtoMood->getArtist()->getValues();
					$artistNames = [];

					foreach ($mltplArtists as $unqArtist){
						$artistNames[] = $unqArtist->getName();
					}

					$songsQueue[] =
						[
							'path' => substr($songLinkedtoMood->getPath(), 20),
							// 'path' => $songLinkedtoMood->getPath(),
							'title' => $songLinkedtoMood->getTitle(),
							'artists' => $artistNames,
							'album' => $songLinkedtoMood->getAlbums(),
						];
				}
			}
			// dd($songsQueue);
		}

		if ($askedArtists) {
			foreach ($askedArtists as $askedArtist) {
				$_askedArtist = $artistRepo->findOneBy(['name' => $askedArtist]);
				// dd($askedArtist);
				$songsLinkedtoArtist = $_askedArtist->getSongs()->getValues();
				// dd($songsLinkedtoArtist);
				foreach ($songsLinkedtoArtist as $songLinkedtoArtist) {

					// dd($songLinkedtoMood->getArtist()->getValues());
					// dd($songLinkedtoMood->getArtist()->getValues()[0]->getName()); // "Alpha Wann"

					$mltplArtists = $songLinkedtoArtist->getArtist()->getValues();
					$artistNames = [];

					foreach ($mltplArtists as $unqArtist){
						$artistNames[] = $unqArtist->getName();
					}

					$songsQueue[] =
						[
							'path' => substr($songLinkedtoArtist->getPath(), 20),
							// 'path' => $songLinkedtoMood->getPath(),
							'title' => $songLinkedtoArtist->getTitle(),
							'artists' => $artistNames,
							'album' => $songLinkedtoArtist->getAlbums(),
						];
				}
			}
		}

		if ($askedAlbums) {
			foreach ($askedAlbums as $askedAlbum) {

				$_askedAlbum = $albumRepo->findOneBy(['name' => $askedAlbum]);
				$songsLinkedtoAlbum = $_askedAlbum->getSongs()->getValues();
				// dd($songsLinkedtoMood);
				foreach ($songsLinkedtoAlbum as $songLinkedtoAlbum) {

					// dd($songLinkedtoMood->getArtist()->getValues());
					// dd($songLinkedtoMood->getArtist()->getValues()[0]->getName()); // "Alpha Wann"

					$mltplArtists = $songLinkedtoAlbum->getArtist()->getValues();
					$artistNames = [];
					foreach ($mltplArtists as $unqArtist){
						$artistNames[] = $unqArtist->getName();
					}

					$songsQueue[] =
						[
							'path' => substr($songLinkedtoAlbum->getPath(), 20),
							// 'path' => $songLinkedtoMood->getPath(),
							'title' => $songLinkedtoAlbum->getTitle(),
							'artists' => $artistNames,
							'album' => $songLinkedtoAlbum->getAlbums(),
						];
				}
			}
		}

		if ($askedYears) {
			foreach ($askedYears as $askedYear) {
				foreach ($songRepo->findBy(['year' => $askedYear]) as $_song) {
					$songsQueue[] =
						[
							'path' => substr($_song->getPath(), 20),
							'title' => $_song->getTitle(),
							'artists' => $_song->getArtist(),
							'album' => $_song->getAlbums(),
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
