<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use \RecursiveDirectoryIterator;
use \RecursiveIteratorIterator;

class Image extends Model
{

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

}
