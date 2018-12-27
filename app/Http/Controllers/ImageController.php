<?php

namespace App\Http\Controllers;

use App\Image;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use \PHPExif\Reader\Reader;
use Illuminate\Support\Facades\Log;

class ImageController extends Controller
{


        /**
     * Returns the current image. Since this image may be different
     * for every call, all browser image caching headers are swichted off.
     *
     * @return BinaryFileResponse
     */
    public function current()
    {
        /** @var Image */
        $dbImage = Image::where('used', true)
            ->orderBy('updated_at', 'DESC')
            ->first();

        $rotatedImage = $this->rotate($dbImage->path);

        // Generate response
        $response = new Response();

        // Set headers, avoid caching
        $response->headers->set('Content-type', 'image/jpeg');
        $response->headers->set('Cache-Control', 'no-cache, no-store, must-revalidate');

        // Send headers before outputting anything
        $response->sendHeaders();

        imagejpeg($rotatedImage);

        return $response;

    }

    /**
     * Returns an image by id. Since this returns the same image per id for
     * every call ETag support is switched on to support browser caching.
     *
     * @param int $id
     * @return BinaryFileResponse
     */
    public function image(Request $request, int $id)
    {
        /** @var Image */
        $dbImage = Image::where('id', '=', $id)
            ->get()
            ->first();

        $lastModifiedTime = (new \DateTime())->setTimestamp(filemtime($dbImage->path)); 
        $eTag = md5_file($dbImage->path);

        // No need to rotate and send the file again
        // if we get the same ETag
        $requestETag = $request->getETags();
        if (!empty($requestETag)) {
            Log::debug($dbImage->path . ', eTag='. $eTag . ', reqeuestETag=' . $requestETag[0]);
            if ($eTag===$requestETag[0]) {
                $response = new Response();
                $response->setNotModified();
                Log::debug("Valid ETag detected, return 304.");
                return $response;
            }
        }

        $rotatedImage = $this->rotate($dbImage->path);

        // Set headers
        $response = new Response();
        $response->headers->set('Content-type', 'image/jpeg');
        $response->headers->set('Content-Disposition', 'attachment; filename="' . $dbImage->path . '";');
        $response->setEtag($eTag);
        $response->setLastModified($lastModifiedTime);
        $response->setPublic(true);
        
        // Send headers before outputting anything
        $response->sendHeaders();

        imagejpeg($rotatedImage);

        return $response;
    }

    private function rotate(string $imagePath) {
        $reader = Reader::factory(Reader::TYPE_NATIVE);
        $exif = $reader->read($imagePath);

        Log::debug($imagePath . ' orientation=' . $exif->getOrientation());

        $image = imagecreatefromstring( file_get_contents($imagePath));
        switch($exif->getOrientation()) {
            case 6:
                $rotatedImage = imagerotate($image, 270, 0);
                break;
            case 8:
                $rotatedImage = imagerotate($image, 90, 0);
                break;
            default:
                $rotatedImage = $image;
        }

        return $rotatedImage;
    }

}
