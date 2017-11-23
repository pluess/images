<?php

namespace App\Http\Controllers;

use App\Image;
use App\Utils\SocketIoUtil;

class AdminController extends Controller
{
    /**
     * Loads the paged images for the admin controller.
     *
     * @return mixed
     */
    public function admin()
    {
        $images = Image::where('used', true)
            ->orderBy('updated_at', 'DESC')
            ->paginate(10);

        return view('admin', ['images' => $images]);
    }

    /**
     * Prepares the next image and notitys listener
     * about it.
     *
     * @return void
     */
    public function next()
    {
        $pics = Image::next();
        SocketIoUtil::notifyNextImage();
    }

}
