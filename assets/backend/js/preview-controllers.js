/**
 * Preview Controller
 * Manages iframe-based preview with device switching and live style updates
 *
 * @package image-hover-effects-ultimate
 * @since 10.0.0
 */

(function($) {
    'use strict';

    window.PreviewController = {
        iframe: null,
        iframeDoc: null,
        iframeWindow: null,
        currentDevice: 'desktop',
        isIframeReady: false,
        resizeObserver: null,
        styleCache: {
            desktop: '',
            tablet: '',
            mobile: ''
        },
        pendingStyles: [],

        /**
         * Initialize the preview controller
         */
        init: function() {
            this.iframe = document.getElementById('oxi-preview-iframe');
            
            if (!this.iframe) {
                // Retry in 500ms
                var self = this;
                setTimeout(function() {
                    self.init();
                }, 500);
                return;
            }
            
            this.waitForIframeLoad();
        },

        /**
         * Wait for iframe to load completely
         */
        waitForIframeLoad: function() {
            const self = this;
            
            // Check if already loaded
            if (this.iframe.contentDocument && this.iframe.contentDocument.readyState === 'complete') {
                this.onIframeLoad();
                return;
            }

            $(this.iframe).on('load', function() {
                self.onIframeLoad();
            });
        },

        /**
         * Handle iframe load completion
         */
        onIframeLoad: function() {
            try {
                this.iframeWindow = this.iframe.contentWindow;
                this.iframeDoc = this.iframe.contentDocument || this.iframeWindow.document;
                this.isIframeReady = true;

                this.applyIframeScrollbarStyles();

                // Process any pending styles
                this.processPendingStyles();

                // Setup resize observer
                this.setupResizeObserver();
                
                // Initial resize
                this.resizeIframe();
                if (this.currentDevice === 'mobile' || this.currentDevice === 'tablet') {
                    this.updateMobileTabletViewportHeight();
                }
                
            } catch (error) {
                console.error('Error in onIframeLoad:', error);
            }
        },

        /**
         * Switch preview device
         * @param {string} device - desktop, tablet, or mobile
         */
        switchDevice: function(device) {
            if (!device || !['desktop', 'tablet', 'mobile'].includes(device)) {
                console.error('Invalid device:', device);
                return;
            }

            this.currentDevice = device;
            
            // Update wrapper data attribute
            const $wrapper = $('#oxi-preview-wrapper');
           
            if ($wrapper.length) {
                $wrapper.attr('data-device', device);
            } else {
                console.error('Preview wrapper not found!');
            }

            // Update active button state
            $('.oxi-device-btn').removeClass('active');
            $('.oxi-device-btn[data-device="' + device + '"]').addClass('active');

            // Handle main browser scrollbar based on device
            if (device === 'mobile' || device === 'tablet') {
                $('html, body').css('overflow', 'hidden');
                this.updateMobileTabletViewportHeight();
                $('#oxi-preview-wrapper').css({ 'overflow': 'hidden' });
                if (this.iframeDoc && this.iframeDoc.body && this.iframeDoc.documentElement) {
                    this.iframeDoc.documentElement.style.overflow = 'auto';
                    this.iframeDoc.body.style.overflow = 'auto';
                }
                this.applyIframeScrollbarStyles();

            } else {
                $('html, body').css('overflow', 'hidden');
                $('#oxi-preview-wrapper').css({ 'height': '', 'overflow': '' });
                if (this.iframe) { this.iframe.style.height = ''; }
                if (this.iframeDoc && this.iframeDoc.body && this.iframeDoc.documentElement) {
                    this.iframeDoc.documentElement.style.overflow = '';
                    this.iframeDoc.body.style.overflow = '';
                }
            }

            this.resizeIframe();
        },

        updateMobileTabletViewportHeight: function() {
            const $wrapper = $('#oxi-preview-wrapper');
            if (!$wrapper.length) return;
            const rect = $wrapper[0].getBoundingClientRect();
            const viewportH = window.innerHeight || document.documentElement.clientHeight;
            const available = Math.max(200, Math.floor(viewportH - rect.top - 16));
            $wrapper.css('height', available + 'px');
            if (this.iframe) {
                this.iframe.style.height = available + 'px';
            }
        },

        applyIframeScrollbarStyles: function() {
            if (!this.iframeDoc) { return; }
            try {
                var style = this.iframeDoc.getElementById('oxi-iframe-scrollbar-style');
                if (!style) {
                    style = this.iframeDoc.createElement('style');
                    style.id = 'oxi-iframe-scrollbar-style';
                    style.type = 'text/css';
                    style.textContent = ''
                        + 'html,body{scrollbar-gutter:stable both-edges;scrollbar-width:thin;scrollbar-color:transparent transparent;}'
                        + 'html:hover,body:hover{scrollbar-color:#555 transparent;}'
                        + '::-webkit-scrollbar{width:8px;height:8px;}'
                        + '::-webkit-scrollbar-track{background:transparent;}'
                        + '::-webkit-scrollbar-thumb{background-color:transparent;border-radius:4px;}'
                        + 'html:hover::-webkit-scrollbar-thumb,body:hover::-webkit-scrollbar-thumb{background-color:#555;}';
                    this.iframeDoc.head.appendChild(style);
                }
            } catch (e) {}
        },

        setupResizeObserver: function() {
            if (!this.isIframeReady || !this.iframeDoc) {
                return;
            }

            if (this.resizeObserver) {
                this.resizeObserver.disconnect();
            }

            const self = this;
            
            try {
                this.resizeObserver = new ResizeObserver(entries => {
                    self.resizeIframe();
                });

                if (this.iframeDoc.body) {
                    const wrapper = this.iframeDoc.getElementById('oxi-addons-preview-data');
                    if (wrapper) {
                        this.resizeObserver.observe(wrapper);
                    } else {
                        // Fallback
                        this.resizeObserver.observe(this.iframeDoc.body);
                    }
                }

            } catch (error) {
                console.warn('ResizeObserver not supported or error:', error);
            }
        },

        resizeIframe: function() {
            if (!this.iframe || !this.iframeDoc) {
                return;
            }

            if (this.currentDevice === 'desktop') {
                if (this.resizeObserver) {
                    this.resizeObserver.disconnect();
                }

                try {
                    const wrapper = this.iframeDoc.getElementById('oxi-addons-preview-data');
                    
                    let height = 0;

                    if (wrapper) {
                         // Get precise content height
                        height = wrapper.getBoundingClientRect().height + 60; // 40px padding + 20px buffer
                    } else {
                        // Fallback
                         const body = this.iframeDoc.body;
                         const html = this.iframeDoc.documentElement;
                         if (body && html) {
                            height = Math.max(
                                body.scrollHeight,
                                body.offsetHeight,
                                html.clientHeight,
                                html.scrollHeight,
                                html.offsetHeight
                            );
                         }
                    }

                    if (height > 0) {
                        this.iframe.style.height = height + 'px';
                    } else {
                        this.iframe.style.height = '500px';
                    }

                } catch (error) {
                    console.error('Error resizing iframe:', error);
                }

                this.setupResizeObserver();
            } else {
                if (this.resizeObserver) {
                    this.resizeObserver.disconnect();
                }

                this.iframe.style.height = ''; 
                
                 if (this.iframeDoc.body) {
                         this.iframeDoc.body.style.overflow = '';
                    }
                     if (this.iframeDoc.documentElement) {
                         this.iframeDoc.documentElement.style.overflow = '';
                    }
            }
        },

        injectStyles: function(css, selector, responsive) {

            if (!this.isIframeReady) {
                this.pendingStyles.push({ css: css, selector: selector, responsive: responsive });
                return;
            }

            let device = responsive;
            if (device !== 'tab' && device !== 'mobile') {
                device = 'desktop';
            } else if (device === 'tab') {
                device = 'tablet';
            }

            let styleString = '';

            if (device === 'tablet') {
                styleString = '@media only screen and (min-width: 669px) and (max-width: 993px) { ' + 
                             selector + ' { ' + css + ' } }';
            } else if (device === 'mobile') {
                styleString = '@media only screen and (max-width: 668px) { ' + 
                             selector + ' { ' + css + ' } }';
            } else {
                styleString = selector + ' { ' + css + ' }';
            }

            this.styleCache[device] += styleString + '\n';

            this.updateIframeStyles();
        },

        processPendingStyles: function() {
            if (this.pendingStyles.length === 0) {
                return;
            }
            this.pendingStyles.forEach(function(style) {
                this.injectStyles(style.css, style.selector, style.responsive);
            }, this);

            this.pendingStyles = [];
        },

        updateIframeStyles: function() {
            if (!this.isIframeReady || !this.iframeDoc) {
                return;
            }

            try {
                let styleTag = this.iframeDoc.getElementById('ih-dynamic-styles');
                
                if (!styleTag) {
                    styleTag = this.iframeDoc.createElement('style');
                    styleTag.id = 'ih-dynamic-styles';
                    this.iframeDoc.head.appendChild(styleTag);
                }

                const allStyles = this.styleCache.desktop + 
                                 this.styleCache.tablet + 
                                 this.styleCache.mobile;

                styleTag.textContent = allStyles;

            } catch (error) {
                console.error('Error updating iframe styles:', error);
            }
        },

        clearStyles: function() {
            this.styleCache = {
                desktop: '',
                tablet: '',
                mobile: ''
            };
            this.updateIframeStyles();
        },

        reloadPreview: function() {
            if (this.iframe) {
                this.isIframeReady = false;
                this.clearStyles();
                
                // Update timestamp to force fresh reload
                var src = this.iframe.src;
                var newSrc = '';
                if (src.indexOf('t=') > -1) {
                    newSrc = src.replace(/t=\d+/, 't=' + Date.now());
                } else {
                    newSrc = src + (src.indexOf('?') > -1 ? '&' : '?') + 't=' + Date.now();
                }
                this.iframe.src = newSrc;
            }
        }
    };

    $(document).ready(function() {
        PreviewController.init();
    });

})(jQuery);
