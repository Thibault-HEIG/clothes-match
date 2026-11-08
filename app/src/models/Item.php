<?php
require_once __DIR__ . '/Season.php';
require_once __DIR__ . '/../constants.php';
/**
 * Item class representing an item.
 */

class Item {
    private ?int $id;
    private string $category;
    private Color $color;
    private Season $season;
    private int $user_rate;
    private string $img_url;

    public function __construct(string $category, Season $season, Color $color, int $user_rate, string $img_url, ?int $id = null) {
        if ($user_rate < 0 || $user_rate > 5) {
            throw new InvalidArgumentException("User rate must be between 0 and 5.");
        }
        if (!array_key_exists($category, CATEGORIES)) {
            throw new InvalidArgumentException("Category is not valid.");
        }
        $this->id = $id;
        $this->category = $category;
        $this->season = $season;
        $this->color = $color;
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

    public function getColor(): Color {
        return $this->color;
    }

    public function getId(): ?int {
        return $this->id;
    }

}
