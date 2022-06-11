<?php

namespace App\Entity;

class Pays
{
    private $name;
    private $vat;

    public function __construct($name)
    {
        $this->name = $name;
    }

    public function getName(): string
    {
        return $this->name;
    }
}
