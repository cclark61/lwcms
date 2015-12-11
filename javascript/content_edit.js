tinyMCE.init({
	mode : "specific_textareas",
	editor_selector : "mceEditor",
	theme : "modern",
	plugins: [
        "advlist autolink lists link image charmap print preview anchor media",
        "searchreplace visualblocks code fullscreen",
        "insertdatetime media table contextmenu paste moxiemanager" // moxiemanager
    ],
    toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image",
   	inline_styles : "true",
    relative_urls : false,
	invalid_elements : "font"

});
