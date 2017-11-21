<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use \RecursiveDirectoryIterator;
use \RecursiveIteratorIterator;

class Image extends Model
{

    const BEARBEITET = '_bearbeitet';

    protected $fillable = ['path'];

    /**
     * Scans the given directory recursively for new images and
     * stores them in the DB.
     *
     * @param string $directory
     * @return void
     */
    public static function scan(string $directory)
    {
        /** @var integer */
        $counter = 0;
        /** @var RecursiveIteratorIterator */
        $it = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($directory));

        $it->rewind();
        while ($it->valid()) {
            if (!$it->isDot()) {
                $path = $it->key();
                $pics = Image::firstOrCreate(['path' => $path]);
                if ($pics->wasRecentlyCreated) {
                    $counter++;
                }
            }

            $it->next();
        }

        return $counter;
    }

    /**
     * Finds a random image from the DB and marks it as used.
     *
     * The one with used=true and the latest updated_at field is
     * the current image to show.
     *
     * @return Image
     */
    public static function next()
    {
        /** @var Image */
        $image = Image::where('path', 'not like', '%' . self::BEARBEITET . '%')
            ->where('used', false)
            ->get()
            ->random();

        $image->used = true;
        $image->save();

        // is there a _bearbeitet version?
        /** @var string */
        $pathWithBearbeitet = str_replace('.', self::BEARBEITET . '.', $image->path);
        /** @var Image */
        $imageWith = Image::where('path', $pathWithBearbeitet)
            ->get()
            ->first();

        if ($imageWith) {
            $imageWith->used = true;
            // make sure the bearbeitet version is the latest
            sleep(1);
            $imageWith->save();
            $image = $imageWith;
        }

        return $image;

    }

}
