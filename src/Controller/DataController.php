<?php

namespace App\Controller;

use App\Entity\Album;
use App\Entity\Artist;
use App\Entity\ArtistType;
use App\Entity\Mood;
use App\Entity\Song;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;


class DataController extends AbstractController
{

    function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }


    /**
     * @Route("/info/get", name="dataGet", methods={"GET", "POST"})
     */
    public function getInfo(Request $request): Response
    {

        $songRepo = $this->em->getRepository(Song::class);
        $moodRepo = $this->em->getRepository(Mood::class);
        $artistRepo = $this->em->getRepository(Artist::class);
        $albumRepo = $this->em->getRepository(Album::class);


        $askedQuery = $request->query->all();
        // dd($askedQuery);

        $askedMood = array_key_exists('mood', $askedQuery) ? $askedQuery['mood'] : null;
        $askedArtist = array_key_exists('artist', $askedQuery) ? $askedQuery['artist'] : null;
        $askedAlbum = array_key_exists('album', $askedQuery) ? $askedQuery['album'] : null;
        $askedSong = array_key_exists('song', $askedQuery) ? $askedQuery['song'] : null;
        // dd($askedSong);

        if ($askedSong) {
            $songInfo = [];

            $_askedSong = $songRepo->findOneBy(['id' => $askedSong]);
            // dd($_askedSong);

            $artistsArray = [];
            $songHasArt = $_askedSong->getSongHasArtists();
            foreach ($songHasArt as $sameSongDifArtist) {
                $artistType = $sameSongDifArtist->getArtistType()->getName();
                $artistsArray[$artistType][] = $sameSongDifArtist->getArtist()->getName();
            }

            $moodNames = [];
            $mltplMoods = $_askedSong->getMoods()->getValues();
            foreach ($mltplMoods as $unqMood) {
                $moodNames[] = $unqMood->getName();
            }

            $albumsArray = []; //ALL ALBUMS THE SONG IS IN
            $_albumsArray = $_askedSong->getAlbums()->getValues(); // OTHER ALBUMS THE SONG IS FEATURED IN

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

            $songInfo[] =
                [
                    'id' => $_askedSong->getId(),
                    'path' => substr($_askedSong->getPath(), 20),
                    // 'path' => $_askedSong->getPath(),
                    'title' => $_askedSong->getTitle(),
                    'artists' => $artistsArray,
                    'moods' => $moodNames,
                    'albums' => $albumsArray,
                ];

            // dd($songInfo);
        }




        $response = new Response(json_encode($songInfo, JSON_UNESCAPED_UNICODE));
        $response->headers->set('Access-Control-Allow-Origin', '*');
        $response->headers->set('Content-Type', 'application/json');
        return $response;
    }

    /**
     * @Route("/info/create", name="dataCreate", methods={"GET", "POST"})
     */
    public function insertInfo(Request $request): Response
    {

        $askedQuery = $request->query->all();
        dd($askedQuery);




        $response = new Response(json_encode($askedQuery, JSON_UNESCAPED_UNICODE));
        $response->headers->set('Access-Control-Allow-Origin', '*');
        $response->headers->set('Content-Type', 'application/json');
        return $response;
    }

    /**
     * @Route("/info/relations", name="relationRroute")
     */
    public function getRelation(): Response
    {

        $moodRepo = $this->em->getRepository(Mood::class);
        $allExistingMoods = $moodRepo->findAll();
        $allMoodsNames = [];
        foreach ($allExistingMoods as $existingMood) {
            $allMoodsNames[] = $existingMood->getName();
        }
        // dd($allMoodsNames);

        $artistTypesRepo = $this->em->getRepository(ArtistType::class);
        $allExistingArtistTypes = $artistTypesRepo->findAll();
        $allArtistTypes = [];
        foreach ($allExistingArtistTypes as $existingArtistType) {
            $allArtistsTypes[] = $existingArtistType->getName();
        }
        // dd($allArtistsTypes);
        $relations = [];
        $relations['moods'] = $allMoodsNames;
        $relations['artistTypes'] = $allArtistsTypes;

        $json = $relations;



        $response = new Response(json_encode($json, JSON_UNESCAPED_UNICODE));
        $response->headers->set('Access-Control-Allow-Origin', '*');
        $response->headers->set('Content-Type', 'application/json');
        return $response;    }
}
