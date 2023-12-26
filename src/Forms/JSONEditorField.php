<?php

namespace Goldfinch\JSONEditor\Forms;

use ReflectionClass;
use Composer\InstalledVersions;
use SilverStripe\Forms\TextField;
use SilverStripe\View\Requirements;

class JSONEditorField extends TextField
{
    public function __construct(
        $name,
        $title = null,
        $parent = null,
        $options = [],
        $value = '{}',
        $form = null,
        $schema = '{}',
    ) {
        $classname = (new ReflectionClass($parent))->getShortName();
        $defaultSchema =
            BASE_PATH . '/app/_schema/' . $classname . '-' . $name . '.json';

        // if ($schema != '{}' && file_exists($defaultSchema)) // ! double check: `$schema != '{}'` removed
        if (file_exists($defaultSchema)) {
            $schema = file_get_contents($defaultSchema);
        }

        if ($schema === '') {
            $schema = '{}';
        }

        $value = '{}';

        parent::__construct($name, $title, $value);
        // parent::__construct($name, $title, $value, '', $form);

        Requirements::css(
            'goldfinch/json-editor:client/dist/resources/assets/json-editor-style.css',
        );
        if (InstalledVersions::isInstalled('goldfinch/enchantment')) {
            Requirements::css(
                'https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.2/font/bootstrap-icons.min.css',
            );
        }
        Requirements::javascript(
            'goldfinch/json-editor:client/dist/resources/assets/json-editor.js',
        );

        // "format": "xhtml" or "format": "bbcode"
        // Requirements::css('https://cdn.jsdelivr.net/npm/sceditor@2.1.3/minified/themes/default.min.css');
        // Requirements::javascript('https://cdn.jsdelivr.net/npm/sceditor@2.1.3/minified/sceditor.min.js');
        // Requirements::javascript('https://cdn.jsdelivr.net/npm/sceditor@2.1.3/minified/formats/bbcode.js');
        // Requirements::javascript('https://cdn.jsdelivr.net/npm/sceditor@2.1.3/minified/formats/xhtml.js');

        // "format": "jodit"
        Requirements::css(
            'goldfinch/json-editor:client/lib/jodit/jodit.min.css',
        );
        Requirements::javascript(
            'goldfinch/json-editor:client/lib/jodit/jodit.min.js',
        );
        // "about": {
        //     "type": "string",
        //     "title": "About me",
        //     "format": "jodit"
        // }

        // "format": "markdown"
        // ..

        // "format": "rating"
        // ..

        // "format": "autocomplete"
        // ..

        // "format": "select2"
        // Requirements::css('https://cdn.jsdelivr.net/npm/select2@latest/dist/css/select2.min.css');
        // Requirements::javascript('https://cdn.jsdelivr.net/npm/select2@latest/dist/js/select2.min.js');
        Requirements::css(
            'goldfinch/json-editor:client/lib/select2/select2.min.css',
        );
        Requirements::javascript(
            'goldfinch/json-editor:client/lib/select2/select2.min.js',
        );
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
        // Requirements::customCSS(<<<CSS

        //   CSS
        // );

        // choiser
        // Requirements::css('https://cdn.jsdelivr.net/npm/choices.js/public/assets/styles/choices.min.css');
        // Requirements::javascript('https://cdn.jsdelivr.net/npm/choices.js/public/assets/scripts/choices.min.js');

        $this->addExtraClass('jsoneditorfield');
        $this->setInputType('hidden');
        $this->setAttribute('data-field-schema', $schema);
        $this->setAttribute('data-field-options', json_encode($options));
    }
}
