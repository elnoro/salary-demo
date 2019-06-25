<?php

namespace App\FilesystemIntegration\Input;

interface EmployeeReaderInterface
{
    public function read(string $filename): iterable;
}