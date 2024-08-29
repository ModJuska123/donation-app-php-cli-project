<?php

namespace App\Controllers;

use App\Main\InputHandler;
use App\Main\View;

class DonationController extends SharedController
{

    public function add(InputHandler $argumentResolver){
        $argumentResolver->numericValidation('charityId');
        $argumentResolver->numericValidation('amount');
        $argumentResolver->isEmpty('name');
        $argumentResolver->isEmpty('dateTime');

        $charityId = (int) $argumentResolver->findArguments('charityId')->getValue();
        $name = $argumentResolver->findArguments('name')->getValue();
        $amount = (int) $argumentResolver->findArguments('amount')->getValue();
        $dateTime = $argumentResolver->findArguments('dateTime')->getValue();

        if(!$this->database->showCharity($charityId)){
            View::writeLine('Charity ' . $charityId. ' does not exist');
            die();
        }

        if($this->database->addDonation($charityId, $name, $amount, $dateTime)){
            View::writeLine('Successfully added amount to charity', 'success');
        } else {
            View::writeLine('Failed to add amount to charity', 'error');
        }
    }
}