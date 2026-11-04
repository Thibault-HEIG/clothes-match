<?php

class Color {
    private int $hue;
    private int $saturation;
    private int $brightness;

    public function __construct(int $hue, int $saturation, int $brightness) {
        $this->hue = $hue;
        $this->saturation = $saturation;
        $this->brightness = $brightness;
    }
    public function getHue(): int {
        return $this->hue;
    }

    public function getSaturation(): int {
        return $this->saturation;
    }

    public function getBrightness(): int {
        return $this->brightness;
    }
}
