(function ($) {
	'use strict';

	/**
	 * All of the code for your public-facing JavaScript source
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

		document.querySelectorAll('.coding_blocks_temp_section').forEach(cb => {

			const isTrue = (val) => { return (val === 'true') }

			const id = cb.id;
			const content = cb.innerHTML.trim();
			const cbClass = cb.getAttribute("cb-code-snippet-class").trim();
			const cbCopy = isTrue(cb.getAttribute("cb-copy-btn"));
			//-------------------------------------

			const dFrag = document.createDocumentFragment();

			const codeBox = document.createElement('div');
			codeBox.id = id;
			codeBox.classList.add('coding-blocks-code');

			const codeHeader = document.createElement('div');
			codeHeader.classList.add('coding-blocks-code-header');

			const codeHeaderF = document.createElement('div');
			codeHeaderF.classList.add('coding-blocks-code-header-first');

			const cbFancy1 = document.createElement('p');
			cbFancy1.setAttribute('class', 'cb-round-fancy cb-round-danger');
			const cbFancy2 = document.createElement('p');
			cbFancy2.setAttribute('class', 'cb-round-fancy cb-round-warning');
			const cbFancy3 = document.createElement('p');
			cbFancy3.setAttribute('class', 'cb-round-fancy cb-round-primary');

			codeHeaderF.appendChild(cbFancy1);
			codeHeaderF.appendChild(cbFancy2);
			codeHeaderF.appendChild(cbFancy3);

			const codeHeaderL = document.createElement('div');
			codeHeaderL.classList.add('coding-blocks-code-header-last');

			codeHeader.appendChild(codeHeaderF);
			codeHeader.appendChild(codeHeaderL);

			//if user enabled copy button
			if (cbCopy) {
				const cbCopyBtn = document.createElement("p");
				cbCopyBtn.classList.add("cb-copy-btn");
				cbCopyBtn.setAttribute("cb-copy-snippet", id);
				cbCopyBtn.innerText = "Copy";
				codeHeaderL.appendChild(cbCopyBtn);
				//add event listener
				cbCopyBtn.addEventListener("click", function (e) {
					//prevent paarent elements from receiving event
					e.stopPropagation();

					const toCopy = document.querySelector('pre#pre_' + id + '').innerText.trim();
					if (toCopy.length !== 0) {
						window.navigator.clipboard.writeText(toCopy)
						.then( () => {
							alert("Code snippet has been copied");
						})
						.catch( () => {
							alert("Oops! an error is preventing you from copying this snippet 😢");
						});
						
					}
				})
			}

			const codeContent = document.createElement('div');
			codeContent.classList.add('coding-blocks-code-content');

			const pre = document.createElement('pre');
			pre.id = "pre_" + id;
			//decode the snippet twice
			let decodeIncr = 1;
			while (decodeIncr <= 2) {
				let text = cb__Decode__Entities(content);
				text.replace(/\\/g, "\\\\");

				//embed decoded text to pre element
				pre.innerHTML = text;
				decodeIncr++;
			}
			pre.setAttribute('class', 'prettyprint ' + cbClass);

			codeContent.appendChild(pre);

			codeBox.appendChild(codeHeader);
			codeBox.appendChild(codeContent);

			dFrag.appendChild(codeBox);
			//append code snippet
			cb.after(dFrag);
			//remove temp code snippet
			cb.remove();
			//Load Prettifier
			PR.prettyPrint();
		})
		
		//adjust theme color
		CBcore.adjustColor();
	});
})(jQuery);

//core class
class CodingBlocksCore {
	constructor() {
		//... nothing to witness here
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

//DECODE IT TWICE BECAUSE OF \'&AMP\' TAG

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

const CBcore = new CodingBlocksCore();