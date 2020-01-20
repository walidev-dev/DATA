<?php
namespace OC\PlatformeBundle\Antispam;
class OCAntispam{
    private $mailer;
    private $locale;
    private $minLength;
    public function __construct($mailer,$minLength){
        $this->mailer=$mailer;
        $this->minLength=(int)$minLength;
    }
    /**
     * @param string $text
     * @return bool
     */
    public function isSpam($text){
        return strlen($text)<$this->minLength;
    }
    public function setLocale($locale){
        $this->locale=$locale;
    }
}
