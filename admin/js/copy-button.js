window.onload = ()=> {
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