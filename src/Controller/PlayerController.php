<?php

namespace App\Controller;

use App\Entity\Mood;
use App\Entity\Song;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PlayerController extends AbstractController
{

	function __construct(EntityManagerInterface $em)
	{
		$this->em = $em;
	}

	/**
	 * @Route("/player", name="player_test")
	 */
	public function index(Request $request): Response
	{
		$askedQuery = $request->query->all();
		$songRepo = $this->em->getRepository(Song::class);
		$moodRepo = $this->em->getRepository(Mood::class);
		// dd($askedQuery);

		$askedMoods = array_key_exists('mood', $askedQuery) ? $askedQuery['mood'] : null;
		$askedArtists = array_key_exists('artist', $askedQuery) ? $askedQuery['artist'] : null;



		$songsPaths = [];

		foreach ($askedArtists as $askedArtist)
		{
			foreach($songRepo->findBy(['artist' => $askedArtist]) as $_song)
			{
				$songsPaths[] = $_song->getPath();
			}
		}


		// foreach ($askedMoods as $askedMood){
		
		// 	foreach($moodRepo->findBy(['mood' => $askedArtist]) as $_song){

		// 		$songsPaths[] = $_song->getPath();

		// 	}
		// }

		dd($songsPaths);


		return $this->render('player/index.html.twig', [
			'controller_name' => 'PlayerController',
			// 'playlistMoods' => $askedMoods,
			// 'playlistArtists' => $askedArtists,
		]);
	}
}
