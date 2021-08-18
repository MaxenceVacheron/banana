<?php

namespace App\Controller;

use App\Entity\Album;
use App\Entity\Artist;
use App\Entity\ArtistType;
use App\Entity\Mood;
use App\Entity\Song;
use App\Entity\SongHasArtist;
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

        $askedMood = array_key_exists('mood', $askedQuery) ? $askedQuery['mood'] : null; //IMPLEMENT THIS EVERYWHERE
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
                    'year' => $_askedSong->getYear(),
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
    public function insertInfo(Request $request)
    {

        $songRepo = $this->em->getRepository(Song::class);

        $songBeingImported = $request->query->all();
        // dd($songBeingImported);

        $songId = $songBeingImported["id"];
        // $songMoods = $songBeingImported["mood"];
        $songMoods = array_key_exists('mood', $songBeingImported) ? $songBeingImported['mood'] : ['music']; //IMPLEMENT THIS EVERYWHERE
        $songTitle = $songBeingImported["title"];
        $songArtistsArray = $songBeingImported["artists"];
        $songYear = $songBeingImported["year"];
        // dd($songMoods);

        // $songPath = $songBeingImported["path"];
        // $newSongPath = str_replace("AutomaticallyAddToBanana/", "AutomaticallyAddedToBanana/", $songPath);
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
                // dd($songMood);
                $newAddedMood = new Mood();
                $newAddedMood->setName($songMood);
                $this->em->persist($newAddedMood);
                $this->em->flush();
            }
        }

        // GET ALL TYPE OF ARTIST IN DB
        $artistTypeRepo = $this->em->getRepository(ArtistType::class);
        $allExistingArtistTypes = $artistTypeRepo->findAll();
        $allExistingArtistTypesNames = [];
        foreach ($allExistingArtistTypes as $allExistingArtistType) {
            $allExistingArtistTypesNames[] = $allExistingArtistType->getName();
        }

        // GET ALL ARTISTS IN DB
        $artistRepo = $this->em->getRepository(Artist::class);
        $allExistingArtists = $artistRepo->findAll();
        $allArtistsNames = [];
        foreach ($allExistingArtists as $existingArtist) {
            $allArtistsNames[] = $existingArtist->getName();
        }
        // CREATE ARTIST ENTITY FOR UNRECCOGNIZED ARTISTS
        foreach ($songArtistsArray as $typeArrayOfArtist) {
            foreach ($typeArrayOfArtist as $songArtist) {
                if (!in_array($songArtist, $allArtistsNames)) {
                    $newAddedArtist = new Artist();
                    $newAddedArtist->setName($songArtist);
                    $this->em->persist($newAddedArtist);
                    $this->em->flush();
                }
            }
        }

        $newSong = $songRepo->findBy(['id' => $songId])[0];
        // dd($newSong);
        $newSong->setTitle($songTitle)
            ->setYear($songYear);

        // LINKING SONG TO MOOD
        foreach ($songMoods as $songMood) {
            $addedMood = $moodRepo->findOneBy(['name' => $songMood]);
            $newSong->addMood($addedMood);
        }

        // // LINKING SONG TO ARTIST
        // foreach ($songArtistsArray as $typeArrayOfArtist) {
        //     foreach ($typeArrayOfArtist as $songArtist) {
        //         $addedSongArtist = $artistRepo->findOneBy(['name' => $songArtist]);
        //         $newSong->addArtist($addedSongArtist);
        //     }
        // }

        // dd(array_keys($songArtistsArray)); // main, feat, sample, og, back...

        $submitedTypesOfArtists = array_keys($songArtistsArray);

        foreach ($submitedTypesOfArtists as $submitedTypeOfArtists) {
            foreach ($songArtistsArray[$submitedTypeOfArtists] as $artist) {


                $addedSongArtist = $artistRepo->findOneBy(['name' => $artist]);
                $addedType = $artistTypeRepo->findOneBy(['name' => $submitedTypeOfArtists]);
                $alreadyExistingArtistRelations = $newSong->getSongHasArtists();
                foreach ($alreadyExistingArtistRelations as $alreadyExistingArtistRelationUnq) {
                    $unqExistingRelationArtist = $alreadyExistingArtistRelationUnq->getArtist()->getName();
                    $unqExistingRelationArtistType = $alreadyExistingArtistRelationUnq->getArtistType()->getName();
                    // dd($unqExistingRelationArtistType);
                    // dd($unqExistingRelationArtist);
                    if (!($unqExistingRelationArtist = $addedSongArtist && $unqExistingRelationArtistType = $addedType)) {
                        //if if not hte same relation (ie same artist with same artist type (ex: JJ is main and prod))
                        $songArtistRelation = new SongHasArtist();
                        $songArtistRelation->setSong($newSong)
                            ->setArtist($addedSongArtist)
                            ->setArtistType($addedType);
                        $this->em->persist($songArtistRelation);
                        $status = [];
                        $status[] = 'OK';
                    } else {
                        $status = [];
                        $status = '{Error : Artist & type already exist for this song}';
                    }
                }
            }
        }

        $this->em->persist($newSong);
        $this->em->flush();

        $response = new Response(json_encode($status, JSON_UNESCAPED_UNICODE));
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
        return $response;
    }

    /**
     * @Route("/info/link/mood", name="addMood", methods={"GET", "POST"})
     */
    public function addMoodLink(Request $request)
    {

        $songRepo = $this->em->getRepository(Song::class);

        $songBeingImported = $request->query->all();
        // dd($songBeingImported);

        $songId = $songBeingImported["id"];
        // $songMoods = $songBeingImported["mood"];
        $songMoods = array_key_exists('mood', $songBeingImported) ? $songBeingImported['mood'] : ['music']; //IMPLEMENT THIS EVERYWHERE
        // $songTitle = $songBeingImported["title"];
        // $songArtistsArray = $songBeingImported["artists"];
        // $songYear = $songBeingImported["year"];
        // dd($songMoods);

        // $songPath = $songBeingImported["path"];
        // $newSongPath = str_replace("AutomaticallyAddToBanana/", "AutomaticallyAddedToBanana/", $songPath);
        // dd($newSongPath);
        // dd($songMoods);
        // GET ALL MOODS IN DB
        $moodRepo = $this->em->getRepository(Mood::class);
        $allExistingMoods = $moodRepo->findAll();
        $allMoodsNames = [];
        foreach ($allExistingMoods as $existingMood) {
            $allMoodsNames[] = $existingMood->getName();
        }

        // CREATE MOOD ENTITY FOR UNRECCOGNIZED MOODS
            if (!in_array($songMoods, $allMoodsNames)) {
                // dd($songMood);
                $newAddedMood = new Mood();
                $newAddedMood->setName($songMoods);
                $this->em->persist($newAddedMood);
                $this->em->flush();
            }

        // // GET ALL TYPE OF ARTIST IN DB
        // $artistTypeRepo = $this->em->getRepository(ArtistType::class);
        // $allExistingArtistTypes = $artistTypeRepo->findAll();
        // $allExistingArtistTypesNames = [];
        // foreach ($allExistingArtistTypes as $allExistingArtistType) {
        //     $allExistingArtistTypesNames[] = $allExistingArtistType->getName();
        // }

        // // GET ALL ARTISTS IN DB
        // $artistRepo = $this->em->getRepository(Artist::class);
        // $allExistingArtists = $artistRepo->findAll();
        // $allArtistsNames = [];
        // foreach ($allExistingArtists as $existingArtist) {
        //     $allArtistsNames[] = $existingArtist->getName();
        // }
        // // CREATE ARTIST ENTITY FOR UNRECCOGNIZED ARTISTS
        // foreach ($songArtistsArray as $typeArrayOfArtist) {
        //     foreach ($typeArrayOfArtist as $songArtist) {
        //         if (!in_array($songArtist, $allArtistsNames)) {
        //             $newAddedArtist = new Artist();
        //             $newAddedArtist->setName($songArtist);
        //             $this->em->persist($newAddedArtist);
        //             $this->em->flush();
        //         }
        //     }
        // }

        $newSong = $songRepo->findBy(['id' => $songId])[0];
        // dd($newSong);
        // $newSong->setTitle($songTitle)
        //     ->setYear($songYear);

        // LINKING SONG TO MOOD
            $addedMood = $moodRepo->findOneBy(['name' => $songMoods]);
            $newSong->addMood($addedMood);

        // // LINKING SONG TO ARTIST
        // foreach ($songArtistsArray as $typeArrayOfArtist) {
        //     foreach ($typeArrayOfArtist as $songArtist) {
        //         $addedSongArtist = $artistRepo->findOneBy(['name' => $songArtist]);
        //         $newSong->addArtist($addedSongArtist);
        //     }
        // }

        // dd(array_keys($songArtistsArray)); // main, feat, sample, og, back...

        // $submitedTypesOfArtists = array_keys($songArtistsArray);

        // foreach ($submitedTypesOfArtists as $submitedTypeOfArtists) {
        //     foreach ($songArtistsArray[$submitedTypeOfArtists] as $artist) {


        //         $addedSongArtist = $artistRepo->findOneBy(['name' => $artist]);
        //         $addedType = $artistTypeRepo->findOneBy(['name' => $submitedTypeOfArtists]);
        //         $alreadyExistingArtistRelations = $newSong->getSongHasArtists();
        //         foreach ($alreadyExistingArtistRelations as $alreadyExistingArtistRelationUnq) {
        //             $unqExistingRelationArtist = $alreadyExistingArtistRelationUnq->getArtist()->getName();
        //             $unqExistingRelationArtistType = $alreadyExistingArtistRelationUnq->getArtistType()->getName();
        //             // dd($unqExistingRelationArtistType);
        //             // dd($unqExistingRelationArtist);
        //             if (!($unqExistingRelationArtist = $addedSongArtist && $unqExistingRelationArtistType = $addedType)) {
        //                 //if if not hte same relation (ie same artist with same artist type (ex: JJ is main and prod))
        //                 $songArtistRelation = new SongHasArtist();
        //                 $songArtistRelation->setSong($newSong)
        //                     ->setArtist($addedSongArtist)
        //                     ->setArtistType($addedType);
        //                 $this->em->persist($songArtistRelation);
                        $status = [];
                        $status[] = 'OK';
        //             } else {
        //                 $status = [];
        //                 $status = '{Error : Artist & type already exist for this song}';
        //             }
        //         }
        //     }
        // }

        $this->em->persist($newSong);
        $this->em->flush();

        $response = new Response(json_encode($status, JSON_UNESCAPED_UNICODE));
        $response->headers->set('Access-Control-Allow-Origin', '*');
        $response->headers->set('Content-Type', 'application/json');
        return $response;
    }

        /**
     * @Route("/info/unlink/mood", name="remMood", methods={"GET", "POST"})
     */
    public function remMoodLink(Request $request)
    {

        $songRepo = $this->em->getRepository(Song::class);

        $songBeingImported = $request->query->all();
        // dd($songBeingImported);

        $songId = $songBeingImported["id"];
        // $songMoods = $songBeingImported["mood"];
        $songMoods = array_key_exists('mood', $songBeingImported) ? $songBeingImported['mood'] : ['music']; //IMPLEMENT THIS EVERYWHERE
        // $songTitle = $songBeingImported["title"];
        // $songArtistsArray = $songBeingImported["artists"];
        // $songYear = $songBeingImported["year"];
        // dd($songMoods);

        // $songPath = $songBeingImported["path"];
        // $newSongPath = str_replace("AutomaticallyAddToBanana/", "AutomaticallyAddedToBanana/", $songPath);
        // dd($newSongPath);
        // dd($songMoods);
        // GET ALL MOODS IN DB
        $moodRepo = $this->em->getRepository(Mood::class);
        $allExistingMoods = $moodRepo->findAll();
        $allMoodsNames = [];
        foreach ($allExistingMoods as $existingMood) {
            $allMoodsNames[] = $existingMood->getName();
        }

        // CREATE MOOD ENTITY FOR UNRECCOGNIZED MOODS
            if (!in_array($songMoods, $allMoodsNames)) {
                // dd($songMood);
                $newAddedMood = new Mood();
                $newAddedMood->setName($songMoods);
                $this->em->persist($newAddedMood);
                $this->em->flush();
            }

        // // GET ALL TYPE OF ARTIST IN DB
        // $artistTypeRepo = $this->em->getRepository(ArtistType::class);
        // $allExistingArtistTypes = $artistTypeRepo->findAll();
        // $allExistingArtistTypesNames = [];
        // foreach ($allExistingArtistTypes as $allExistingArtistType) {
        //     $allExistingArtistTypesNames[] = $allExistingArtistType->getName();
        // }

        // // GET ALL ARTISTS IN DB
        // $artistRepo = $this->em->getRepository(Artist::class);
        // $allExistingArtists = $artistRepo->findAll();
        // $allArtistsNames = [];
        // foreach ($allExistingArtists as $existingArtist) {
        //     $allArtistsNames[] = $existingArtist->getName();
        // }
        // // CREATE ARTIST ENTITY FOR UNRECCOGNIZED ARTISTS
        // foreach ($songArtistsArray as $typeArrayOfArtist) {
        //     foreach ($typeArrayOfArtist as $songArtist) {
        //         if (!in_array($songArtist, $allArtistsNames)) {
        //             $newAddedArtist = new Artist();
        //             $newAddedArtist->setName($songArtist);
        //             $this->em->persist($newAddedArtist);
        //             $this->em->flush();
        //         }
        //     }
        // }

        $newSong = $songRepo->findBy(['id' => $songId])[0];
        // dd($newSong);
        // $newSong->setTitle($songTitle)
        //     ->setYear($songYear);

        // LINKING SONG TO MOOD
            $addedMood = $moodRepo->findOneBy(['name' => $songMoods]);
            $newSong->removeMood($addedMood);

        // // LINKING SONG TO ARTIST
        // foreach ($songArtistsArray as $typeArrayOfArtist) {
        //     foreach ($typeArrayOfArtist as $songArtist) {
        //         $addedSongArtist = $artistRepo->findOneBy(['name' => $songArtist]);
        //         $newSong->addArtist($addedSongArtist);
        //     }
        // }

        // dd(array_keys($songArtistsArray)); // main, feat, sample, og, back...

        // $submitedTypesOfArtists = array_keys($songArtistsArray);

        // foreach ($submitedTypesOfArtists as $submitedTypeOfArtists) {
        //     foreach ($songArtistsArray[$submitedTypeOfArtists] as $artist) {


        //         $addedSongArtist = $artistRepo->findOneBy(['name' => $artist]);
        //         $addedType = $artistTypeRepo->findOneBy(['name' => $submitedTypeOfArtists]);
        //         $alreadyExistingArtistRelations = $newSong->getSongHasArtists();
        //         foreach ($alreadyExistingArtistRelations as $alreadyExistingArtistRelationUnq) {
        //             $unqExistingRelationArtist = $alreadyExistingArtistRelationUnq->getArtist()->getName();
        //             $unqExistingRelationArtistType = $alreadyExistingArtistRelationUnq->getArtistType()->getName();
        //             // dd($unqExistingRelationArtistType);
        //             // dd($unqExistingRelationArtist);
        //             if (!($unqExistingRelationArtist = $addedSongArtist && $unqExistingRelationArtistType = $addedType)) {
        //                 //if if not hte same relation (ie same artist with same artist type (ex: JJ is main and prod))
        //                 $songArtistRelation = new SongHasArtist();
        //                 $songArtistRelation->setSong($newSong)
        //                     ->setArtist($addedSongArtist)
        //                     ->setArtistType($addedType);
        //                 $this->em->persist($songArtistRelation);
                        $status = [];
                        $status[] = 'OK';
        //             } else {
        //                 $status = [];
        //                 $status = '{Error : Artist & type already exist for this song}';
        //             }
        //         }
        //     }
        // }

        $this->em->persist($newSong);
        $this->em->flush();

        $response = new Response(json_encode($status, JSON_UNESCAPED_UNICODE));
        $response->headers->set('Access-Control-Allow-Origin', '*');
        $response->headers->set('Content-Type', 'application/json');
        return $response;
    }

}
