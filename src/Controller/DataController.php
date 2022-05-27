<?php

namespace App\Controller;

use App\Functions\File;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class DataController extends AbstractController
{
    private $file;
    private $em;


    function __construct(EntityManagerInterface $em, File $file)
    {
        $this->file = $file;
        $this->em = $em;

        $moodRepo = $em->getRepository(Mood::class);
        $allExistingMoods = $moodRepo->findAll();
        $allMoodsNames = [];
        foreach ($allExistingMoods as $existingMood) {
            $allMoodsNames[] = $existingMood->getName();
        }
    }


    // RETURNS ALL MOODS, ARTISTS AND ARTIST TYPES.
    #[Route('/data', name: 'app_data')]
    public function index(): JsonResponse
    {
        dd($this->allMoodsNames);
        return $this->json([
            'message' => 'Welcome to your new controller!',
            'path' => 'src/Controller/DataController.php',
        ]);
    }
    // ALLOWS TO IMPORTS SONGS FROM DIRECTORY.
    // #[Route('/data/import', name: 'import')]
    // public function import(): JsonResponse
    // {
    //     return $this->json([
    //         'message' => 'Welcome to your new controller!',
    //         'path' => 'src/Controller/DataController.php',
    //     ]);
    // }

    // ALLOWS TO INSERT A MOOD IN DB.
    // #[Route('/data/new/mood', name: 'new_mood')]
    // public function newMood(): JsonResponse
    // {
    //     return $this->json([
    //         'message' => 'Welcome to your new controller!',
    //         'path' => 'src/Controller/DataController.php',
    //     ]);
    // }

    // ALLOWS TO EDIT A SONG OBJECT.
    // #[Route('/data/song/edit', name: 'song_edit')]
    // public function editSong(): JsonResponse
    // {
    //     return $this->json([
    //         'message' => 'Welcome to your new controller!',
    //         'path' => 'src/Controller/DataController.php',
    //     ]);
    // }
    
}
