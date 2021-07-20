jQuery( document ).ready( function( $ ) {

 //ADD COPY FEATURE   

var pre = document.querySelectorAll('pre');
   var codeHeader = document.querySelectorAll(".code-header");
for (var i = 0; i < pre.length; i++) {
    var target = pre[i].id;
            var button = document.createElement('button');
                    button.setAttribute("data-clipboard-target", '#'+target);
                    button.setAttribute("data-toggle", "tooltip");
                    button.setAttribute("title", "Click to Copy");
                    button.setAttribute("class", "copy-button tag button is-success is-outlined");
                    button.style.float="right";
                    button.innerHTML = '<i class="fas fa-copy">';
                     codeHeader[i].appendChild(button);
                   }
var clip = 'clipboard'+target;
            clip = new ClipboardJS('.copy-button');         

if (clip) {
clip.on('success', function(e) {
    console.info('Action:', e.action);
    console.info('Text:', e.text);
    console.info('Trigger:', e.trigger);

    e.clearSelection();
    alert('Code Copied Successfully!');
});

clip.on('error', function(e) {
    console.error('Action:', e.action);
    console.error('Trigger:', e.trigger);
    alert('Oops! One or more Errors has occured. Select A style and try again');
});
}
})