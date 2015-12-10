//****************************************************************
// On Ready
//****************************************************************
$(document).ready(function()
{
	var editor = CodeMirror.fromTextArea(document.getElementById("codemirror_editor"), {
	  mode: "css",
	  lineNumbers: true,
	  lineWrapping: true,
	  onCursorActivity: function() {
	    editor.setLineClass(hlLine, null);
	    hlLine = editor.setLineClass(editor.getCursor().line, "activeline");
	  }
	});
	var hlLine = editor.setLineClass(0, "activeline");

});

