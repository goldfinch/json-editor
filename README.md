
# 🦅 JSON Editor Field for Silverstripe

[![Silverstripe Version](https://img.shields.io/badge/Silverstripe-5.1-005ae1.svg?labelColor=white&logoColor=ffffff&logo=data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHZpZXdCb3g9IjAgMCAxMDEuMDkxIDU4LjU1NSIgZmlsbD0iIzAwNWFlMSIgeG1sbnM6dj0iaHR0cHM6Ly92ZWN0YS5pby9uYW5vIj48cGF0aCBkPSJNNTAuMDE1IDUuODU4bC0yMS4yODMgMTQuOWE2LjUgNi41IDAgMCAwIDcuNDQ4IDEwLjY1NGwyMS4yODMtMTQuOWM4LjgxMy02LjE3IDIwLjk2LTQuMDI4IDI3LjEzIDQuNzg2czQuMDI4IDIwLjk2LTQuNzg1IDI3LjEzbC02LjY5MSA0LjY3NmM1LjU0MiA5LjQxOCAxOC4wNzggNS40NTUgMjMuNzczLTQuNjU0QTMyLjQ3IDMyLjQ3IDAgMCAwIDUwLjAxNSA1Ljg2MnptMS4wNTggNDYuODI3bDIxLjI4NC0xNC45YTYuNSA2LjUgMCAxIDAtNy40NDktMTAuNjUzTDQzLjYyMyA0Mi4wMjhjLTguODEzIDYuMTctMjAuOTU5IDQuMDI5LTI3LjEyOS00Ljc4NHMtNC4wMjktMjAuOTU5IDQuNzg0LTI3LjEyOWw2LjY5MS00LjY3NkMyMi40My0zLjk3NiA5Ljg5NC0uMDEzIDQuMTk4IDEwLjA5NmEzMi40NyAzMi40NyAwIDAgMCA0Ni44NzUgNDIuNTkyeiIvPjwvc3ZnPg==)](https://packagist.org/packages/spatie/schema-org)
[![Package Version](https://img.shields.io/packagist/v/goldfinch/json-editor.svg?labelColor=333&color=F8C630&label=Version)](https://packagist.org/packages/spatie/schema-org)
[![Total Downloads](https://img.shields.io/packagist/dt/goldfinch/json-editor.svg?labelColor=333&color=F8C630&label=Downloads)](https://packagist.org/packages/spatie/schema-org)
[![License](https://img.shields.io/packagist/l/goldfinch/json-editor.svg?labelColor=333&color=F8C630&label=License)](https://packagist.org/packages/spatie/schema-org) 

Indispensable tool to work with JSON data. Makes it easy to handle any JSON schema in a user-friendly interface and adjusts the output for Silverstripe templates.

This module is using [json-editor](https://github.com/json-editor/json-editor) under the hood. Refer to its [README](https://github.com/json-editor/json-editor/blob/master/README.md) to learn more about JSON Schema, all field types, properties, and available options that you can use.

![Screenshot](screenshots/json-editor.jpeg)

## Install

```
composer require goldfinch/json-editor
```

## Usage

```php
use Goldfinch\JSONEditor\Forms\JSONEditorField;
use Goldfinch\JSONEditor\ORM\FieldType\DBJSONText;

private static $db = [
    'Json' => DBJSONText::class,
];

public function getCMSFields()
{
    $fields = parent::getCMSFields();

    $fields->addFieldsToTab(
        'Root.Main',
        [
            JSONEditorField::create('Json', 'Json', $this),
        ]
    );
    
    return $fields;
}
```

✳️ You can also use an extension instead.

```xml
Page:
  extensions:
    - Goldfinch\JSONEditor\Extensions\JsonDataExtension
```

Each JSON field must have a schema file. Schema files are stored within `app/_schema` directory.

Based on the example above, we can say that our `Page.php` has `Json` field, therefore our schema file should be named as `Page-Json.json` following `{class_name}-{field_name}.json` pattern.

Example:

#### 1) Create schema file

Use [**Taz**](https://github.com/goldfinch/taz)🌪️ to generate our schema file.

```bash
php taz make:json-schema
```

If you haven't used [**Taz**](https://github.com/goldfinch/taz)🌪️ before, *taz* file must be in your root project folder to be able to use the command above. Just copy it first:

```bash
cp vendor/goldfinch/taz/taz taz
```

#### 2) Output JSON data in Silverstripe template.

At this step, we can go and add some JSON data in CMS to play with. Once we are done, we can output our pure JSON data using familiar Silverstripe syntax.

```html
<% with $Json.Parse %>
    <% loop Me %>
        <div><strong>First name:</strong> $firstname</div>
        <div><strong>Last name:</strong> $lastname</div>
        <div><strong>Cars:</strong> <% loop cars %><% if not IsFirst %>, <% end_if %>$Me<% end_loop %></div>
        <div><strong>About:</strong> $about</div>
    <% end_loop %>
<% end_with %>
```

## License

The MIT License (MIT)
