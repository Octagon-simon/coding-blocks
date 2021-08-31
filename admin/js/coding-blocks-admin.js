(function( $ ) {
	'use strict';

	/**
	 * All of the code for your admin-facing JavaScript source
	 * should reside in this file.
	 *
	 * Note: It has been assumed you will write jQuery code here, so the
	 * $ function reference has been prepared for usage within the scope
	 * of this function.
	 *
	 * This enables you to define handlers, for when the DOM is ready:
	 *
	 * $(function() {
	 *
	 * });
	 *
	 * When the window is loaded:
	 *
	 * $( window ).load(function() {
	 *
	 * });
	 *
	 * ...and/or other possibilities.
	 *
	 * Ideally, it is not considered best practise to attach more than a
	 * single DOM-ready or window-load handler for a particular page.
	 * Although scripts in the WordPress core, Plugins and Themes may be
	 * practising this, we should strive to set a better example in our own work.
	 */

	  
//Initiate clipboard js
var clipboard = new ClipboardJS('.copy-button');

if (clipboard) {
clipboard.on('success', function(e) {
    console.info('Action:', e.action);
    console.info('Text:', e.text);
    console.info('Trigger:', e.trigger);

    e.clearSelection();
    alert('Code Copied Successfully!');
});

clipboard.on('error', function(e) {
    console.error('Action:', e.action);
    console.error('Trigger:', e.trigger);
    alert('Oops! One or more Errors has occured. Select A style and try again');
});

}

PR.prettyPrint();  //Load Prettifier


//REMOVE DEFAULT PRETTIFIER CSS
var defaultPrettify = document.querySelectorAll('link');

for (var i = 0; i < defaultPrettify.length; i++) {
	var defaultPrettifySingle = defaultPrettify[i];
	var defaultPrettifySrc = defaultPrettifySingle.getAttribute("href");

	if (defaultPrettifySrc == 'https://cdn.jsdelivr.net/gh/google/code-prettify@master/loader/prettify.css') {
		defaultPrettifySingle.remove();
	}
}

//RESOLVE LANGUAGE PARAMS
const cbLang = [
	"lang-apollo", "lang-basic", "lang-cl", "lang-css", "lang-dart", "lang-erl",
	"lang-exs", "lang-go", "lang-hs", "lang-kotlin", "lang-latex", "lang-tex", "lang-lsp", "lang-scm",
	"lang-rkt", "lang-llvm", "lang-logtalk", "lang-lua", "lang-mk", "lang-mathlab", "lang-pascal", 
	"lang-proto", "lang-regex", "lang-sql", "lang-vb", "lang-yml"
	
];

cbLang.forEach(checkLangParam); 

function checkLangParam(item) { 
var cbPreElements = document.querySelectorAll('pre');

for (i = 0; i < cbPreElements.length; i++) {
var cbLangAttr = cbPreElements[i].getAttribute("class");

//Use IndexOf Due to (IE) browser compatibility 
	if (cbLangAttr.indexOf(item) !== -1){ 

		var cbLangScript = document.createElement("script");
		cbLangScript.setAttribute("id", "coding-blocks-"+item);
		cbLangScript.setAttribute("src", "../wp-content/plugins/coding-blocks/admin/lib/prettify/lang/"+item+".js");
		document.head.appendChild(cbLangScript);

	} 
	
else {
	// EMPTY SPACE /wp-content/plugins/coding-blocks/admin
}

}


}




})( jQuery );
