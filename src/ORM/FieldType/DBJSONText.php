<?php

namespace Goldfinch\JSONEditor\ORM\FieldType;

use SilverStripe\ORM\FieldType\DBText;

class DBJSONText extends DBText
{
    public function Parse()
    {
        $string = $this->value;

        if (!$string)
        {
            return $string;
        }

        $array = ss_template_json_parser($string);

        return ss_viewable_parser($array);
    }
}
