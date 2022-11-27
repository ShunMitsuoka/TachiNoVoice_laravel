<?php
namespace Packages\Domain\Interfaces\Services;

interface TextMiningServiceInterface
{
    public function textMining(string $text, string $path, string $file_name) : string;
}