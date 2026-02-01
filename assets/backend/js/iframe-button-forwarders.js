/**
 * Iframe Button Click Forwarder
 * Forwards Edit/Clone/Del button clicks from iframe to parent window
 * 
 * @package image-hover-effects-ultimate
 * @since 10.0.0
 */

(function($) {
    'use strict';
    
    // Wait for DOM ready
    $(document).ready(function() {
        
        // Check if we're inside an iframe
        if (window.parent !== window) {
            
            // Delegate click events for Edit button
            $(document).on('click', '.shortcode-addons-template-item-edit', function(e) {
                e.preventDefault();
                e.stopPropagation();
                
                var itemId = $(this).attr('value');
                
                window.parent.postMessage({
                    type: 'iframe-button-click',
                    action: 'edit',
                    itemId: itemId
                }, '*');
                
            });
            
            // Delegate click events for Clone button
            $(document).on('click', '.shortcode-addons-template-item-clone', function(e) {
                e.preventDefault();
                e.stopPropagation();
                
                var itemId = $(this).attr('value');
                
                window.parent.postMessage({
                    type: 'iframe-button-click',
                    action: 'clone',
                    itemId: itemId
                }, '*');
                
            });
            
            // Delegate click events for Delete button
            $(document).on('click', '.shortcode-addons-template-item-delete', function(e) {
                e.preventDefault();
                e.stopPropagation();
                
                var itemId = $(this).attr('value');
                
                window.parent.postMessage({
                    type: 'iframe-button-click',
                    action: 'delete',
                    itemId: itemId
                }, '*');
                
            });
            
        }
    });
    
})(jQuery);
