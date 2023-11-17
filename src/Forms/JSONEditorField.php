<?php

namespace Goldfinch\JSONEditor\Forms;

use ReflectionClass;
use SilverStripe\Forms\TextField;
use SilverStripe\View\Requirements;

class JSONEditorField extends TextField
{
    public function __construct($name, $title = null, $parent = null, $options = [], $value = '{}', $form = null, $schema = '{}')
    {
        $classname = (new ReflectionClass($parent))->getShortName();
        $defaultSchema = BASE_PATH . '/app/_schema/' . $classname . '-' . $name . '.json';

        if ($schema != '{}' && file_exists($defaultSchema))
        {
            $schema = file_get_contents($defaultSchema);
        }

        if ($schema === '')
        {
            $schema = '{}';
        }

        $value = '{}';

        parent::__construct($name, $title, $value);
        // parent::__construct($name, $title, $value, '', $form);

        Requirements::css('goldfinch/json-editor:client/dist/resources/assets/json-editor-style.css');
        Requirements::javascript('goldfinch/json-editor:client/dist/resources/assets/json-editor.js');

        // "format": "xhtml" or "format": "bbcode"
        // Requirements::css('https://cdn.jsdelivr.net/npm/sceditor@2.1.3/minified/themes/default.min.css');
        // Requirements::javascript('https://cdn.jsdelivr.net/npm/sceditor@2.1.3/minified/sceditor.min.js');
        // Requirements::javascript('https://cdn.jsdelivr.net/npm/sceditor@2.1.3/minified/formats/bbcode.js');
        // Requirements::javascript('https://cdn.jsdelivr.net/npm/sceditor@2.1.3/minified/formats/xhtml.js');

        // "format": "jodit"
        // Requirements::css('https://unpkg.com/jodit@4.0.0-beta.24/es2021/jodit.min.css');
        // Requirements::javascript('https://unpkg.com/jodit@4.0.0-beta.24/es2021/jodit.min.js');

        // "format": "markdown"
        // ..

        // "format": "rating"
        // ..

        // "format": "autocomplete"
        // ..

        // "format": "select2"
        Requirements::css('https://cdn.jsdelivr.net/npm/select2@latest/dist/css/select2.min.css');
        Requirements::javascript('https://cdn.jsdelivr.net/npm/select2@latest/dist/js/select2.min.js');
        // "color": {
        //   "type": "array",
        //   "format": "select2",
        //   "uniqueItems": true,
        //   "options": {
        //     "select2": {}
        //   },
        //   "items": {
        //     "type": "string",
        //     "enum": ["black","red","green","blue","yellow","orange","purple","brown","white","cyan","maagenta"]
        //   }
        // },
        Requirements::customCSS(<<<CSS
          .json-editor .select2-hidden-accessible + .chosen-container {
            display: none;
          }
          CSS
        );

        Requirements::customCSS(<<<CSS
          .as-none-object {
            width: 100%;
          }
          .as-none-object .card-title {
            display: none !important;
          }
          .as-none-object .card-body {
            margin-top: 0 !important;
          }
          .as-none-object *:after {
            display: none !important;
          }
          CSS
        );

        // choiser
        // Requirements::css('https://cdn.jsdelivr.net/npm/choices.js/public/assets/styles/choices.min.css');
        // Requirements::javascript('https://cdn.jsdelivr.net/npm/choices.js/public/assets/scripts/choices.min.js');

        $this->addExtraClass('jsoneditorfield');
        $this->setInputType('hidden');
        $this->setAttribute('data-field-schema', $schema);
        $this->setAttribute('data-field-options', json_encode($options));
    }
}
