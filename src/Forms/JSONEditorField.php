<?php

namespace Goldfinch\JSONEditor\Forms;

use SilverStripe\Forms\TextField;
use SilverStripe\View\Requirements;

class JSONEditorField extends TextField
{
    public function __construct($name, $title = null, $value = '{}', $form = null, $schema = '{}')
    {
        parent::__construct($name, $title, $value);

        Requirements::css('goldfinch/json-editor:client/dist/resources/assets/json-editor-style.css');
        Requirements::javascript('goldfinch/json-editor:client/dist/resources/assets/json-editor.js');
    }
}
