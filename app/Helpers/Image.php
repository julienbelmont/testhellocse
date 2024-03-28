<?php

namespace App\Helpers;

use Faker\Factory;
use Illuminate\Support\Facades\File;

class Image
{
    /**
     * Generates a URL that will return an accidental image.
     *
     * @param integer $width Image width.
     * @param integer $height Image height.
     * @param bool $randomizeColors Random colors.
     * @param bool $randomizeTxt Random one word.
     * @param string $format Image format (jpg|png|gif).
     * @return string
     */
    public static function imageUrl(
        int $width = 640,
        int $height = 480,
        bool $randomizeColors = false,
        bool $randomizeTxt = false,
        string $format = 'jpg'
    ): string
    {
        $baseUrl = "https://dummyimage.com";
        $size = "/{$width}x{$height}";
        $colors = "/aaa/fff";
        $format = '.' . preg_replace('~^\b(?:jpg|png|gif)$~', '.jpg', $format);
    
        if ($randomizeColors) {
            $backgroundColor = str_replace('#', '', Factory::create()->safeHexColor);
            $foreColor = str_replace('#', '', Factory::create()->safeHexColor);
            $colors = "/{$backgroundColor}/{$foreColor}";
        }
    
        return $baseUrl . $size . $colors . $format . ($randomizeTxt ? '&text=' . Factory::create()->word : '');
    }

    /**
     * Loads a random image to the disk and returns its location.
     *
     * @param string $dir Directory.
     * @param integer $width Image width.
     * @param integer $height Image height.
     * @param bool $randomizeColors Random colors.
     * @param bool $randomizeTxt Random one word.
     * @param string $format Image format (jpg|png|gif).
     * @param bool $fullPath Full path of file.
     * @return bool|string|\InvalidArgumentException
     */
    public static function fake(
        string $dir = null,
        int $width = 640,
        int $height = 480,
        bool $randomizeColors = false,
        bool $randomizeTxt = false,
        string $format = 'jpg',
        bool $fullPath = false
)
    {
        // $dir = is_null($dir) ? sys_get_temp_dir() : $dir;

        File::makeDirectory($dir);

        if (!is_dir($dir) || !is_writable($dir)) {
            throw new \InvalidArgumentException("Unable to write to directory $dir");
        }

        // $name = md5(uniqid(empty($_SERVER['SERVER_ADDR']) ? '' : $_SERVER['SERVER_ADDR'], true));
        $name = 'image';
        $filename = $name . ".$format";
        $filepath = $dir . DIRECTORY_SEPARATOR . $filename;

        $url = static::imageUrl($width, $height, $randomizeColors, $randomizeTxt, $format);

        if (!File::put($filepath, file_get_contents($url))) {
            return false;
        }

        return $fullPath ? $filepath : $filename;
    }
}