<?php

namespace App\Entity;

use Exception;


class Pays
{
    private $name;

    public function __construct($name)
    {
        $this->name = $name;
    }

    public function getTva()
    {
        switch ($this->getName()) {
            case 'FR':
                return 1.20;
            case 'BE':
            case 'LU':
            case 'NL':
            case 'DE':
                return 1.19;
            default:
                throw new Exception('Pays inconnu');
        }
    }

    public function getName(): string
    {
        return $this->name;
    }
}
