<?php

namespace Goldfinch\JSONEditor\Forms;

use SilverStripe\Forms\TextField;
use SilverStripe\View\Requirements;

class JSONEditorField extends TextField
{
    public function __construct($name, $title = null, $parent = null, $value = '{}', $form = null, $schema = '{}')
    {
        $defaultSchema = BASE_PATH . '/app/_schema/' . $parent->singular_name() . '-' . $name . '.json';

        if (file_exists($defaultSchema))
        {
            $schema = file_get_contents($defaultSchema);
        }
        else
        {
            $schema = '{}';
        }

        if ($schema === '')
        {
            $schema = '{}';
        }

        $value = $schema;

        parent::__construct($name, $title, $value);
        // parent::__construct($name, $title, $value, '', $form);

        Requirements::css('goldfinch/json-editor:client/dist/resources/assets/json-editor-style.css');
        Requirements::javascript('goldfinch/json-editor:client/dist/resources/assets/json-editor.js');

        $this->addExtraClass('jsoneditorfield');
        $this->setInputType('hidden');
        $this->setAttribute('data-field-schema', $schema);
    }
}
