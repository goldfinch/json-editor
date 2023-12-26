import { JSONEditor } from '@json-editor/json-editor';
// var JSONEditor = ns.JSONEditor; // (for dev only)

var ss = ss || {};

window.jsoneditorSetDefaultValue = (e) => {
  const my_id = e.getAttribute('data-id');
  if (my_id) {
    const editorist = window.jsoneditor[my_id];
    const schema = window.jsoneditorschema[my_id];
    if (editorist) {
      console.log(schema.properties);
      editorist.setValue(schema.properties);
    }
  }
};

(function ($) {
  $.entwine('ss', ($) => {
    $('input.jsoneditorfield').entwine({
      // Constructor: onmatch
      onmatch() {
        this.each(function () {
          const startval = this.value;
          const schema = this.getAttribute('data-field-schema');
          const fieldOptions = JSON.parse(
            this.getAttribute('data-field-options'),
          );
          const my_id = this.id;

          const editorist = document.getElementById(
            jQuery(this).parent().find('.json-editor').attr('id'),
          ); // this.id + "_Editor"

          const options = {
            ajax: true,
            schema: JSON.parse(schema),
            // required_by_default: true,
            disable_collapse: true,
            disable_properties: true,
            disable_edit_json: true,
            enable_array_copy: true,
            // no_additional_properties: true,
            theme: 'bootstrap5',

            iconlib: 'bootstrap',
            // object_layout: 'normal',
            // show_errors: 'interaction',
          };

          if (startval && startval != '{}') {
            options.startval = JSON.parse(startval);
          }

          const editor = new JSONEditor(editorist, options);

          editor.on('ready', () => {
            if (fieldOptions && fieldOptions.set_default_button) {
              if (
                schema &&
                schema != '' &&
                schema != '{}' &&
                JSON.parse(schema).type
              ) {
                if (!window.jsoneditor) {
                  window.jsoneditor = [];
                  window.jsoneditorschema = [];
                  window.jsoneditorfieldoptions = [];
                }
                window.jsoneditor[my_id] = editor;
                window.jsoneditorschema[my_id] = JSON.parse(schema);
                window.jsoneditorfieldoptions[my_id] = fieldOptions;

                jQuery(`#${my_id}`)
                  .parent()
                  .prepend(
                    `<button data-id="${my_id}" onclick="window.jsoneditorSetDefaultValue(this)" type="button" title="Set Default value" class="btn btn-primary btn-sm"><i class="bi bi-pencil"></i><span> Set Default value</span></button>`,
                  );
              }
            }
          });

          editor.on('change', () => {
            const errors = editor.validate();
            const indicator = document.getElementById('valid_indicator');
            let save_button = document.getElementById(
              'Form_ItemEditForm_action_doSave',
            );

            if (!save_button) {
              save_button = document.getElementById(
                'Form_EditForm_action_save',
              );

              if (!save_button) {
                save_button = document.getElementById(
                  'Form_EditForm_action_save_siteconfig',
                );
              }
            }

            if (!save_button) {
              console.error(
                "JSON editor: can's save json data due to the unrecognized action button ID on this page, see json-editor.js and extend if needed",
              );
            }

            if (save_button) {
              if (errors.length) {
                indicator.style.color = 'red';
                indicator.textContent = 'not valid';
                save_button.disabled = true;
                save_button.title = 'JSON not valid; see console for details';
                console.log(errors);
              } else {
                indicator.style.color = 'green';
                indicator.textContent = 'valid';
                save_button.disabled = false;
                save_button.title = '';
                const input = document.getElementById(my_id);
                input.value = JSON.stringify(editor.getValue());
              }
            }
          });
        });
      },
    });
  });
})(jQuery);
