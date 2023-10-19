<?php

namespace Goldfinch\JSONEditor\Forms;

use SilverStripe\Forms\TextField;
use SilverStripe\View\Requirements;

class JSONEditorField extends TextField
{
    public function __construct($name, $title = null, $value = '{}', $form = null, $schema = '{}')
    {
        if (!$value)
        {
            $value = '{}';
        }

        if (!$schema)
        {
            $schema = '{}';
        }

        parent::__construct($name, $title, $value);
        // parent::__construct($name, $title, $value, '', $form);

        Requirements::css('goldfinch/json-editor:client/dist/resources/assets/json-editor-style.css');
        Requirements::javascript('goldfinch/json-editor:client/dist/resources/assets/json-editor.js');

        $this->addExtraClass('jsoneditorfield');
        $this->setInputType('hidden');
        $this->setAttribute('data-field-schema', $schema);
    }
}
