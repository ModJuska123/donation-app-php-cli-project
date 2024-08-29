<?php

namespace App\Controllers;

use App\Main\InputHandler;
use App\Main\View;

class CsvController extends SharedController
{   
    public function upload(InputHandler $argumentResolver): void
    {
        $argumentResolver->validateFilePath('filepath');
        $filePath = $argumentResolver->findArguments('filepath')->getValue();

        $handle = fopen($filePath, 'r');

        if ($handle === false) {
            View::writeLine("Error: Unable to open file at $filePath", 'error');
            return;
        }

        fgetcsv($handle, 0, ";");

        while (($columns = fgetcsv($handle, 0, ";")) !== false) {
            if (count($columns) === 2) {
                $name = $columns[0];
                $email = $columns[1];

                try {
                    $this->database->createCharity($name, $email);
                } catch (\Exception $e) {
                    View::writeLine("Error inserting row: $name, $email - " . $e->getMessage(), 'error');
                }
            } else {
                View::writeLine('Skipped row due to unexpected column count', 'warning');
            }
        }

        fclose($handle);

        View::writeLine('Successfully uploaded CSV', 'success');
    }
}

