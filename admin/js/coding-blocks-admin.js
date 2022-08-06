(function ($) {
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
	$(window).load(function () {

		PR.prettyPrint();  //Load Prettifier

		//REMOVE DEFAULT PRETTIFIER CSS
		document.querySelectorAll('link').forEach(li => {
			if (li.href === "https://cdn.jsdelivr.net/gh/google/code-prettify@master/loader/prettify.css") {
				li.remove();
			}
		});

		//RESOLVE LANGUAGE PARAMS
		const cbLang = [
			"lang-apollo", "lang-basic", "lang-cl", "lang-css", "lang-dart", "lang-erl",
			"lang-exs", "lang-go", "lang-hs", "lang-kotlin", "lang-latex", "lang-tex", "lang-lsp", "lang-scm",
			"lang-rkt", "lang-llvm", "lang-logtalk", "lang-lua", "lang-mk", "lang-mathlab", "lang-pascal",
			"lang-proto", "lang-regex", "lang-sql", "lang-vb", "lang-yml"

		];

		cbLang.forEach(checkLangParam);

		function checkLangParam(item) {
			document.querySelectorAll('pre').forEach(cbPre => {
				//check if class exists n the list of supported classes
				if (cbPre.classList.contains(item)) {
					const cbLangScript = document.createElement("script");
					cbLangScript.setAttribute("id", "coding-blocks-" + item);
					cbLangScript.setAttribute("src", "../wp-content/plugins/coding-blocks/admin/lib/prettify/lang/" + item + ".js");
					document.head.appendChild(cbLangScript);
				}
			});
		}
		//Rename first child of coding blocks menu
		document.querySelectorAll('.wp-first-item .wp-first-item').forEach(m => {
			if(m.innerText == "Coding Blocks"){
				m.innerText = "Get Started";
				return;
			}
		});
		//remove admin notices from coing blocks pages
		document.querySelectorAll('.wrap').forEach(w=>{
			//check if wrap element has coding blocks as its id
			if(w.id.match(/coding-blocks/i)){
				//select all notice tabs and remove
				document.querySelectorAll('.notice').forEach(n => {
					n.remove();
				})
			}
		})
	});
})(jQuery);

//core class
class CodingBlocksCore {
	constructor() {
		//... nothing to witness here
	}
	//show modal
	showModal(modalId = undefined) {
		if (modalId !== undefined) {
			return (document.getElementById(modalId).classList.add("is-active"));
		}
		return;
	}
	//hide modal
	hideModal(modalId = undefined) {
		if (modalId !== undefined) {
			return (document.getElementById(modalId).classList.remove("is-active"));
		}
	}
	//changes both the headerand copy button's color
	adjustColor() {
		/* change header color */
		//check if elem exists to avoid error
		if (this.findElem('pre')) {
			//collect background-color from pre element
			const bgColor = getComputedStyle(document.documentElement.querySelector('pre')).backgroundColor;
			document.querySelectorAll('.coding-blocks-code-header').forEach(ch => {
				ch.style.backgroundColor = bgColor;
			});
		}


		/** change copy button color */
		//check if elem exists to avoid error
		if (this.findElem('pre .kwd') || this.findElem('pre .tag')) {
			//get color of the keyword (kwd) class and use it on copy button.. GENIUS :) 
			const copyColor = (document.documentElement.querySelector('pre .kwd')) ? getComputedStyle(document.documentElement.querySelector('pre .kwd')).color :
			(document.documentElement.querySelector('pre .tag')) ? getComputedStyle(document.documentElement.querySelector('pre .tag')).color : null;

			if(copyColor !== null){
				document.querySelectorAll('.cb-copy-btn').forEach(ch => {
					ch.style.color = copyColor;
				});
			}
			
		}
	}

	findElem(elem) {
		return (document.querySelector(elem) !== null);
	}
}

//DECODE HTML ENTITY
var cb__Decode__Entities = (function () {
	// this prevents any overhead from creating the object each time
	var element = document.createElement('div');
	function decodeHTMLEntities(str) {
		if (str && typeof str === 'string') {
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