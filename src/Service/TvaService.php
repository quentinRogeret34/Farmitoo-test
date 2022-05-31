<?php

namespace App\Service;


class TvaService
{

    public function getPourcentageTva($locale){
        switch ($locale) {
            case 'fr':
               return 0.20;
            case 'es':
                return 0.21;
            case 'en':
                return 0.19;
                break;
            
            default:
                return 0.20;
                break;
        }
    }
}