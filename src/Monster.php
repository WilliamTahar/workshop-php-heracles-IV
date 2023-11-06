<?php

namespace App;

class Monster extends Fighter
{
    public function __construct(
        string $name,
        int $strength = 10,
        int $dexterity = 5,
        string $image = 'fighter.svg')
    {
        parent::__construct($name, $strength, $dexterity, $image);
        $this->setExperience(500);
    }
}
