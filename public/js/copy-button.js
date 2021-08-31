window.onload = ()=> {
    
//REMOVE DEFAULT PRETTIFIER CSS AGAIN
var defaultPrettify = document.querySelectorAll('link');

for (var i = 0; i < defaultPrettify.length; i++) {
	var defaultPrettifySingle = defaultPrettify[i];
	var defaultPrettifySrc = defaultPrettifySingle.getAttribute("href");

	if (defaultPrettifySrc == 'https://cdn.jsdelivr.net/gh/google/code-prettify@master/loader/prettify.css') {
		defaultPrettifySingle.remove();
	}
}
//ADD COPY FEATURE     

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

}