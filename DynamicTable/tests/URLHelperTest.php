<?php

use App\URLHelper;
use PHPUnit\Framework\TestCase;

class URLHelperTest extends TestCase
{
    public function testWithParam()
    {
        $url = "q=city&p=1";
        $this->assertEquals($url, URLHelper::withParam(['q' => 'city'], 'p', 1));
    }

    public function testWithParamIsArray()
    {
        $url = "k=1,2,3";
        $this->assertEquals($url, urldecode(URLHelper::withParam([], 'k', [1, 2, 3])));
    }

    public function testWithParams()
    {
        $url = "q=paris&p=1";
        $this->assertEquals($url, URLHelper::withParams(['q' => 'paris', 'p' => 1], []));
    }

    public function testWithParamsIsArray()
    {
        $url = "a=3&q=city&p=1,2,3";
        $this->assertEquals($url, urldecode(URLHelper::withParams(['a' => 3, 'q' => 'city'], ['p' => [1, 2, 3]])));
    }
}
