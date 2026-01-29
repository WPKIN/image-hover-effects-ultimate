/**
 * Overlay Scrollbar Implementation using OverlayScrollbars library
 * Creates true overlay scrollbars that don't create layout shift
 */
(function($) {
    'use strict';

    $(document).ready(function() {
        if (typeof OverlayScrollbarsGlobal === 'undefined') {
            console.warn('OverlayScrollbars library not loaded. Falling back to standard scrollbar.');
            return;
        }

        const { OverlayScrollbars } = OverlayScrollbarsGlobal;
        
        // Configuration for OverlayScrollbars
        const config = {
            scrollbars: {
                theme: 'os-theme-dark',
                visibility: 'auto',
                autoHide: 'leave',
                autoHideDelay: 100
            },
            overflow: {
                x: 'hidden',
                y: 'scroll'
            }
        };

        // Initialize for editor sidebar
        const wrapper = $('.oxi-addons-tabs-wrapper');
        if (wrapper.length) {
            OverlayScrollbars(wrapper[0], config);
        }

        // Initialize for preview iframe body (if we're inside an iframe)
        if (window.self !== window.top) {
            // We're in an iframe - apply to body
            OverlayScrollbars(document.body, config);
        }
    });
    
})(jQuery);
