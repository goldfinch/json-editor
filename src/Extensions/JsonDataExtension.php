<?php

namespace Goldfinch\JSONEditor\Extensions;

use SilverStripe\Core\Extension;
use SilverStripe\Forms\FieldList;
use Goldfinch\JSONEditor\Forms\JSONEditorField;
use Goldfinch\JSONEditor\ORM\FieldType\DBJSONText;

class JsonDataExtension extends Extension
{
    private static $db = [
        'Json' => DBJSONText::class,
    ];

    public function updateCMSFields(FieldList $fields)
    {
        $fields->removeByName(['Json']);

        if ($this->owner->ID) {
            $path = str_replace('\\', '/', $this->owner->ClassName);
            $schemaParamsPath = BASE_PATH . '/app/_schema/' . $path . '.json';

            if (file_exists($schemaParamsPath)) {
                $schemaParams = file_get_contents($schemaParamsPath);

                $fields->addFieldsToTab('Root.Main', [
                    JSONEditorField::create(
                        'Json',
                        'Json Data',
                        $this->owner,
                        [],
                        '{}',
                        null,
                        $schemaParams,
                    ),
                ]);
            }
        }
    }
}
