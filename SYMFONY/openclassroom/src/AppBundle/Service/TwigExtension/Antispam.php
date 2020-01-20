<?php

namespace AppBundle\Service\TwigExtension;

class Antispam
{

    private $mailer;
    private $locale;
    private $minLength;

    public function __construct($mailer, $locale, $minLength)
    {
        $this->mailer = $mailer;
        $this->locale = $locale;
        $this->minLength = (int)$minLength;
    }


    /**
     * @param string $text
     * @return bool
     */
    public function isSpam(string $text): bool
    {
        return strlen($text) < $this->minLength;
    }
}