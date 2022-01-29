;
(function (factory) {
    if (typeof define === 'function' && define.amd) {

        define(['jquery'], factory);
    } else if (typeof exports === 'object') {

        factory(require('jquery'));
    } else {

        factory(window.jQuery || window.Zepto);
    }
}(function ($) {


    var CLOSE_EVENT = 'Close',
            BEFORE_CLOSE_EVENT = 'BeforeClose',
            AFTER_CLOSE_EVENT = 'AfterClose',
            BEFORE_APPEND_EVENT = 'BeforeAppend',
            MARKUP_PARSE_EVENT = 'MarkupParse',
            OPEN_EVENT = 'Open',
            CHANGE_EVENT = 'Change',
            NS = 'Oximfp',
            EVENT_NS = '.' + NS,
            READY_CLASS = 'Oximfp-ready',
            REMOVING_CLASS = 'Oximfp-removing',
            PREVENT_CLOSE_CLASS = 'Oximfp-prevent-close';



    var Oximfp,
            OxiMagnificPopup = function () {},
            _isJQ = !!(window.jQuery),
            _prevStatus,
            _window = $(window),
            _document,
            _prevContentType,
            _wrapClasses,
            _currPopupType;



    var _OximfpOn = function (name, f) {
        Oximfp.ev.on(NS + name + EVENT_NS, f);
    },
            _getEl = function (className, appendTo, html, raw) {
                var el = document.createElement('div');
                el.className = 'Oximfp-' + className;
                if (html) {
                    el.innerHTML = html;
                }
                if (!raw) {
                    el = $(el);
                    if (appendTo) {
                        el.appendTo(appendTo);
                    }
                } else if (appendTo) {
                    appendTo.appendChild(el);
                }
                return el;
            },
            _OximfpTrigger = function (e, data) {
                Oximfp.ev.triggerHandler(NS + e, data);

                if (Oximfp.st.callbacks) {

                    e = e.charAt(0).toLowerCase() + e.slice(1);
                    if (Oximfp.st.callbacks[e]) {
                        Oximfp.st.callbacks[e].apply(Oximfp, $.isArray(data) ? data : [data]);
                    }
                }
            },
            _getCloseBtn = function (type) {
                if (type !== _currPopupType || !Oximfp.currTemplate.closeBtn) {
                    Oximfp.currTemplate.closeBtn = $(Oximfp.st.closeMarkup.replace('%title%', Oximfp.st.tClose));
                    _currPopupType = type;
                }
                return Oximfp.currTemplate.closeBtn;
            },
            _checkInstance = function () {
                if (!$.OximagnificPopup.instance) {

                    Oximfp = new OxiMagnificPopup();
                    Oximfp.init();
                    $.OximagnificPopup.instance = Oximfp;
                }
            },
            supportsTransitions = function () {
                var s = document.createElement('p').style,
                        v = ['ms', 'O', 'Moz', 'Webkit'];

                if (s['transition'] !== undefined) {
                    return true;
                }

                while (v.length) {
                    if (v.pop() + 'Transition' in s) {
                        return true;
                    }
                }

                return false;
            };




    OxiMagnificPopup.prototype = {

        constructor: OxiMagnificPopup,

        init: function () {
            var appVersion = navigator.appVersion;
            Oximfp.isLowIE = Oximfp.isIE8 = document.all && !document.addEventListener;
            Oximfp.isAndroid = (/android/gi).test(appVersion);
            Oximfp.isIOS = (/iphone|ipad|ipod/gi).test(appVersion);
            Oximfp.supportsTransition = supportsTransitions();

            Oximfp.probablyMobile = (Oximfp.isAndroid || Oximfp.isIOS || /(Opera Mini)|Kindle|webOS|BlackBerry|(Opera Mobi)|(Windows Phone)|IEMobile/i.test(navigator.userAgent));
            _document = $(document);

            Oximfp.popupsCache = {};
        },

        open: function (data) {

            var i;

            if (data.isObj === false) {
                Oximfp.items = data.items.toArray();

                Oximfp.index = 0;
                var items = data.items,
                        item;
                for (i = 0; i < items.length; i++) {
                    item = items[i];
                    if (item.parsed) {
                        item = item.el[0];
                    }
                    if (item === data.el[0]) {
                        Oximfp.index = i;
                        break;
                    }
                }
            } else {
                Oximfp.items = $.isArray(data.items) ? data.items : [data.items];
                Oximfp.index = data.index || 0;
            }

            if (Oximfp.isOpen) {
                Oximfp.updateItemHTML();
                return;
            }

            Oximfp.types = [];
            _wrapClasses = '';
            if (data.mainEl && data.mainEl.length) {
                Oximfp.ev = data.mainEl.eq(0);
            } else {
                Oximfp.ev = _document;
            }

            if (data.key) {
                if (!Oximfp.popupsCache[data.key]) {
                    Oximfp.popupsCache[data.key] = {};
                }
                Oximfp.currTemplate = Oximfp.popupsCache[data.key];
            } else {
                Oximfp.currTemplate = {};
            }



            Oximfp.st = $.extend(true, {}, $.OximagnificPopup.defaults, data);
            Oximfp.fixedContentPos = Oximfp.st.fixedContentPos === 'auto' ? !Oximfp.probablyMobile : Oximfp.st.fixedContentPos;

            if (Oximfp.st.modal) {
                Oximfp.st.closeOnContentClick = false;
                Oximfp.st.closeOnBgClick = false;
                Oximfp.st.showCloseBtn = false;
                Oximfp.st.enableEscapeKey = false;
            }


            if (!Oximfp.bgOverlay) {


                Oximfp.bgOverlay = _getEl('bg').on('click' + EVENT_NS, function () {
                    Oximfp.close();
                });

                Oximfp.wrap = _getEl('wrap').attr('tabindex', -1).on('click' + EVENT_NS, function (e) {
                    if (Oximfp._checkIfClose(e.target)) {
                        Oximfp.close();
                    }
                });

                Oximfp.container = _getEl('container', Oximfp.wrap);
            }

            Oximfp.contentContainer = _getEl('content');
            if (Oximfp.st.preloader) {
                Oximfp.preloader = _getEl('preloader', Oximfp.container, Oximfp.st.tLoading);
            }



            var modules = $.OximagnificPopup.modules;
            for (i = 0; i < modules.length; i++) {
                var n = modules[i];
                n = n.charAt(0).toUpperCase() + n.slice(1);
                Oximfp['init' + n].call(Oximfp);
            }
            _OximfpTrigger('BeforeOpen');


            if (Oximfp.st.showCloseBtn) {

                if (!Oximfp.st.closeBtnInside) {
                    Oximfp.wrap.append(_getCloseBtn());
                } else {
                    _OximfpOn(MARKUP_PARSE_EVENT, function (e, template, values, item) {
                        values.close_replaceWith = _getCloseBtn(item.type);
                    });
                    _wrapClasses += ' Oximfp-close-btn-in';
                }
            }

            if (Oximfp.st.alignTop) {
                _wrapClasses += ' Oximfp-align-top';
            }



            if (Oximfp.fixedContentPos) {
                Oximfp.wrap.css({
                    overflow: Oximfp.st.overflowY,
                    overflowX: 'hidden',
                    overflowY: Oximfp.st.overflowY
                });
            } else {
                Oximfp.wrap.css({
                    top: _window.scrollTop(),
                    position: 'absolute'
                });
            }
            if (Oximfp.st.fixedBgPos === false || (Oximfp.st.fixedBgPos === 'auto' && !Oximfp.fixedContentPos)) {
                Oximfp.bgOverlay.css({
                    height: _document.height(),
                    position: 'absolute'
                });
            }



            if (Oximfp.st.enableEscapeKey) {
                _document.on('keyup' + EVENT_NS, function (e) {
                    if (e.keyCode === 27) {
                        Oximfp.close();
                    }
                });
            }

            _window.on('resize' + EVENT_NS, function () {
                Oximfp.updateSize();
            });


            if (!Oximfp.st.closeOnContentClick) {
                _wrapClasses += ' Oximfp-auto-cursor';
            }

            if (_wrapClasses)
                Oximfp.wrap.addClass(_wrapClasses);


            var windowHeight = Oximfp.wH = _window.height();


            var windowStyles = {};

            if (Oximfp.fixedContentPos) {
                if (Oximfp._hasScrollBar(windowHeight)) {
                    var s = Oximfp._getScrollbarSize();
                    if (s) {
                        windowStyles.marginRight = s;
                    }
                }
            }

            if (Oximfp.fixedContentPos) {
                if (!Oximfp.isIE7) {
                    windowStyles.overflow = 'hidden';
                } else {

                    $('body, html').css('overflow', 'hidden');
                }
            }



            var classesToadd = Oximfp.st.mainClass;
            if (Oximfp.isIE7) {
                classesToadd += ' Oximfp-ie7';
            }
            if (classesToadd) {
                Oximfp._addClassToMFP(classesToadd);
            }


            Oximfp.updateItemHTML();

            _OximfpTrigger('BuildControls');


            $('html').css(windowStyles);


            Oximfp.bgOverlay.add(Oximfp.wrap).prependTo(Oximfp.st.prependTo || $(document.body));


            Oximfp._lastFocusedEl = document.activeElement;


            setTimeout(function () {

                if (Oximfp.content) {
                    Oximfp._addClassToMFP(READY_CLASS);
                    Oximfp._setFocus();
                } else {

                    Oximfp.bgOverlay.addClass(READY_CLASS);
                }


                _document.on('focusin' + EVENT_NS, Oximfp._onFocusIn);

            }, 16);

            Oximfp.isOpen = true;
            Oximfp.updateSize(windowHeight);
            _OximfpTrigger(OPEN_EVENT);

            return data;
        },

        close: function () {
            if (!Oximfp.isOpen)
                return;
            _OximfpTrigger(BEFORE_CLOSE_EVENT);

            Oximfp.isOpen = false;

            if (Oximfp.st.removalDelay && !Oximfp.isLowIE && Oximfp.supportsTransition) {
                Oximfp._addClassToMFP(REMOVING_CLASS);
                setTimeout(function () {
                    Oximfp._close();
                }, Oximfp.st.removalDelay);
            } else {
                Oximfp._close();
            }
        },

        _close: function () {
            _OximfpTrigger(CLOSE_EVENT);

            var classesToRemove = REMOVING_CLASS + ' ' + READY_CLASS + ' ';

            Oximfp.bgOverlay.detach();
            Oximfp.wrap.detach();
            Oximfp.container.empty();

            if (Oximfp.st.mainClass) {
                classesToRemove += Oximfp.st.mainClass + ' ';
            }

            Oximfp._removeClassFromMFP(classesToRemove);

            if (Oximfp.fixedContentPos) {
                var windowStyles = {marginRight: ''};
                if (Oximfp.isIE7) {
                    $('body, html').css('overflow', '');
                } else {
                    windowStyles.overflow = '';
                }
                $('html').css(windowStyles);
            }

            _document.off('keyup' + EVENT_NS + ' focusin' + EVENT_NS);
            Oximfp.ev.off(EVENT_NS);


            Oximfp.wrap.attr('class', 'Oximfp-wrap').removeAttr('style');
            Oximfp.bgOverlay.attr('class', 'Oximfp-bg');
            Oximfp.container.attr('class', 'Oximfp-container');


            if (Oximfp.st.showCloseBtn &&
                    (!Oximfp.st.closeBtnInside || Oximfp.currTemplate[Oximfp.currItem.type] === true)) {
                if (Oximfp.currTemplate.closeBtn)
                    Oximfp.currTemplate.closeBtn.detach();
            }


            if (Oximfp.st.autoFocusLast && Oximfp._lastFocusedEl) {
                $(Oximfp._lastFocusedEl).focus(); 
            }
            Oximfp.currItem = null;
            Oximfp.content = null;
            Oximfp.currTemplate = null;
            Oximfp.prevHeight = 0;

            _OximfpTrigger(AFTER_CLOSE_EVENT);
        },

        updateSize: function (winHeight) {

            if (Oximfp.isIOS) {

                var zoomLevel = document.documentElement.clientWidth / window.innerWidth;
                var height = window.innerHeight * zoomLevel;
                Oximfp.wrap.css('height', height);
                Oximfp.wH = height;
            } else {
                Oximfp.wH = winHeight || _window.height();
            }

            if (!Oximfp.fixedContentPos) {
                Oximfp.wrap.css('height', Oximfp.wH);
            }

            _OximfpTrigger('Resize');

        },

        updateItemHTML: function () {
            var item = Oximfp.items[Oximfp.index];


            Oximfp.contentContainer.detach();

            if (Oximfp.content)
                Oximfp.content.detach();

            if (!item.parsed) {
                item = Oximfp.parseEl(Oximfp.index);
            }

            var type = item.type;

            _OximfpTrigger('BeforeChange', [Oximfp.currItem ? Oximfp.currItem.type : '', type]);

            Oximfp.currItem = item;

            if (!Oximfp.currTemplate[type]) {
                var markup = Oximfp.st[type] ? Oximfp.st[type].markup : false;


                _OximfpTrigger('FirstMarkupParse', markup);

                if (markup) {
                    Oximfp.currTemplate[type] = $(markup);
                } else {

                    Oximfp.currTemplate[type] = true;
                }
            }

            if (_prevContentType && _prevContentType !== item.type) {
                Oximfp.container.removeClass('Oximfp-' + _prevContentType + '-holder');
            }

            var newContent = Oximfp['get' + type.charAt(0).toUpperCase() + type.slice(1)](item, Oximfp.currTemplate[type]);
            Oximfp.appendContent(newContent, type);

            item.preloaded = true;

            _OximfpTrigger(CHANGE_EVENT, item);
            _prevContentType = item.type;


            Oximfp.container.prepend(Oximfp.contentContainer);

            _OximfpTrigger('AfterChange');
        },

        appendContent: function (newContent, type) {
            Oximfp.content = newContent;

            if (newContent) {
                if (Oximfp.st.showCloseBtn && Oximfp.st.closeBtnInside &&
                        Oximfp.currTemplate[type] === true) {
                   
                    if (!Oximfp.content.find('.Oximfp-close').length) {
                        Oximfp.content.append(_getCloseBtn());
                    }
                } else {
                    Oximfp.content = newContent;
                }
            } else {
                Oximfp.content = '';
            }

            _OximfpTrigger(BEFORE_APPEND_EVENT);
            Oximfp.container.addClass('Oximfp-' + type + '-holder');

            Oximfp.contentContainer.append(Oximfp.content);
        },

        parseEl: function (index) {
            var item = Oximfp.items[index],
                    type;

            if (item.tagName) {
                item = {el: $(item)};
            } else {
                type = item.type;
                item = {data: item, src: item.src};
            }

            if (item.el) {
                var types = Oximfp.types;

                for (var i = 0; i < types.length; i++) {
                    if (item.el.hasClass('Oximfp-' + types[i])) {
                        type = types[i];
                        break;
                    }
                }

                item.src = item.el.attr('data-Oximfp-src');
                if (!item.src) {
                    item.src = item.el.attr('href');
                }
            }

            item.type = type || Oximfp.st.type || 'inline';
            item.index = index;
            item.parsed = true;
            Oximfp.items[index] = item;
            _OximfpTrigger('ElementParse', item);

            return Oximfp.items[index];
        },

        addGroup: function (el, options) {
            var eHandler = function (e) {
                e.OximfpEl = this;
                Oximfp._openClick(e, el, options);
            };

            if (!options) {
                options = {};
            }

            var eName = 'click.OximagnificPopup';
            options.mainEl = el;

            if (options.items) {
                options.isObj = true;
                el.off(eName).on(eName, eHandler);
            } else {
                options.isObj = false;
                if (options.delegate) {
                    el.off(eName).on(eName, options.delegate, eHandler);
                } else {
                    options.items = el;
                    el.off(eName).on(eName, eHandler);
                }
            }
        },
        _openClick: function (e, el, options) {
            var midClick = options.midClick !== undefined ? options.midClick : $.OximagnificPopup.defaults.midClick;


            if (!midClick && (e.which === 2 || e.ctrlKey || e.metaKey || e.altKey || e.shiftKey)) {
                return;
            }

            var disableOn = options.disableOn !== undefined ? options.disableOn : $.OximagnificPopup.defaults.disableOn;

            if (disableOn) {
                if ($.isFunction(disableOn)) {
                    if (!disableOn.call(Oximfp)) {
                        return true;
                    }
                } else {
                    if (_window.width() < disableOn) {
                        return true;
                    }
                }
            }

            if (e.type) {
                e.preventDefault();

                if (Oximfp.isOpen) {
                    e.stopPropagation();
                }
            }

            options.el = $(e.OximfpEl);
            if (options.delegate) {
                options.items = el.find(options.delegate);
            }
            Oximfp.open(options);
        },

        updateStatus: function (status, text) {

            if (Oximfp.preloader) {
                if (_prevStatus !== status) {
                    Oximfp.container.removeClass('Oximfp-s-' + _prevStatus);
                }

                if (!text && status === 'loading') {
                    text = Oximfp.st.tLoading;
                }

                var data = {
                    status: status,
                    text: text
                };

                _OximfpTrigger('UpdateStatus', data);

                status = data.status;
                text = data.text;

                Oximfp.preloader.html(text);

                Oximfp.preloader.find('a').on('click', function (e) {
                    e.stopImmediatePropagation();
                });

                Oximfp.container.addClass('Oximfp-s-' + status);
                _prevStatus = status;
            }
        },

        _checkIfClose: function (target) {

            if ($(target).hasClass(PREVENT_CLOSE_CLASS)) {
                return;
            }

            var closeOnContent = Oximfp.st.closeOnContentClick;
            var closeOnBg = Oximfp.st.closeOnBgClick;

            if (closeOnContent && closeOnBg) {
                return true;
            } else {

                if (!Oximfp.content || $(target).hasClass('Oximfp-close') || (Oximfp.preloader && target === Oximfp.preloader[0])) {
                    return true;
                }


                if ((target !== Oximfp.content[0] && !$.contains(Oximfp.content[0], target))) {
                    if (closeOnBg) {
                       
                        if ($.contains(document, target)) {
                            return true;
                        }
                    }
                } else if (closeOnContent) {
                    return true;
                }

            }
            return false;
        },
        _addClassToMFP: function (cName) {
            Oximfp.bgOverlay.addClass(cName);
            Oximfp.wrap.addClass(cName);
        },
        _removeClassFromMFP: function (cName) {
            this.bgOverlay.removeClass(cName);
            Oximfp.wrap.removeClass(cName);
        },
        _hasScrollBar: function (winHeight) {
            return ((Oximfp.isIE7 ? _document.height() : document.body.scrollHeight) > (winHeight || _window.height()));
        },
        _setFocus: function () {
            (Oximfp.st.focus ? Oximfp.content.find(Oximfp.st.focus).eq(0) : Oximfp.wrap).focus();
        },
        _onFocusIn: function (e) {
            if (e.target !== Oximfp.wrap[0] && !$.contains(Oximfp.wrap[0], e.target)) {
                Oximfp._setFocus();
                return false;
            }
        },
        _parseMarkup: function (template, values, item) {
            var arr;
            if (item.data) {
                values = $.extend(item.data, values);
            }
            _OximfpTrigger(MARKUP_PARSE_EVENT, [template, values, item]);

            $.each(values, function (key, value) {
                if (value === undefined || value === false) {
                    return true;
                }
                arr = key.split('_');
                if (arr.length > 1) {
                    var el = template.find(EVENT_NS + '-' + arr[0]);

                    if (el.length > 0) {
                        var attr = arr[1];
                        if (attr === 'replaceWith') {
                            if (el[0] !== value[0]) {
                                el.replaceWith(value);
                            }
                        } else if (attr === 'img') {
                            if (el.is('img')) {
                                el.attr('src', value);
                            } else {
                                el.replaceWith($('<img>').attr('src', value).attr('class', el.attr('class')));
                            }
                        } else {
                            el.attr(arr[1], value);
                        }
                    }

                } else {
                    template.find(EVENT_NS + '-' + key).html(value);
                }
            });
        },

        _getScrollbarSize: function () {

            if (Oximfp.scrollbarSize === undefined) {
                var scrollDiv = document.createElement("div");
                scrollDiv.style.cssText = 'width: 99px; height: 99px; overflow: scroll; position: absolute; top: -9999px;';
                document.body.appendChild(scrollDiv);
                Oximfp.scrollbarSize = scrollDiv.offsetWidth - scrollDiv.clientWidth;
                document.body.removeChild(scrollDiv);
            }
            return Oximfp.scrollbarSize;
        }

    };




    $.OximagnificPopup = {
        instance: null,
        proto: OxiMagnificPopup.prototype,
        modules: [],

        open: function (options, index) {
            _checkInstance();

            if (!options) {
                options = {};
            } else {
                options = $.extend(true, {}, options);
            }

            options.isObj = true;
            options.index = index || 0;
            return this.instance.open(options);
        },

        close: function () {
            return $.OximagnificPopup.instance && $.OximagnificPopup.instance.close();
        },

        registerModule: function (name, module) {
            if (module.options) {
                $.OximagnificPopup.defaults[name] = module.options;
            }
            $.extend(this.proto, module.proto);
            this.modules.push(name);
        },

        defaults: {

            disableOn: 0,

            key: null,

            midClick: false,

            mainClass: '',

            preloader: true,

            focus: '',

            closeOnContentClick: false,

            closeOnBgClick: true,

            closeBtnInside: true,

            showCloseBtn: true,

            enableEscapeKey: true,

            modal: false,

            alignTop: false,

            removalDelay: 0,

            prependTo: null,

            fixedContentPos: 'auto',

            fixedBgPos: 'auto',

            overflowY: 'auto',

            closeMarkup: '<button title="%title%" type="button" class="Oximfp-close">&#215;</button>',

            tClose: 'Close (Esc)',

            tLoading: 'Loading...',

            autoFocusLast: true

        }
    };



    $.fn.OximagnificPopup = function (options) {
        _checkInstance();

        var jqEl = $(this);

        if (typeof options === "string") {

            if (options === 'open') {
                var items,
                        itemOpts = _isJQ ? jqEl.data('OximagnificPopup') : jqEl[0].OximagnificPopup,
                        index = parseInt(arguments[1], 10) || 0;

                if (itemOpts.items) {
                    items = itemOpts.items[index];
                } else {
                    items = jqEl;
                    if (itemOpts.delegate) {
                        items = items.find(itemOpts.delegate);
                    }
                    items = items.eq(index);
                }
                Oximfp._openClick({OximfpEl: items}, jqEl, itemOpts);
            } else {
                if (Oximfp.isOpen)
                    Oximfp[options].apply(Oximfp, Array.prototype.slice.call(arguments, 1));
            }

        } else {

            options = $.extend(true, {}, options);


            if (_isJQ) {
                jqEl.data('OximagnificPopup', options);
            } else {
                jqEl[0].OximagnificPopup = options;
            }

            Oximfp.addGroup(jqEl, options);

        }
        return jqEl;
    };



    var INLINE_NS = 'inline',
            _hiddenClass,
            _inlinePlaceholder,
            _lastInlineElement,
            _putInlineElementsBack = function () {
                if (_lastInlineElement) {
                    _inlinePlaceholder.after(_lastInlineElement.addClass(_hiddenClass)).detach();
                    _lastInlineElement = null;
                }
            };

    $.OximagnificPopup.registerModule(INLINE_NS, {
        options: {
            hiddenClass: 'hide', 
            markup: '',
            tNotFound: 'Content not found'
        },
        proto: {

            initInline: function () {
                Oximfp.types.push(INLINE_NS);

                _OximfpOn(CLOSE_EVENT + '.' + INLINE_NS, function () {
                    _putInlineElementsBack();
                });
            },

            getInline: function (item, template) {

                _putInlineElementsBack();

                if (item.src) {
                    var inlineSt = Oximfp.st.inline,
                            el = $(item.src);

                    if (el.length) {

                        var parent = el[0].parentNode;
                        if (parent && parent.tagName) {
                            if (!_inlinePlaceholder) {
                                _hiddenClass = inlineSt.hiddenClass;
                                _inlinePlaceholder = _getEl(_hiddenClass);
                                _hiddenClass = 'Oximfp-' + _hiddenClass;
                            }

                            _lastInlineElement = el.after(_inlinePlaceholder).detach().removeClass(_hiddenClass);
                        }

                        Oximfp.updateStatus('ready');
                    } else {
                        Oximfp.updateStatus('error', inlineSt.tNotFound);
                        el = $('<div>');
                    }

                    item.inlineElement = el;
                    return el;
                }

                Oximfp.updateStatus('ready');
                Oximfp._parseMarkup(template, {}, item);
                return template;
            }
        }
    });


    var AJAX_NS = 'ajax',
            _ajaxCur,
            _removeAjaxCursor = function () {
                if (_ajaxCur) {
                    $(document.body).removeClass(_ajaxCur);
                }
            },
            _destroyAjaxRequest = function () {
                _removeAjaxCursor();
                if (Oximfp.req) {
                    Oximfp.req.abort();
                }
            };

    $.OximagnificPopup.registerModule(AJAX_NS, {

        options: {
            settings: null,
            cursor: 'Oximfp-ajax-cur',
            tError: '<a href="%url%">The content</a> could not be loaded.'
        },

        proto: {
            initAjax: function () {
                Oximfp.types.push(AJAX_NS);
                _ajaxCur = Oximfp.st.ajax.cursor;

                _OximfpOn(CLOSE_EVENT + '.' + AJAX_NS, _destroyAjaxRequest);
                _OximfpOn('BeforeChange.' + AJAX_NS, _destroyAjaxRequest);
            },
            getAjax: function (item) {

                if (_ajaxCur) {
                    $(document.body).addClass(_ajaxCur);
                }

                Oximfp.updateStatus('loading');

                var opts = $.extend({
                    url: item.src,
                    success: function (data, textStatus, jqXHR) {
                        var temp = {
                            data: data,
                            xhr: jqXHR
                        };

                        _OximfpTrigger('ParseAjax', temp);

                        Oximfp.appendContent($(temp.data), AJAX_NS);

                        item.finished = true;

                        _removeAjaxCursor();

                        Oximfp._setFocus();

                        setTimeout(function () {
                            Oximfp.wrap.addClass(READY_CLASS);
                        }, 16);

                        Oximfp.updateStatus('ready');

                        _OximfpTrigger('AjaxContentAdded');
                    },
                    error: function () {
                        _removeAjaxCursor();
                        item.finished = item.loadError = true;
                        Oximfp.updateStatus('error', Oximfp.st.ajax.tError.replace('%url%', item.src));
                    }
                }, Oximfp.st.ajax.settings);

                Oximfp.req = $.ajax(opts);

                return '';
            }
        }
    });


    var _imgInterval,
            _getTitle = function (item) {
                if (item.data && item.data.title !== undefined)
                    return item.data.title;

                var src = Oximfp.st.image.titleSrc;

                if (src) {
                    if ($.isFunction(src)) {
                        return src.call(Oximfp, item);
                    } else if (item.el) {
                        return item.el.attr(src) || '';
                    }
                }
                return '';
            };

    $.OximagnificPopup.registerModule('image', {

        options: {
            markup: '<div class="Oximfp-figure">' +
                    '<div class="Oximfp-close"></div>' +
                    '<figure>' +
                    '<div class="Oximfp-img"></div>' +
                    '<figcaption>' +
                    '<div class="Oximfp-bottom-bar">' +
                    '<div class="Oximfp-title"></div>' +
                    '<div class="Oximfp-counter"></div>' +
                    '</div>' +
                    '</figcaption>' +
                    '</figure>' +
                    '</div>',
            cursor: 'Oximfp-zoom-out-cur',
            titleSrc: 'title',
            verticalFit: true,
            tError: '<a href="%url%">The image</a> could not be loaded.'
        },

        proto: {
            initImage: function () {
                var imgSt = Oximfp.st.image,
                        ns = '.image';

                Oximfp.types.push('image');

                _OximfpOn(OPEN_EVENT + ns, function () {
                    if (Oximfp.currItem.type === 'image' && imgSt.cursor) {
                        $(document.body).addClass(imgSt.cursor);
                    }
                });

                _OximfpOn(CLOSE_EVENT + ns, function () {
                    if (imgSt.cursor) {
                        $(document.body).removeClass(imgSt.cursor);
                    }
                    _window.off('resize' + EVENT_NS);
                });

                _OximfpOn('Resize' + ns, Oximfp.resizeImage);
                if (Oximfp.isLowIE) {
                    _OximfpOn('AfterChange', Oximfp.resizeImage);
                }
            },
            resizeImage: function () {
                var item = Oximfp.currItem;
                if (!item || !item.img)
                    return;

                if (Oximfp.st.image.verticalFit) {
                    var decr = 0;
                    if (Oximfp.isLowIE) {
                        decr = parseInt(item.img.css('padding-top'), 10) + parseInt(item.img.css('padding-bottom'), 10);
                    }
                    item.img.css('max-height', Oximfp.wH - decr);
                }
            },
            _onImageHasSize: function (item) {
                if (item.img) {

                    item.hasSize = true;

                    if (_imgInterval) {
                        clearInterval(_imgInterval);
                    }

                    item.isCheckingImgSize = false;

                    _OximfpTrigger('ImageHasSize', item);

                    if (item.imgHidden) {
                        if (Oximfp.content)
                            Oximfp.content.removeClass('Oximfp-loading');

                        item.imgHidden = false;
                    }

                }
            },

            findImageSize: function (item) {

                var counter = 0,
                        img = item.img[0],
                        OximfpSetInterval = function (delay) {

                            if (_imgInterval) {
                                clearInterval(_imgInterval);
                            }
                            _imgInterval = setInterval(function () {
                                if (img.naturalWidth > 0) {
                                    Oximfp._onImageHasSize(item);
                                    return;
                                }

                                if (counter > 200) {
                                    clearInterval(_imgInterval);
                                }

                                counter++;
                                if (counter === 3) {
                                    OximfpSetInterval(10);
                                } else if (counter === 40) {
                                    OximfpSetInterval(50);
                                } else if (counter === 100) {
                                    OximfpSetInterval(500);
                                }
                            }, delay);
                        };

                OximfpSetInterval(1);
            },

            getImage: function (item, template) {

                var guard = 0,
                        onLoadComplete = function () {
                            if (item) {
                                if (item.img[0].complete) {
                                    item.img.off('.Oximfploader');

                                    if (item === Oximfp.currItem) {
                                        Oximfp._onImageHasSize(item);

                                        Oximfp.updateStatus('ready');
                                    }

                                    item.hasSize = true;
                                    item.loaded = true;

                                    _OximfpTrigger('ImageLoadComplete');

                                } else {
                                    guard++;
                                    if (guard < 200) {
                                        setTimeout(onLoadComplete, 100);
                                    } else {
                                        onLoadError();
                                    }
                                }
                            }
                        },
                        onLoadError = function () {
                            if (item) {
                                item.img.off('.Oximfploader');
                                if (item === Oximfp.currItem) {
                                    Oximfp._onImageHasSize(item);
                                    Oximfp.updateStatus('error', imgSt.tError.replace('%url%', item.src));
                                }

                                item.hasSize = true;
                                item.loaded = true;
                                item.loadError = true;
                            }
                        },
                        imgSt = Oximfp.st.image;


                var el = template.find('.Oximfp-img');
                if (el.length) {
                    var img = document.createElement('img');
                    img.className = 'Oximfp-img';
                    if (item.el && item.el.find('img').length) {
                        img.alt = item.el.find('img').attr('alt');
                    }
                    item.img = $(img).on('load.Oximfploader', onLoadComplete).on('error.Oximfploader', onLoadError);
                    img.src = item.src;

                    if (el.is('img')) {
                        item.img = item.img.clone();
                    }

                    img = item.img[0];
                    if (img.naturalWidth > 0) {
                        item.hasSize = true;
                    } else if (!img.width) {
                        item.hasSize = false;
                    }
                }

                Oximfp._parseMarkup(template, {
                    title: _getTitle(item),
                    img_replaceWith: item.img
                }, item);

                Oximfp.resizeImage();

                if (item.hasSize) {
                    if (_imgInterval)
                        clearInterval(_imgInterval);

                    if (item.loadError) {
                        template.addClass('Oximfp-loading');
                        Oximfp.updateStatus('error', imgSt.tError.replace('%url%', item.src));
                    } else {
                        template.removeClass('Oximfp-loading');
                        Oximfp.updateStatus('ready');
                    }
                    return template;
                }

                Oximfp.updateStatus('loading');
                item.loading = true;

                if (!item.hasSize) {
                    item.imgHidden = true;
                    template.addClass('Oximfp-loading');
                    Oximfp.findImageSize(item);
                }

                return template;
            }
        }
    });


    var hasMozTransform,
            getHasMozTransform = function () {
                if (hasMozTransform === undefined) {
                    hasMozTransform = document.createElement('p').style.MozTransform !== undefined;
                }
                return hasMozTransform;
            };

    $.OximagnificPopup.registerModule('zoom', {

        options: {
            enabled: false,
            easing: 'ease-in-out',
            duration: 300,
            opener: function (element) {
                return element.is('img') ? element : element.find('img');
            }
        },

        proto: {

            initZoom: function () {
                var zoomSt = Oximfp.st.zoom,
                        ns = '.zoom',
                        image;

                if (!zoomSt.enabled || !Oximfp.supportsTransition) {
                    return;
                }

                var duration = zoomSt.duration,
                        getElToAnimate = function (image) {
                            var newImg = image.clone().removeAttr('style').removeAttr('class').addClass('Oximfp-animated-image'),
                                    transition = 'all ' + (zoomSt.duration / 1000) + 's ' + zoomSt.easing,
                                    cssObj = {
                                        position: 'fixed',
                                        zIndex: 9999,
                                        left: 0,
                                        top: 0,
                                        '-webkit-backface-visibility': 'hidden'
                                    },
                                    t = 'transition';

                            cssObj['-webkit-' + t] = cssObj['-moz-' + t] = cssObj['-o-' + t] = cssObj[t] = transition;

                            newImg.css(cssObj);
                            return newImg;
                        },
                        showMainContent = function () {
                            Oximfp.content.css('visibility', 'visible');
                        },
                        openTimeout,
                        animatedImg;

                _OximfpOn('BuildControls' + ns, function () {
                    if (Oximfp._allowZoom()) {

                        clearTimeout(openTimeout);
                        Oximfp.content.css('visibility', 'hidden');


                        image = Oximfp._getItemToZoom();

                        if (!image) {
                            showMainContent();
                            return;
                        }

                        animatedImg = getElToAnimate(image);

                        animatedImg.css(Oximfp._getOffset());

                        Oximfp.wrap.append(animatedImg);

                        openTimeout = setTimeout(function () {
                            animatedImg.css(Oximfp._getOffset(true));
                            openTimeout = setTimeout(function () {

                                showMainContent();

                                setTimeout(function () {
                                    animatedImg.remove();
                                    image = animatedImg = null;
                                    _OximfpTrigger('ZoomAnimationEnded');
                                }, 16);

                            }, duration);

                        }, 16);



                    }
                });
                _OximfpOn(BEFORE_CLOSE_EVENT + ns, function () {
                    if (Oximfp._allowZoom()) {

                        clearTimeout(openTimeout);

                        Oximfp.st.removalDelay = duration;

                        if (!image) {
                            image = Oximfp._getItemToZoom();
                            if (!image) {
                                return;
                            }
                            animatedImg = getElToAnimate(image);
                        }

                        animatedImg.css(Oximfp._getOffset(true));
                        Oximfp.wrap.append(animatedImg);
                        Oximfp.content.css('visibility', 'hidden');

                        setTimeout(function () {
                            animatedImg.css(Oximfp._getOffset());
                        }, 16);
                    }

                });

                _OximfpOn(CLOSE_EVENT + ns, function () {
                    if (Oximfp._allowZoom()) {
                        showMainContent();
                        if (animatedImg) {
                            animatedImg.remove();
                        }
                        image = null;
                    }
                });
            },

            _allowZoom: function () {
                return Oximfp.currItem.type === 'image';
            },

            _getItemToZoom: function () {
                if (Oximfp.currItem.hasSize) {
                    return Oximfp.currItem.img;
                } else {
                    return false;
                }
            },

            _getOffset: function (isLarge) {
                var el;
                if (isLarge) {
                    el = Oximfp.currItem.img;
                } else {
                    el = Oximfp.st.zoom.opener(Oximfp.currItem.el || Oximfp.currItem);
                }

                var offset = el.offset();
                var paddingTop = parseInt(el.css('padding-top'), 10);
                var paddingBottom = parseInt(el.css('padding-bottom'), 10);
                offset.top -= ($(window).scrollTop() - paddingTop);



                var obj = {
                    width: el.width(),
                    
                    height: (_isJQ ? el.innerHeight() : el[0].offsetHeight) - paddingBottom - paddingTop
                };


                if (getHasMozTransform()) {
                    obj['-moz-transform'] = obj['transform'] = 'translate(' + offset.left + 'px,' + offset.top + 'px)';
                } else {
                    obj.left = offset.left;
                    obj.top = offset.top;
                }
                return obj;
            }

        }
    });





    var IFRAME_NS = 'iframe',
            _emptyPage = '//about:blank',
            _fixIframeBugs = function (isShowing) {
                if (Oximfp.currTemplate[IFRAME_NS]) {
                    var el = Oximfp.currTemplate[IFRAME_NS].find('iframe');
                    if (el.length) {

                        if (!isShowing) {
                            el[0].src = _emptyPage;
                        }


                        if (Oximfp.isIE8) {
                            el.css('display', isShowing ? 'block' : 'none');
                        }
                    }
                }
            };

    $.OximagnificPopup.registerModule(IFRAME_NS, {

        options: {
            markup: '<div class="Oximfp-iframe-scaler">' +
                    '<div class="Oximfp-close"></div>' +
                    '<iframe class="Oximfp-iframe" src="//about:blank" frameborder="0" allowfullscreen></iframe>' +
                    '</div>',

            srcAction: 'iframe_src',

            patterns: {
                youtube: {
                    index: 'youtube.com',
                    id: 'v=',
                    src: '//www.youtube.com/embed/%id%?autoplay=1'
                },
                vimeo: {
                    index: 'vimeo.com/',
                    id: '/',
                    src: '//player.vimeo.com/video/%id%?autoplay=1'
                },
                gmaps: {
                    index: '//maps.google.',
                    src: '%id%&output=embed'
                }
            }
        },

        proto: {
            initIframe: function () {
                Oximfp.types.push(IFRAME_NS);

                _OximfpOn('BeforeChange', function (e, prevType, newType) {
                    if (prevType !== newType) {
                        if (prevType === IFRAME_NS) {
                            _fixIframeBugs();
                        } else if (newType === IFRAME_NS) {
                            _fixIframeBugs(true);
                        }
                    }
                });

                _OximfpOn(CLOSE_EVENT + '.' + IFRAME_NS, function () {
                    _fixIframeBugs();
                });
            },

            getIframe: function (item, template) {
                var embedSrc = item.src;
                var iframeSt = Oximfp.st.iframe;

                $.each(iframeSt.patterns, function () {
                    if (embedSrc.indexOf(this.index) > -1) {
                        if (this.id) {
                            if (typeof this.id === 'string') {
                                embedSrc = embedSrc.substr(embedSrc.lastIndexOf(this.id) + this.id.length, embedSrc.length);
                            } else {
                                embedSrc = this.id.call(this, embedSrc);
                            }
                        }
                        embedSrc = this.src.replace('%id%', embedSrc);
                        return false;
                    }
                });

                var dataObj = {};
                if (iframeSt.srcAction) {
                    dataObj[iframeSt.srcAction] = embedSrc;
                }
                Oximfp._parseMarkup(template, dataObj, item);

                Oximfp.updateStatus('ready');

                return template;
            }
        }
    });




    var _getLoopedId = function (index) {
        var numSlides = Oximfp.items.length;
        if (index > numSlides - 1) {
            return index - numSlides;
        } else if (index < 0) {
            return numSlides + index;
        }
        return index;
    },
            _replaceCurrTotal = function (text, curr, total) {
                return text.replace(/%curr%/gi, curr + 1).replace(/%total%/gi, total);
            };

    $.OximagnificPopup.registerModule('gallery', {

        options: {
            enabled: false,
            arrowMarkup: '<button title="%title%" type="button" class="Oximfp-arrow Oximfp-arrow-%dir%"></button>',
            preload: [0, 2],
            navigateByImgClick: true,
            arrows: true,

            tPrev: 'Previous (Left arrow key)',
            tNext: 'Next (Right arrow key)',
            tCounter: '%curr% of %total%'
        },

        proto: {
            initGallery: function () {

                var gSt = Oximfp.st.gallery,
                        ns = '.Oximfp-gallery';

                Oximfp.direction = true;

                if (!gSt || !gSt.enabled)
                    return false;

                _wrapClasses += ' Oximfp-gallery';

                _OximfpOn(OPEN_EVENT + ns, function () {

                    if (gSt.navigateByImgClick) {
                        Oximfp.wrap.on('click' + ns, '.Oximfp-img', function () {
                            if (Oximfp.items.length > 1) {
                                Oximfp.next();
                                return false;
                            }
                        });
                    }

                    _document.on('keydown' + ns, function (e) {
                        if (e.keyCode === 37) {
                            Oximfp.prev();
                        } else if (e.keyCode === 39) {
                            Oximfp.next();
                        }
                    });
                });

                _OximfpOn('UpdateStatus' + ns, function (e, data) {
                    if (data.text) {
                        data.text = _replaceCurrTotal(data.text, Oximfp.currItem.index, Oximfp.items.length);
                    }
                });

                _OximfpOn(MARKUP_PARSE_EVENT + ns, function (e, element, values, item) {
                    var l = Oximfp.items.length;
                    values.counter = l > 1 ? _replaceCurrTotal(gSt.tCounter, item.index, l) : '';
                });

                _OximfpOn('BuildControls' + ns, function () {
                    if (Oximfp.items.length > 1 && gSt.arrows && !Oximfp.arrowLeft) {
                        var markup = gSt.arrowMarkup,
                                arrowLeft = Oximfp.arrowLeft = $(markup.replace(/%title%/gi, gSt.tPrev).replace(/%dir%/gi, 'left')).addClass(PREVENT_CLOSE_CLASS),
                                arrowRight = Oximfp.arrowRight = $(markup.replace(/%title%/gi, gSt.tNext).replace(/%dir%/gi, 'right')).addClass(PREVENT_CLOSE_CLASS);

                        arrowLeft.click(function () {
                            Oximfp.prev();
                        });
                        arrowRight.click(function () {
                            Oximfp.next();
                        });

                        Oximfp.container.append(arrowLeft.add(arrowRight));
                    }
                });

                _OximfpOn(CHANGE_EVENT + ns, function () {
                    if (Oximfp._preloadTimeout)
                        clearTimeout(Oximfp._preloadTimeout);

                    Oximfp._preloadTimeout = setTimeout(function () {
                        Oximfp.preloadNearbyImages();
                        Oximfp._preloadTimeout = null;
                    }, 16);
                });


                _OximfpOn(CLOSE_EVENT + ns, function () {
                    _document.off(ns);
                    Oximfp.wrap.off('click' + ns);
                    Oximfp.arrowRight = Oximfp.arrowLeft = null;
                });

            },
            next: function () {
                Oximfp.direction = true;
                Oximfp.index = _getLoopedId(Oximfp.index + 1);
                Oximfp.updateItemHTML();
            },
            prev: function () {
                Oximfp.direction = false;
                Oximfp.index = _getLoopedId(Oximfp.index - 1);
                Oximfp.updateItemHTML();
            },
            goTo: function (newIndex) {
                Oximfp.direction = (newIndex >= Oximfp.index);
                Oximfp.index = newIndex;
                Oximfp.updateItemHTML();
            },
            preloadNearbyImages: function () {
                var p = Oximfp.st.gallery.preload,
                        preloadBefore = Math.min(p[0], Oximfp.items.length),
                        preloadAfter = Math.min(p[1], Oximfp.items.length),
                        i;

                for (i = 1; i <= (Oximfp.direction ? preloadAfter : preloadBefore); i++) {
                    Oximfp._preloadItem(Oximfp.index + i);
                }
                for (i = 1; i <= (Oximfp.direction ? preloadBefore : preloadAfter); i++) {
                    Oximfp._preloadItem(Oximfp.index - i);
                }
            },
            _preloadItem: function (index) {
                index = _getLoopedId(index);

                if (Oximfp.items[index].preloaded) {
                    return;
                }

                var item = Oximfp.items[index];
                if (!item.parsed) {
                    item = Oximfp.parseEl(index);
                }

                _OximfpTrigger('LazyLoad', item);

                if (item.type === 'image') {
                    item.img = $('<img class="Oximfp-img" />').on('load.Oximfploader', function () {
                        item.hasSize = true;
                    }).on('error.Oximfploader', function () {
                        item.hasSize = true;
                        item.loadError = true;
                        _OximfpTrigger('LazyLoadError', item);
                    }).attr('src', item.src);
                }


                item.preloaded = true;
            }
        }
    });



    var RETINA_NS = 'retina';

    $.OximagnificPopup.registerModule(RETINA_NS, {
        options: {
            replaceSrc: function (item) {
                return item.src.replace(/\.\w+$/, function (m) {
                    return '@2x' + m;
                });
            },
            ratio: 1
        },
        proto: {
            initRetina: function () {
                if (window.devicePixelRatio > 1) {

                    var st = Oximfp.st.retina,
                            ratio = st.ratio;

                    ratio = !isNaN(ratio) ? ratio : ratio();

                    if (ratio > 1) {
                        _OximfpOn('ImageHasSize' + '.' + RETINA_NS, function (e, item) {
                            item.img.css({
                                'max-width': item.img[0].naturalWidth / ratio,
                                'width': '100%'
                            });
                        });
                        _OximfpOn('ElementParse' + '.' + RETINA_NS, function (e, item) {
                            item.src = st.replaceSrc(item, ratio);
                        });
                    }
                }

            }
        }
    });


    _checkInstance();
}));