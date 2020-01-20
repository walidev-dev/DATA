<?php

use App\Support\Collection;
use PHPUnit\Framework\TestCase;

class CollectionTest extends TestCase
{
    public function test_empty_instantiated_collection_returns_no_items()
    {
        $collection = new Collection;
        $this->assertEmpty($collection->get());
    }

    public function test_count_is_correct()
    {
        $collection = new Collection([1, 2, 3]);
        $this->assertCount(3, $collection->get());
        $this->assertEquals(3, $collection->count());
    }
}
