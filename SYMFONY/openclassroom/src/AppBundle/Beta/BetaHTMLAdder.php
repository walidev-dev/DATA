<?php

namespace AppBundle\Beta;

use Symfony\Component\HttpFoundation\Response;

class BetaHTMLAdder
{
    public function addBeta(Response $response, $remainingDays): Response
    {
        $content = $response->getContent();
        $html = '<div style="position: absolute;top: 0;background: orange;width:100%;
        text-align:center;padding: 0.5em;margin-bottom: 10px">Beta J-' . $remainingDays . '</div>';
        $content = str_replace('<body>', '<body>' . $html, $content);
        $response->setContent($content);
        return $response;
    }

}