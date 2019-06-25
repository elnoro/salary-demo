<?php

namespace App\Command;

use App\FilesystemIntegration\Input\EmployeeReaderInterface;
use App\FilesystemIntegration\Output\SalaryExporterInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

final class CalculateCommand extends Command
{
    protected static $defaultName = 'app:calculate-salary';

    /** @var EmployeeReaderInterface */
    private $employeeReader;
    /** @var SalaryExporterInterface */
    private $salaryExporter;

    public function __construct(EmployeeReaderInterface $employeeProvider, SalaryExporterInterface $salaryExporter)
    {
        $this->employeeReader = $employeeProvider;
        $this->salaryExporter = $salaryExporter;

        parent::__construct();
    }

    protected function configure()
    {
        $this
            ->setDescription('Calculates salaries from csv into output csv')
            ->addArgument('employees-file', InputArgument::REQUIRED, 'Input file')
            ->addArgument('salaries-file', InputArgument::REQUIRED, 'Output file');
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $io = new SymfonyStyle($input, $output);
        $employeesFile = $input->getArgument('employees-file');
        $salariesFile = $input->getArgument('salaries-file');

        $employees = $this->employeeReader->read($employeesFile);
        $this->salaryExporter->export($salariesFile, $employees);

        $io->success('Output');
    }
}
