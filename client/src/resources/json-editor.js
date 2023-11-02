import { JSONEditor } from '@json-editor/json-editor'
// var JSONEditor = ns.JSONEditor; // (for dev only)

var ss = ss || {};

function setDefaultValue(e)
{
  var my_id = e.getAttribute('data-id');
  if (my_id) {
    var editorist = window.jsoneditor[my_id];
    var schema = window.jsoneditorschema[my_id];
    if (editorist) {
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
	      var my_id = this.id;
	      var editorist = document.getElementById(this.id + "_Editor");

              var editor = new JSONEditor(editorist, {
                ajax: true,
                schema: JSON.parse(schema),
                startval: startval ? JSON.parse(startval) : '',
                // disable_collapse: true,
                // required_by_default: true,
                // disable_properties: true,
                // disable_edit_json: true,
                // no_additional_properties: true,
                theme: "bootstrap5",

                iconlib: 'bootstrap',
                object_layout: 'normal',
                show_errors: 'interaction',
              });

              editor.on('ready',function() {
                if (!window.jsoneditor) {
                  window.jsoneditor = [];
                  window.jsoneditorschema = [];
                }
                window.jsoneditor[my_id] = editor;
                window.jsoneditorschema[my_id] = JSON.parse(schema);

                jQuery('#' + my_id).parent().prepend('<button data-id="'+my_id+'" onclick="setDefaultValue(this)" type="button" title="Set Default value" class="btn btn-primary btn-sm"><i class="bi bi-pencil"></i><span> Set Default value</span></button>');
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
