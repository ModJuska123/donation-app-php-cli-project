<?php

namespace App\Controllers;

use App\Main\InputHandler;
use App\Main\View;

class CharityController extends SharedController
{
    public function charitiesList(): void
    {
        $charities = $this->database->showAllCharities();

        $this->outputCharitiesList($charities);
    }

    public function create(InputHandler $argumentResolver): void
    {
        $name = $this->getValidatedArgument($argumentResolver, 'name');
        $email = $this->getValidatedEmail($argumentResolver);

        $this->database->createCharity($name, $email);

        View::writeLine('Successfully created charity', 'success');
    }

    public function update(InputHandler $argumentResolver): void
    {
        $id = $this->getValidatedId($argumentResolver);
        $name = $this->getValidatedArgument($argumentResolver, 'name');
        $email = $this->getValidatedEmail($argumentResolver);

        if ($this->database->updateCharity($id, $name, $email)) {
            View::writeLine('Successfully updated charity', 'success');
        } else {
            View::writeLine('Something went wrong', 'error');
        }
    }

    public function delete(InputHandler $argumentResolver): void
    {
        $id = $this->getValidatedId($argumentResolver);

        if ($this->database->deleteCharity($id)) {
            View::writeLine('Successfully deleted charity', 'success');
        } else {
            View::writeLine('Something went wrong', 'error');
        }
    }

    private function outputCharitiesList(array $charities): void
    {
        View::writeLine('Charities list is following:', 'warning');

        if (count($charities)) {
            foreach ($charities as $charity) {
                $this->outputCharityDetails($charity);
            }
        } else {
            View::writeLine('Charities list is empty', 'info');
        }
    }

    private function outputCharityDetails($charity): void
    {
        View::writeLine(' ID: ' . $charity->getId());
        View::writeLine(' Name: ' . $charity->getName());
        View::writeLine(' Email: ' . $charity->getEmail());
    }

    private function getValidatedArgument(InputHandler $argumentResolver, string $key): string
    {
        $argumentResolver->isEmpty($key);
        return $argumentResolver->findArguments($key)->getValue();
    }

    private function getValidatedEmail(InputHandler $argumentResolver): string
    {
        $argumentResolver->validateEmailFormat('email');
        return $argumentResolver->findArguments('email')->getValue();
    }

    private function getValidatedId(InputHandler $argumentResolver): int
    {
        $argumentResolver->numericValidation('id');
        return (int) $argumentResolver->findArguments('id')->getValue();
    }
}
