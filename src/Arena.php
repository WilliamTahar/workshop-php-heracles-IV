<?php

namespace App;

use Exception;

class Arena 
{
    private array $monsters;
    private Hero $hero;

    private int $size = 10;

    public function __construct(Hero $hero, array $monsters)
    {
        $this->hero = $hero;
        $this->monsters = $monsters;
    }

    public function move(Fighter $fighter, string $direction): void
    {
        $destination = [
            'x' => $fighter->getX(),
            'y' => $fighter->getY()
        ];

        if ($direction === 'S') {
            $destination['y'] += 1;
        } elseif ($direction === 'N') {
            $destination['y'] -= 1;
        } elseif ($direction === 'W') {
            $destination['x'] -= 1;
        } elseif ($direction === 'E') {
            $destination['x'] += 1;
        } else {
            throw new Exception('Invalide direction');
        }
        if ($destination['x'] < 0 || $destination['x'] > 9 || $destination['y'] < 0 || $destination['y'] > 9) {
            throw new Exception('Tu sors de la carte !!!');
        }

        foreach ($this->monsters as $monster) {
            if ($monster->getX() === $destination['x'] && $monster->getY() === $destination['y']) {
                throw new Exception($monster->getName() . ' est déjà sur la case !');
            }
        }

        $fighter->setX($destination['x']);
        $fighter->setY($destination['y']);
    }

    public function battle(int $id): void
    {
        $monster = $this->monsters[$id];
        $isTouchable = $this->touchable($this->hero, $monster);
        if (!$isTouchable) {
            throw new Exception($monster->getName() . ' est hors de porté');
        }
        $this->hero->fight($monster);
        if (!$monster->isAlive()) {
            $this->hero->setExperience($this->hero->getExperience() + $monster->getExperience());
            unset($this->monsters[$id]);
            return;
        }
        if (!$this->touchable($monster, $this->hero)) {
            throw new Exception('Le heros est hors de porté de ' . $monster->getName());
        }
        $monster->fight($this->hero);
      /*  try {
            $this->fight($this->hero, $monster);
        } catch (Exception $e) {
            $this->fight($monster, $this->hero);
            throw new Exception($e->getMessage());
        }
        $this->fight($monster, $this->hero);*/
    }
    /*
    private function fight(Fighter $att, Fighter $def)
    {
        if (!$this->touchable($att, $def)) {
            throw new Exception('Hors de porté');
        }
        $att->fight($def);
    }*/

    public function getDistance(Fighter $startFighter, Fighter $endFighter): float
    {
        $Xdistance = $endFighter->getX() - $startFighter->getX();
        $Ydistance = $endFighter->getY() - $startFighter->getY();
        return sqrt($Xdistance ** 2 + $Ydistance ** 2);
    }

    public function touchable(Fighter $attacker, Fighter $defenser): bool
    {
        return $this->getDistance($attacker, $defenser) <= $attacker->getRange();
    }

    /**
     * Get the value of monsters
     */ 
    public function getMonsters(): array
    {
        return $this->monsters;
    }

    /**
     * Set the value of monsters
     *
     */ 
    public function setMonsters($monsters): void
    {
        $this->monsters = $monsters;
    }

    /**
     * Get the value of hero
     */ 
    public function getHero(): Hero
    {
        return $this->hero;
    }

    /**
     * Set the value of hero
     */ 
    public function setHero($hero): void
    {
        $this->hero = $hero;
    }

    /**
     * Get the value of size
     */ 
    public function getSize(): int
    {
        return $this->size;
    }
}