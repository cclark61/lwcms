//****************************************************************
// On Ready
//****************************************************************
$(document).ready(function()
{
	/*
	var myCodeMirror = CodeMirror.fromTextArea(
		document.getElementById("codemirror_editor"), {
			mode: "application/x-httpd-php",
			lineNumbers: true,
			tabMode: "classic",
			indentUnit: 4,
			indentWithTabs: true,
			electricChars: false,
			enterMode: "keep",
			onCursorActivity: function() {
				editor.setLineClass(hlLine, null);
				hlLine = editor.setLineClass(editor.getCursor().line, "activeline");
			}
		}
	);
	var hlLine = editor.setLineClass(0, "activeline");
	*/
	
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

