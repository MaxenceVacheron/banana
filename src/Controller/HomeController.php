<?php

namespace App\Controller;

use App\Entity\Artist;
use App\Entity\Mood;
use App\Entity\Song;
use App\Functions\File;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{


	function __construct(EntityManagerInterface $em, File $file)
	{
		$this->file = $file;
		$this->em = $em;
	}


	/**
	 * @Route("/", name="home")
	 */
	public function index(): Response
	{

		$moodRepo = $this->em->getRepository(Mood::class);
		$moods = $moodRepo->findAll();
		$moodsArray = [];
		foreach ($moods as $mood) {
			$moodsArray[] = $mood->getName();
		}


		$songRepo = $this->em->getRepository(Song::class);
		$songs = $songRepo->findAll();
		$artistsArray = [];
		$yearsArray = [];
		foreach ($songs as $song) {
			$yearsArray[] = $song->getYear();
		}

		$artistRepo = $this->em->getRepository(Artist::class);
		$artists = $artistRepo->findAll();
		$artistsArray = [];
		foreach ($artists as $artist) {
			$artistsArray[] = $artist->getName();
		}



		return $this->render('home/index.html.twig', [
			'controller_name' => 'HomeController',
			'moods' => $moodsArray,
			'artists' => $artistsArray,
			'years' => $yearsArray,
		]);
	}
}
