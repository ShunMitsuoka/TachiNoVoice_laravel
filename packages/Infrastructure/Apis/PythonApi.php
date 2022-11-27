<?php
namespace Packages\Infrastructure\Apis;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class PythonApi{
    public const API_END_POINT = 'http://tachinovoice_python:8000';
    protected const URL_TEXT_MINING = '/api/text_mining';

    static public function getTextMiningBase64Image(string $text): string
    {
        $url = self::API_END_POINT.self::URL_TEXT_MINING;
        try {
            $param = [
                "text" => $text,
            ];
            $response = Http::timeout(180)->post($url, $param);
            $body = $response->body();
            $result = json_decode($body, true);
            return $result['image'];
        } catch (\Throwable $th) {
            Log::error('テキストマイニングに失敗しました', [$th]);
        }
        return [];
    }
}