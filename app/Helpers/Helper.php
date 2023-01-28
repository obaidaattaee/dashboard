<?php

use Illuminate\Support\Facades\File;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

function t($key, $placeholder = [], $locale = null)
{
    $group = 'lang';
    if (is_null($locale))
        $locale = config('app.locale');
    $key = trim($key);
    $word = $group . '.' . $key;
    if (\Illuminate\Support\Facades\Lang::has($word)) {
        return trans($word, $placeholder, $locale);
    } else {
        // return $key;
    }
    $messages = [
        $word => $key,
    ];
    app('translator')->addLines($messages, $locale);
    $langs = LaravelLocalization::getSupportedLocales();
    foreach ($langs as $lang => $language) {
        if (!File::exists(base_path() . '/resources/lang/' . $lang . '/' . $group . '.php')) {
            File::put(base_path() . '/resources/lang/' . $lang . '/' . $group . '.php', '<?php
            return [
            ');
        }
        $translation_file = base_path() . '/resources/lang/' . $lang . '/' . $group . '.php';
        $fh = fopen($translation_file, 'r+');
        $key = str_replace("'", "\'", $key);
        $new_key = "\n \t'$key' => '$key',\n];\n";
        fseek($fh, -4, SEEK_END);
        fwrite($fh, $new_key);
        fclose($fh);
    }
    return trans($word, $placeholder, $locale);
}
