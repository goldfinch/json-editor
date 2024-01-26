<?php

namespace Goldfinch\JSONEditor\Commands;

use Goldfinch\Taz\Services\InputOutput;
use Goldfinch\Taz\Console\GeneratorCommand;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Console\Command\Command;

#[AsCommand(name: 'make:json-schema')]
class MakeJsonSchemaCommand extends GeneratorCommand
{
    protected static $defaultName = 'make:json-schema';

    protected $description = 'Make new json schema';

    protected $no_arguments = true;

    protected function execute($input, $output): int
    {
        $io = new InputOutput($input, $output);

        $className = $io->question('Name of the class where Json field is going to be used', null, function ($answer) use ($io) {

            if (!is_string($answer) || $answer === null) {
                throw new \RuntimeException(
                    'Invalid name'
                );
            } else if (strlen($answer) < 2) {
                throw new \RuntimeException(
                    'Too short name'
                );
            } else if(!preg_match('/^([A-z0-9\_]+)$/', $answer)) {
                throw new \RuntimeException(
                    'Name can contains letter, numbers and underscore'
                );
            }

            return $answer;
        });

        $fieldName = $io->question('Name of the field', null, function ($answer) use ($io) {

            if (!is_string($answer) || $answer === null) {
                throw new \RuntimeException(
                    'Invalid name'
                );
            } else if (strlen($answer) < 2) {
                throw new \RuntimeException(
                    'Too short name'
                );
            } else if(!preg_match('/^([A-z0-9\_]+)$/', $answer)) {
                throw new \RuntimeException(
                    'Name can contains letter, numbers and underscore'
                );
            }

            return $answer;
        });

        $fs = new Filesystem();

        $fs->copy(
            BASE_PATH .
                '/vendor/goldfinch/json-editor/components/schema.json',
            'app/_schema/' . $className . '-' . $fieldName . '.json',
        );

        $io->right('Json schema has been added');

        return Command::SUCCESS;
    }
}
