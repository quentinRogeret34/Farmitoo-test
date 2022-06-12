<?php

namespace App\Entity\Vat;

class VatInterface
{
    public function getVat(): ?int
    {
        return $this->vat;
    }
}
