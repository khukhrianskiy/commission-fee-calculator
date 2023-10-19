<?php

namespace App\Validator\File\Csv;

use Symfony\Component\Validator\Constraints\File;

class CsvFile extends File
{
    public function __construct()
    {
        parent::__construct(
            mimeTypes: ['csv' => 'text/csv']
        );
    }

    public function validatedBy(): string
    {
        return 'Symfony\Component\Validator\Constraints\FileValidator';
    }
}
