import { JSONEditor } from '@json-editor/json-editor'
// var JSONEditor = ns.JSONEditor; // (for dev only)

var ss = ss || {};

window.jsoneditorSetDefaultValue = (e) =>
{
  var my_id = e.getAttribute('data-id');
  if (my_id) {
    var editorist = window.jsoneditor[my_id];
    var schema = window.jsoneditorschema[my_id];
    if (editorist) {
      console.log(schema.properties)
        editorist.setValue(schema.properties)
    }
  }
}

(function($) {
    $.entwine('ss', function($) {
        $('input.jsoneditorfield').entwine({
            // Constructor: onmatch
            onmatch: function() {
	      this.each( function() {
              var startval = this.value;
	      var schema = this.getAttribute('data-field-schema');
	      var fieldOptions = JSON.parse(this.getAttribute('data-field-options'));
	      var my_id = this.id;
	      var editorist = document.getElementById(this.id + "_Editor");

              var options = {
                ajax: true,
                schema: JSON.parse(schema),
                // required_by_default: true,
                disable_collapse: true,
                disable_properties: true,
                disable_edit_json: true,
                enable_array_copy: true,
                // no_additional_properties: true,
                theme: "bootstrap5",

                iconlib: 'bootstrap',
                // object_layout: 'normal',
                // show_errors: 'interaction',
              };

              if (startval && startval != '{}') {
                options.startval = JSON.parse(startval)
              }

              var editor = new JSONEditor(editorist, options);

              editor.on('ready',function() {

                  if (fieldOptions && fieldOptions.set_default_button) {

                    if (schema && schema != '' && schema != '{}' && JSON.parse(schema).type) {
                    if (!window.jsoneditor) {
                      window.jsoneditor = [];
                      window.jsoneditorschema = [];
                      window.jsoneditorfieldoptions = [];
                    }
                    window.jsoneditor[my_id] = editor;
                    window.jsoneditorschema[my_id] = JSON.parse(schema);
                    window.jsoneditorfieldoptions[my_id] = fieldOptions;

                    jQuery('#' + my_id).parent().prepend('<button data-id="'+my_id+'" onclick="window.jsoneditorSetDefaultValue(this)" type="button" title="Set Default value" class="btn btn-primary btn-sm"><i class="bi bi-pencil"></i><span> Set Default value</span></button>');
                  }
                }
              });

	      editor.on('change',function() {
        	var errors = editor.validate();
	        var indicator = document.getElementById('valid_indicator');
	        var save_button = document.getElementById('Form_ItemEditForm_action_doSave');
        	if(errors.length) {
	          indicator.style.color = 'red';
	          indicator.textContent = "not valid";
        	  save_button.disabled = true;
	          save_button.title = "JSON not valid; see console for details";
        	  console.log(errors);
        	}
	        else {
        	  indicator.style.color = 'green';
	          indicator.textContent = "valid";
        	  save_button.disabled = false;
	          save_button.title = '';
		  var input = document.getElementById(my_id);
	  	  input.value = JSON.stringify(editor.getValue());
        	}
              });
});
            }
        });
    });
}(jQuery));
