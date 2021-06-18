<?php

namespace App\Controller;

use App\Functions\File;
use App\Entity\Album;
use App\Entity\Artist;
use App\Entity\Mood;
use App\Entity\Song;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;


class ImportController extends AbstractController
{

    private $file;
    private $em;


    function __construct(EntityManagerInterface $em, File $file)
    {
        $this->file = $file;
        $this->em = $em;
    }


    /**
     * @Route("/import/", name="import_v2")
     */
    public function index(): Response
    {

        $importDirContent = scandir('/var/www/html/public/AutomaticallyAddToBanana/');

        return $this->render('import/index.html.twig', [
            'importDirContent' => $importDirContent,
        ]);
    }


    /**
     * @Route("/import/importDir", name="import_v2_dir_view")
     */
    public function importDir(): Response
    {
        $moodRepo = $this->em->getRepository(Mood::class);
        $allExistingMoods = $moodRepo->findAll();
        $allMoodsNames = [];
        foreach ($allExistingMoods as $existingMood) {
            $allMoodsNames[] = $existingMood->getName();
        }

        // dd($allMoodsNames);

        $artistRepo = $this->em->getRepository(Artist::class);
        $allExistingArtists = $artistRepo->findAll();
        $allArtistsNames = [];
        foreach ($allExistingArtists as $existingArtist) {
            $allArtistsNames[] = $existingArtist->getName();
        }


        $albumRepo = $this->em->getRepository(Album::class);
        $allExistingAlbums = $albumRepo->findAll();
        $allAlbumsNames = [];
        foreach ($allExistingAlbums as $existingAlbum) {
            $allAlbumsNames[] = $existingAlbum->getName();
        }



        $songsInfo = $this->file->getSmartSongsInfo('/var/www/html/public/AutomaticallyAddToBanana/');
        // dd($songsInfo);

        // foreach ($this->file->listDir('/var/www/html/public/AutomaticallyAddToBanana/') as $songPath) {
        //     $noSpaceSongPath = str_replace(' ', '_', $songPath);
        //     $freshSongPath = str_replace("AutomaticallyAddToBanana/", "AutomaticallyAddedToBanana/Fresh/", $noSpaceSongPath);
        //     rename($songPath, $freshSongPath);
        // }



        return $this->render('import/import.html.twig', [
            'songsInfo' => $songsInfo,
            'allMoodsNames' => $allMoodsNames,
            'allArtistsNames' => $allArtistsNames,
            'allAlbumsNames' => $allAlbumsNames,
        ]);
    }

    /**
     * @Route("/import/doImport", name="import_v2_doing", methods="POST")
     */
    public function doImport(Request $request)
    {

        // dd($request->request->all());


        $songMoods = [];

        foreach ($request->request->all() as $songBeingImported) {
            $songMoods = $songBeingImported["mood"];
            $songTitle = $songBeingImported["title"];

            $songArtistsString = $songBeingImported["artist"];
            $songArtists  = explode("::", $songArtistsString);


            $songYear = $songBeingImported["year"];

            $songPath = $songBeingImported["path"];
            $newSongPath = str_replace("AutomaticallyAddToBanana/", "AutomaticallyAddedToBanana/", $songPath);
            // dd($newSongPath);

            // GET ALL MOODS IN DB
            $moodRepo = $this->em->getRepository(Mood::class);
            $allExistingMoods = $moodRepo->findAll();
            $allMoodsNames = [];
            foreach ($allExistingMoods as $existingMood) {
                $allMoodsNames[] = $existingMood->getName();
            }

            // CREATE MOOD ENTITY FOR UNRECCOGNIZED MOODS
            foreach ($songMoods as $songMood) {
                if (!in_array($songMood, $allMoodsNames)) {
                    $newAddedMood = new Mood();
                    $newAddedMood->setName($songMood);
                    $this->em->persist($newAddedMood);
                    $this->em->flush();
                }
            }


            // GET ALL ARTISTS IN DB
            $artistRepo = $this->em->getRepository(Artist::class);
            $allExistingArtists = $artistRepo->findAll();
            $allArtistsNames = [];
            foreach ($allExistingArtists as $existingArtist) {
                $allArtistsNames[] = $existingArtist->getName();
            }
            // CREATE ARTIST ENTITY FOR UNRECCOGNIZED ARTISTS
            foreach ($songArtists as $songArtist) {
                if (!in_array($songArtist, $allArtistsNames)) {
                    $newAddedArtist = new Artist();
                    $newAddedArtist->setName($songArtist);
                    $this->em->persist($newAddedArtist);
                    $this->em->flush();
                }
            }

            $newSong = new Song();
            $newSong->setTitle($songTitle)
                ->setYear($songYear)
                ->setPath($newSongPath);
            
            // LINKING SONG TO MOOD
            foreach ($songMoods as $songMood) {
                $addedMood = $moodRepo->findOneBy(['name' => $songMood]);
                $newSong->addMood($addedMood);
            }

            // LINKING SONG TO ARTIST
            foreach ($songArtists as $songArtist) {
                $addedSongArtist = $artistRepo->findOneBy(['name' => $songArtist]);
                $newSong->addArtist($addedSongArtist);
            }

            $this->em->persist($newSong);
            rename($songPath, $newSongPath);
        }

        $this->em->flush();

        return $this->render('import/importDone.html.twig', [
            // 'importDirContent' => $importDirContent,
        ]);
    }
}
