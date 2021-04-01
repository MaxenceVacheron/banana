<?php

namespace App\Controller;

use App\Entity\Song;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Doctrine\ORM\EntityManagerInterface;
use App\Functions\File;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;


class ImportV2Controller extends AbstractController
{

    private $file;
    private $em;


    function __construct(EntityManagerInterface $em, File $file)
    {
        $this->file=$file;
        $this->em=$em;
    }


    /**
     * @Route("/import/v2/", name="import_v2")
     */
    public function index(): Response
    {

        $importDirContent = scandir('../AutomaticallyAddToBanana/');

        return $this->render('import_v2/index.html.twig', [
            'importDirContent' => $importDirContent,
        ]);
    }


    /**
     * @Route("/import/v2/importDir", name="import_v2_dir_view")
     */
    public function importDir(): Response
    {
        foreach ($this->file->listDir('../AutomaticallyAddToBanana/') as $songPath)
        {
            $newSongPath = str_replace("AutomaticallyAddToBanana/", "AutomaticallyAddedToBanana/Fresh/", $songPath); 
            rename ($songPath, $newSongPath);
        }

        $songsInfo = $this->file->getSongsInfo('../AutomaticallyAddedToBanana/Fresh/');

        return $this->render('import_v2/import.html.twig', [
            'songsInfo' => $songsInfo,
        ]);
    }

    /**
     * @Route("/import/v2/doImport", name="import_v2_doing", methods="POST")
     */
    public function doImport(Request $request )
    {

        foreach ($request->request->all() as $songBeingImported) 
        {

            $songTitle = $songBeingImported["title"];
            $songArtist = $songBeingImported["artist"];
            $songYear = $songBeingImported["year"];

            $songPathFresh = $songBeingImported["path"];
            $newSongPath = str_replace("AutomaticallyAddedToBanana/Fresh/", "AutomaticallyAddedToBanana/", $songPathFresh); 
            rename ($songPathFresh, $newSongPath);
       
            $newSong = new Song();
            $newSong->setTitle($songTitle)
                ->setArtist($songArtist)
                ->setYear($songYear)
                ->setPath($newSongPath);
            $this->em->persist($newSong);
            $this->em->flush();
        }

        return $this->render('import_v2/importDone.html.twig', [
            // 'importDirContent' => $importDirContent,
            // 'songsInfo' => $songsInfo,
        ]);

    }

}
