<?php

namespace App\Service\Pays;

use Exception;
use App\Entity\Pays;

class PaysVatService
{
    public function getVat(Pays $pays)
    {
        switch ($pays->getName()) {
            case 'FR':
                return 1.20;
            case 'BE':
            case 'LU':
            case 'NL':
            case 'DE':
                return 1.19;
            default:
                throw new Exception("La TVA n'est pas définie pour ce pays");
        }
    }
}
