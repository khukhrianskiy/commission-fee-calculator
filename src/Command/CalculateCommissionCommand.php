<?php

namespace App\Command;

use App\Model\Input\Operation;
use CsvFile;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Serializer\Encoder\CsvEncoder;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Normalizer\ArrayDenormalizer;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Validator\Validator\ValidatorInterface;

#[AsCommand(
    name: 'commission:calculate',
    description: 'Calculate commission fee',
)]
class CalculateCommissionCommand extends Command
{
    public function __construct(
        private readonly ValidatorInterface $validator,
    ) {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this->addArgument('file', InputArgument::REQUIRED, 'Path to CSV file');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $filePath = $input->getArgument('file');

        if ($this->validator->validate($filePath, new CsvFile())->count()) {
            throw new \InvalidArgumentException('Invalid file');
        }

        $encoders = [new CsvEncoder()];
        $normalizers = [new ObjectNormalizer(), new ArrayDenormalizer()];
        $serializer = new Serializer($normalizers, $encoders);

        $data = $serializer->deserialize(file_get_contents($filePath), Operation::class . '[]', 'csv',
            [CsvEncoder::NO_HEADERS_KEY => true]
        );

        var_dump($data);exit();


        return Command::SUCCESS;
    }
}