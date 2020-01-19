<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

// Include the Tesseract Wrapper
use TesseractOCR;

class DefaultController extends Controller\AbstractController
{
    public function status()
    {
        return new Response("ok", 200);
    }

    public function image(
        string $kernelProjectDir,
        Request $request
    )
    {
        $webPath = $kernelProjectDir;
        // The filename of the image is text.jpeg and is located inside the web folder

        $upLoadedImage = $request->files->get('image');
        if (!$upLoadedImage || !$upLoadedImage->isValid())
        {
            $filepath = $webPath . '/public/1_klTODXvF6Zjh3SRpOdIpbA.png';
        } else {
            $filepath = $upLoadedImage->getPathname();
        }

        // Is useful to verify if the file exists, because the tesseract wrapper
        // will throw an error but without description
        if (!file_exists($filepath)) {
            $filepath = $webPath . '/public/1_klTODXvF6Zjh3SRpOdIpbA.png';
        }

        // Create a  new instance of tesseract and provide as first parameter
        // the local path of the image
        $tesseractInstance = new TesseractOCR($filepath);

        // Execute tesseract to recognize text
        $result = $tesseractInstance->run();

        // Return the recognized text as response (expected: The quick brown fox jumps over the lazy dog.)
        return new Response($result);
    }
}
