<?php
namespace Packages\Domain\Models\Village\VillageOpinionInfo\Policy;

class Policy
{
    private string $content;
    private ?array $satisfactions;

    function __construct(
        string $content,
        ?array $satisfactions = [],
    ) {
        $this->content = $content;
        $this->satisfactions = $satisfactions;
    }

    public function content() : string{
        return $this->content;
    }

    public function satisfactions() : array{
        return $this->satisfactions;
    }

}