<?php

namespace Framework\TwigExtension;

use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

class TextExtension extends AbstractExtension
{

    public function excerpt($content, $maxLength = 100)
    {
        if (mb_strlen($content) > $maxLength) {
            $str = mb_substr($content, 0, $maxLength);
            $lastSpace = mb_strrpos($str, ' ');
            return mb_substr($str, 0, $lastSpace) . '...';
        }
        return $content;
    }

    public function getFilters()
    {
        return [
            new TwigFilter('excerpt', [$this, 'excerpt'])
        ];
    }
}