<?php
/**
 * Item class representing an item.
 */

class Item {
    private int $id;
    private string $category;
    private float $hue;
    private float $saturation;
    private float $brightness;
    private int $season;
    private int $rate;

    public function __construct(int $id, string $category, float $hue, float $saturation, float $brightness, int $season, int $rate,) {
        $this->id = $id;
        $this->category = $category;
        $this->hue = $hue;
        $this->saturation = $saturation;
        $this->brightness = $brightness;
        $this->season = $season;
        $this->rate = $rate;
    }
}
