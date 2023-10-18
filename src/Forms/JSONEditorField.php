<?php

namespace Goldfinch\JSONEditor\Forms;

use SilverStripe\Forms\TextField;

class JSONEditorField extends TextField
{
    public function __construct($name, $title = null, $value = '{}', $form = null, $schema = '{}')
    {
        parent::__construct($name, $title, $value);

        //
    }
}
