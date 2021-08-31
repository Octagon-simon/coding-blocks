//REMOVE DEFAULT PRETTIFIER CSS AGAIN
var defaultPrettify = document.querySelectorAll('link');

for (var i = 0; i < defaultPrettify.length; i++) {
	var defaultPrettifySingle = defaultPrettify[i];
	var defaultPrettifySrc = defaultPrettifySingle.getAttribute("href");

	if (defaultPrettifySrc == 'https://cdn.jsdelivr.net/gh/google/code-prettify@master/loader/prettify.css') {
		defaultPrettifySingle.remove();
	}
}

// THIS FUNCTION WILL DECODE IT TWICE BECAUSE OF \'&AMP\' TAG
	for  (var i = 0; i < 2 ; i++){
//DECODE HTML ENTITY
var decodeEntities = (function() {
  // this prevents any overhead from creating the object each time
  var element = document.createElement('div');

  function decodeHTMLEntities (str) {
    if(str && typeof str === 'string') {
      // strip script/html tags
      str = str.replace(/<script[^>]*>([\S\s]*?)<\/script>/gmi, '');
      str = str.replace(/<\/?\w(?:[^"'>]|"[^"]*"|'[^']*')*>/gmi, '');
      element.innerHTML = str;
      str = element.textContent;
      element.textContent = '';
    }

    return str;
  }

  return decodeHTMLEntities;
})();

}

