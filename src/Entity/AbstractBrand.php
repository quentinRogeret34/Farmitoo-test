<?php

namespace App\Entity;

use App\Entity\Pays;

abstract class AbstractBrand
{

    protected $name;

    protected $pays;

    public function __construct(Pays $pays = null)
    {
        $this->name = $this->getName();
        $this->pays = $pays;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getPays()
    {
        return $this->pays;
    }
}
