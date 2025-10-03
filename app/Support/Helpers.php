<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Session;
use App\Models\Language;
use App\Models\BlogCategory;
use Illuminate\Support\Str;

if ( ! function_exists('getLanguages')) {
    function getLanguages()
    {
        if ( ! Schema::hasTable('languages')) {
            return [];
        }

        return cache()->rememberForever('languages', static function () {
            return Session::has('language')
                ? Language::pluck('name', 'code')->toArray()
                : Language::where('is_default', 1)->pluck('name', 'code')->toArray();
        });
    }
}

if ( ! function_exists('getBlogCategories')) {
    function getBlogCategories()
    {
        return cache()->rememberForever('blogCategories', static function () {
            return BlogCategory::pluck('title', 'id')->toArray();
        });
    }
}

if ( ! function_exists('settings')) {
    function settings()
    {
        return cache()->rememberForever('settings', static function () {
            return App\Models\Settings::firstOrFail();
        });
    }
}

function flagImageUrl($language_code)
{
    return asset(sprintf('images/flags/%s.png', $language_code));
}

function getSlug(array $request, $key)
{
    $language_default = Language::query()
        ->where('is_default', Language::IS_DEFAULT)
        ->select('code')
        ->first();
    $language_code = $language_default->code;
    $value = $request[$language_code][$key];

    return Str::slug($value);
}

function uploadImage(string $path, int $width, int $height): string
{
    // Generate a random image filename
    $filename = Str::random(12).'.jpg'; // You can adjust the filename format if needed

    // Generate the full path to save the image
    $imagePath = public_path($path.'/'.$filename);

    $imageUrl = 'https://picsum.photos/'.$width.'/'.$height.'/';

    // Save the image to the local filesystem
    file_put_contents($imagePath, file_get_contents($imageUrl));

    return $filename;
}
