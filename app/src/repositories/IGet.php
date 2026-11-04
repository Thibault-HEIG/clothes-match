<?php

interface IGet {
    public function getAll(): array;
    public function getById(int $id): ?object;
}
