/* Guía configuración CKEditor
 * https://docs.ckeditor.com/ckeditor4/latest/guide/
 */
/* Configurador de barra herramientas
 * https://ckeditor.com/latest/samples/toolbarconfigurator/index.html#basic
 */
CKEDITOR.editorConfig = function( config ) {
	// Define changes to default configuration here. For example:
	config.language = 'es';
	// config.uiColor = '#AADC6E';
	config.entities_latin = false;
	/* https://ckeditor.com/latest/samples/toolbarconfigurator/index.html#basic */
	config.toolbarGroups = [
		{ name: 'document', groups: [ 'mode', 'document', 'doctools' ] },
		{ name: 'clipboard', groups: [ 'clipboard', 'undo' ] },
		{ name: 'editing', groups: [ 'find', 'selection', 'spellchecker', 'editing' ] },
		//{ name: 'forms', groups: [ 'forms' ] },
		'/',
		{ name: 'basicstyles', groups: [ 'basicstyles', 'cleanup' ] },
		{ name: 'paragraph', groups: [ 'list', 'indent', 'blocks', 'align', 'bidi', 'paragraph' ] },
		//{ name: 'links', groups: [ 'links' ] },
		//{ name: 'insert', groups: [ 'insert' ] },
		'/',
		{ name: 'styles', groups: [ 'styles' ] },
		{ name: 'colors', groups: [ 'colors' ] },
		{ name: 'tools', groups: [ 'tools' ] },
		{ name: 'others', groups: [ 'others' ] },
		{ name: 'about', groups: [ 'about' ] }
	];
	config.removeButtons = 'Save,NewPage,Preview,Print,Templates,Flash,Form';
};
