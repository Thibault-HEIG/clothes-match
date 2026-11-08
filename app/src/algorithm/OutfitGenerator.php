<?php

/**
 * OutfitGenerator class for generating outfits based on items and their attributes.
 */

class OutfitGenerator {
    private float $colorHarmonyWeight;
    private float $seasonHarmonyWeight;
    private ?Item $seedItem;
    private ?int $seasonWishId;
    private float $modelTemperature;

    public function __construct(float $colorHarmonyWeight = 0.5, float $seasonHarmonyWeight = 0.5, ?Item $seedItem = null, ?int $seasonWishId = null, float $modelTemperature = ALGORITHM_TEMPERATURE) {
        if ($colorHarmonyWeight < 0 || $colorHarmonyWeight > 1) {
            throw new InvalidArgumentException("Color harmony weight must be between 0 and 1.");
        }
        if ($seasonHarmonyWeight < 0 || $seasonHarmonyWeight > 1) {
            throw new InvalidArgumentException("Season harmony weight must be between 0 and 1.");
        }
        if ($modelTemperature < 0 || $modelTemperature > 1) {
            throw new InvalidArgumentException("Model temperature must be between 0 and 1.");
        }
        if ($colorHarmonyWeight + $seasonHarmonyWeight !== 1) {
            throw new InvalidArgumentException("The sum of color and season harmony weights must be 1.");
        }
        $this->colorHarmonyWeight = $colorHarmonyWeight;
        $this->seasonHarmonyWeight = $seasonHarmonyWeight;
        $this->seedItem = $seedItem;
        $this->seasonWishId = $seasonWishId;
        $this->modelTemperature = $modelTemperature;
    }
}
