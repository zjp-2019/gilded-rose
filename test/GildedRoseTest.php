<?php

require_once 'gilded_rose.php';

class GildedRoseTest extends \PHPUnit\Framework\TestCase
{
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

    public function testQualityOfItemCantExceed50()
    {
        /** @var Item[] $items */
        $items = [
            new Item("Aged Brie", 0, 50)
        ];

        $gildedRose = new GildedRose($items);
        $gildedRose->update_quality();

        $this->assertEquals(
            50,
            $items[0]->quality
        );
    }

    public function testSulfurasDoNotChangeQuality()
    {
        /** @var Item[] $items */
        $quality = 50;
        $items = [
            new Item("Sulfuras, Hand of Ragnaros", 10, $quality)
        ];

        $gildedRose = new GildedRose($items);
        $gildedRose->update_quality();
        $gildedRose->update_quality();
        $gildedRose->update_quality();

        $this->assertEquals(
            $quality,
            $items[0]->quality
        );
    }

    public function testSulfurasDoNotChangeSellIn()
    {
        /** @var Item[] $items */
        $sellIn = 10;
        $items = [
            new Item("Sulfuras, Hand of Ragnaros", $sellIn, 50)
        ];

        $gildedRose = new GildedRose($items);
        $gildedRose->update_quality();
        $gildedRose->update_quality();
        $gildedRose->update_quality();

        $this->assertEquals(
            $sellIn,
            $items[0]->sell_in
        );
    }
}
