<?php
namespace Packages\Infrastructure\Services;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Packages\Domain\Interfaces\Services\TextMiningServiceInterface;
use Packages\Infrastructure\Apis\PythonApi;

class TextMiningService implements TextMiningServiceInterface
{
    public function textMining(string $text, string $path, string $file_name) : string
    {
        $abs_path = storage_path('app/'.$path);
        if(!file_exists($abs_path)) {
            mkdir($abs_path, 0774, true);
        }

        $base64_image = PythonApi::getTextMiningBase64Image($text);
        Log::info($base64_image);
        preg_match('/data:image\/(\w+);base64,/', $base64_image, $matches);
        $extension = $matches[1];
        $img = preg_replace('/^data:image.*base64,/', '', $base64_image);
        $img = str_replace(' ', '+', $img);
        $file = base64_decode($img);
        $file_name = $file_name.'.'.$extension;
        $file_path = $path.$file_name;
        Storage::put($file_path, $file, 'public');
        return $file_path;
    }
}