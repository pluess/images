<?php

namespace App\Http\Controllers;

use App\Image;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

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
        $image = Image::where('used', true)
            ->orderBy('updated_at', 'DESC')
            ->first();

        /** @var BinaryFileResponse */
        $response = new BinaryFileResponse($image->path, 200, [], true, null, true);

        // modify headers to disable any kind of caching
        $response->headers->addCacheControlDirective('no-cache', true);
        $response->headers->addCacheControlDirective('max-age', 0);
        $response->headers->addCacheControlDirective('must-revalidate', true);
        $response->headers->addCacheControlDirective('no-store', true);

        return $response;

    }

    /**
     * Returns an image by id. Since this returns the same image per id for
     * every call ETag support is switched on to support browser caching.
     *
     * @param int $id
     * @return BinaryFileResponse
     */
    public function image(int $id)
    {
        /** @var Image */
        $image = Image::where('id', '=', $id)
            ->get()
            ->first();

        /** @var BinaryFileResponse */
        $response = new BinaryFileResponse($image->path, 200, array(), true, null, true);
        return $response;
    }
}
