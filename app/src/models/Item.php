<?php
require_once __DIR__ . '/Season.php';
/**
 * Item class representing an item.
 */

class Item {
    private int $id;
    private string $category;
    private int $hue;
    private int $saturation;
    private int $brightness;
    private Season $season;
    private int $user_rate;
    private string $img_url;

    public function __construct(int $id, string $category, int $hue, int $saturation, int $brightness, Season $season, int $user_rate, string $img_url) {
        $this->id = $id;
        $this->category = $category;
        $this->hue = $hue;
        $this->saturation = $saturation;
        $this->brightness = $brightness;
        $this->season = $season;
        $this->user_rate = $user_rate;
        $this->img_url = $img_url;
    }

    public function getImgUrl(): string {
        return $this->img_url;
    }

    public function getCategory(): string {
        return $this->category;
    }

    public function getRate(): int {
        return $this->user_rate;
    }

    public function getSeason(): Season {
        return $this->season;
    }
}
