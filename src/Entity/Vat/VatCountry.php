<?php

namespace App\Entity\Vat;

class VatCountry implements VatInterface
{
    private $vat;

    public function __construct(float $vat)
    {
        $this->vat = $vat;
    }

    public function getVat(): ?float
    {
        return $this->vat;
    }
}
