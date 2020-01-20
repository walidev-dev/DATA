<?php

namespace OC\PlatformeBundle\twig;

use OC\PlatformeBundle\Antispam\OCAntispam;

class AntispamExtension extends \Twig_Extension
{
    /**
     * @var OCAntispam
     */
    private $ocAntispam;

    public function __construct(OCAntispam $OCAntispam)
    {
        $this->ocAntispam = $OCAntispam;
    }

    public function checkIfArgumentIsSpam($text)
    {
        return $this->ocAntispam->isSpam($text);
    }

    public function getFunctions()
    {
        return [
            new \Twig_SimpleFunction('checkIfSpam', [$this, 'checkIfArgumentIsSpam']),
        ];
    }

    public function getName()
    {
        return 'OCAntispam';
    }
}