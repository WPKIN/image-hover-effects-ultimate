/**
 * Parent Window Message Receiver
 * Receives button click messages from iframe and triggers appropriate actions
 * 
 * @package image-hover-effects-ultimate
 * @since 10.0.0
 */

(function($) {
    'use strict';
        // Listen for messages from iframe
    window.addEventListener('message', function(event) {
        
        // Verify message is from our iframe
        if (event.data && event.data.type === 'iframe-button-click') {
            
            var action = event.data.action;
            var itemId = event.data.itemId;
            
            // Check if actions are available
            if (window.oxiPreviewActions) {
                if (action === 'edit') {
                    window.oxiPreviewActions.edit(itemId);
                } else if (action === 'clone') {
                    window.oxiPreviewActions.clone(itemId);
                } else if (action === 'delete') {
                    window.oxiPreviewActions.delete(itemId);
                }
            } else {
                console.error('window.oxiPreviewActions not found!');
            }
        }
    });
    
})(jQuery);
