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

    public function testQualityCantBeNegative()
    {
        /** @var Item[] $items */
        $items = [
            new Item("foo", 1, 0)
        ];

        $gildedRose = new GildedRose($items);
        $gildedRose->update_quality();

        $this->assertGreaterThanOrEqual(
            0,
            $items[0]->quality
        );
    }

    public function testAgedBrieIncreasesQualityAsItGetsOlder()
    {
        $quality = 0;

        /** @var Item[] $items */
        $items = [
            new Item("Aged Brie", 10, $quality)
        ];

        $gildedRose = new GildedRose($items);
        $gildedRose->update_quality();

        $this->assertEquals(
            $quality + 1,
            $items[0]->quality
        );
    }
}
