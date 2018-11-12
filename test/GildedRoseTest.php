<?php

require_once 'gilded_rose.php';

class GildedRoseTest extends \PHPUnit\Framework\TestCase {

    function testFoo() {
        $items = array(new Item("foo", 0, 0));
        $gildedRose = new GildedRose($items);
        $gildedRose->update_quality();
        $this->assertEquals("foo", $items[0]->name);
    }

    public function testQualityDegradesTwiceAsFastWhenSellInExpires()
    {
        /** @var Item[] $items */
        $items = [
            new Item("foo", 0, 4)
        ];

        $gildedRose = new GildedRose($items);
        $gildedRose->update_quality();

        $this->assertEquals(
            2,
            $items[0]->quality
        );
    }
}
