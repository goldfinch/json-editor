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

        $className = $this->askClassNameQuestion('What [class name] is this schema for? (eg: Page, Member)', $input, $output);
        $fieldName = $this->askClassNameQuestion('What [field name] is this schema for? (eg: Title, Text)', $input, $output);

        $fs = new Filesystem();

        $target = 'app/_schema/' . $className . '-' . $fieldName . '.json';
        $filename = $className . '-' . $fieldName . '.json';

        if (!$fs->exists($target)) {

            $fs->copy(
                BASE_PATH . '/vendor/goldfinch/json-editor/components/schema.json',
                'app/_schema/' . $filename
            );

            $io->right('Json schema has been added');
            return Command::SUCCESS;
        } else {
            $io->wrong('The json schema ['.$filename.'] is already exists.');
            return Command::FAILURE;
        }
    }
}
