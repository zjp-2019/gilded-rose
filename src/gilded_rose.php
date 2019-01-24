<?php

class GildedRose
{
    /** @var Item[] */
    private $items;

    function __construct($items)
    {
        $this->items = $items;
    }

    function update_quality()
    {
        foreach ($this->items as $item) {
            if ($item->name === Item::SULFURAS_HAND_OF_RAGNAROS) {
                continue;
            }

            if ($item->name === Item::AGED_BRIE) {
                $item->increaseQuality();
            } elseif ($item->name === Item::BACKSTAGE_PASSES_TO_A_TAFKAL_80_ETC_CONCERT) {
                new BackstagePassesQualityService($item);
            } else {
                $item->degradeQuality();
            }

            if ($item->name === Item::CONJURED_MANA_CAKE) {
                $item->degradeQuality();
            }
        }
    }
}

class BackstagePassesQualityService
{
    public function __construct(Item &$item)
    {
        if ($item->hasSellByDatePassed()) {
            $item->setQuality(Item::MIN_QUALITY);
        } else {
            $item->increaseQuality();

            if ($item->isSellInBelow(11)) {
                $item->increaseQuality();
            }
            if ($item->isSellInBelow(6)) {
                $item->increaseQuality();
            }
        }
    }
}

class Item
{
    const BACKSTAGE_PASSES_TO_A_TAFKAL_80_ETC_CONCERT = 'Backstage passes to a TAFKAL80ETC concert';
    const SULFURAS_HAND_OF_RAGNAROS = 'Sulfuras, Hand of Ragnaros';
    const CONJURED_MANA_CAKE = 'Conjured Mana Cake';
    const AGED_BRIE = 'Aged Brie';
    const MAX_QUALITY = 50;
    const MIN_QUALITY = 0;

    public $name;
    public $sell_in;
    public $quality;

    function __construct($name, $sell_in, $quality)
    {
        $this->name = $name;
        $this->sell_in = $sell_in;
        $this->quality = $quality;
    }

    public function __toString()
    {
        return "{$this->name}, {$this->sell_in}, {$this->quality}";
    }

    public function degradeQuality()
    {
        if ($this->hasSellByDatePassed()) {
            $this->subtractQuality(2);
        } else {
            $this->subtractQuality(1);
        }
    }

    public function hasSellByDatePassed()
    {
        return $this->sell_in <= 0;
    }

    public function subtractQuality($quality)
    {
        if ($this->quality - $quality >= self::MIN_QUALITY) {
            $this->quality -= $quality;
        }
    }

    public function increaseQuality()
    {
        $this->addQuality(1);
    }

    /**
     * @param int $quality
     */
    public function addQuality($quality)
    {
        if ($this->quality + $quality <= self::MAX_QUALITY) {
            $this->quality += $quality;
        }
    }

    public function isSellInBelow($sellIn)
    {
        return $this->sell_in < $sellIn;
    }

    public function setQuality($quality)
    {
        $this->quality = $quality;
    }
}

