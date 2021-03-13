<?php


namespace App\Twig;

use phpDocumentor\Reflection\Type;
use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

class VarsExtension extends AbstractExtension
{
    public function getFilters()
    {
        return [
            new TwigFilter('json_decode', [$this, 'jsonDecode']),
        ];
    }

    public function jsonDecode($text)
    {
        return json_decode($text);
    }
}