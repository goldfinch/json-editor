Thanks to: https://github.com/bywatersolutions/silverstripe-jsoneditorfield

app/_schema/{$Classname}-{$FieldName}.json


```
{
    "type": "object",
    "properties": {
        "name": "John Doe"
    }
}

```

extension

```
App\Blocks\GridBlock:
  extensions:
    - Goldfinch\JSONEditor\Extensions\JsonDataExtension
```

```
<% with $Json.Parse %>
<% end_with %>
```
