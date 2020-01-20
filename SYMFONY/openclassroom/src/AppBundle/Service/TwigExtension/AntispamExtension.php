<?php

namespace AppBundle\Service\TwigExtension;

use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class AntispamExtension extends AbstractExtension
{

    /**
     * @var Antispam
     */
    private $antispam;

    /**
     * TwigExtention constructor.
     * @param Antispam $antispam
     */
    public function __construct(Antispam $antispam)
    {
        $this->antispam = $antispam;
    }

    public function checkIfArgumentIsSpam(string $text)
    {
        return $this->antispam->isSpam($text);
    }

    public function getFunctions()
    {
        return [
            new TwigFunction('checkIfSpam',[$this,'checkIfArgumentIsSpam']),
        ];
    }


}