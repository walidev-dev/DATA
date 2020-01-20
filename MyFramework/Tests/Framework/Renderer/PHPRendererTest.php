<?php
namespace Tests\Framework\Renderer;

use Framework\Renderer\PHPRenderer;
use PHPUnit\Framework\TestCase;

class PHPRendererTest extends TestCase
{

    /**
     * @var PHPRenderer
     */
    private $renderer;

    public function setUp()
    {
        $this->renderer = new PHPRenderer(__DIR__.'/views');
    }

    public function testRenderTheDefaultPath()
    {
        $content = $this->renderer->render('demo');
        $this->assertEquals('Salut les gens', $content);
    }

    public function testRenderTheRightPath()
    {
        $this->renderer->addPath('blog', __DIR__ . DIRECTORY_SEPARATOR.'/views');
        $content = $this->renderer->render('@blog/demo');
        $this->assertEquals('Salut les gens', $content);
    }

    public function testRenderWithParams()
    {
        $this->renderer->addPath('blog', __DIR__ . DIRECTORY_SEPARATOR.'/views');
        $content = $this->renderer->render('@blog/demoparam', ['nom' => 'Marc']);
        $this->assertEquals('Salut Marc', $content);
    }

    public function testGlobalParameters()
    {
        $this->renderer->addGlobal('nom', 'Marc');
        $content = $this->renderer->render('demoparam');
        $this->assertEquals('Salut Marc', $content);
    }
}
