////////////////////////////////
// UTILITIES ///////////////////
////////////////////////////////

var ajax = {};
ajax.x = function() {
    if (typeof XMLHttpRequest !== 'undefined') {
        return new XMLHttpRequest();
    }
    var versions = [
        "MSXML2.XmlHttp.5.0",
        "MSXML2.XmlHttp.4.0",
        "MSXML2.XmlHttp.3.0",
        "MSXML2.XmlHttp.2.0",
        "Microsoft.XmlHttp"
    ];

    var xhr;
    for(var i = 0; i < versions.length; i++) {
        try {
            xhr = new ActiveXObject(versions[i]);
            break;
        } catch (e) {
        }
    }
    return xhr;
};

ajax.send = function(url, callback, method, data, sync) {
    var x = ajax.x();
    x.open(method, url, sync);
    x.onreadystatechange = function() {
        if (x.readyState == 4) {
            callback(x.responseText)
        }
    };
    if (method == 'POST') {
        x.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
    }
    x.send(data)
};

ajax.post = function(url, data, callback, sync) {
    var query = [];
    for (var key in data) {
        query.push(encodeURIComponent(key) + '=' + encodeURIComponent(data[key]));
    }
    ajax.send(url, callback, 'POST', query.join('&'), sync)
};

////////////////////////////////
// SMALL FIXES /////////////////
////////////////////////////////

function fixMenuGrandparents() {
    var parent, grandparent;
    var parents = document.querySelectorAll(".current-post-ancestor");
    for (var i = 0; i < parents.length; i++) {
        parent = parents[i];
        grandparent = parent.parentNode.parentNode;
        grandparent.className += " current-menu-parent";
    }
}

fixMenuGrandparents();

//////////////////////////////////////
// SMOOTH SCROLLER STUFF /////////////
//////////////////////////////////////

function getScrollDist() {
    var doc = document.documentElement;
    return (window.pageYOffset || doc.scrollTop)  - (doc.clientTop || 0);
}

function getDocHeight() {
    return (document.height !== undefined) ? document.height : document.body.offsetHeight;
}

function getOffsetTop (elem){
    var offsetTop = 0;
    do {
        if ( !isNaN( elem.offsetTop ) ) {
            offsetTop += elem.offsetTop;
        }
    } while( elem = elem.offsetParent );
    return offsetTop;
}

function updateUrl ( sectionId ) {
    if ( history.pushState ) {
        history.pushState( {
            pos: sectionId
        }, '', window.location.pathname +
        window.location.search +
        '#' + sectionId );
    }
}

function animateScroll(endLocation, sectionId, padding) {
    var PADDING = padding || 0,
        INTERVAL_TIME = 16,
        SPEED = 500,
        timeLapsed = 0,
        startLocation = getScrollDist(),
        endLocation = endLocation - PADDING,
        distance = endLocation - startLocation,
        percentage,
        position,
        animationInterval,
        scrollFunc = function (x) {
            return x < 0.5 ? 8 * Math.pow(x,4) : 1 - 8 * (--x) * Math.pow(x,3);
        },
        documentHeight =  getDocHeight();

    var stopAnimateScroll = function (position, endLocation, animationInterval) {
        var currentLocation = getScrollDist();
        if ( position == endLocation || currentLocation == endLocation || ( (window.innerHeight + currentLocation) >= documentHeight ) ) {
            clearInterval(animationInterval);
        }
    };

    var loopAnimateScroll = function () {
        timeLapsed += INTERVAL_TIME;
        percentage = ( timeLapsed / SPEED );
        percentage = ( percentage > 1 ) ? 1 : percentage;
        position = startLocation + ( distance * scrollFunc(percentage) );
        window.scrollTo( 0, Math.floor(position) );
        stopAnimateScroll(position, endLocation, animationInterval);
    };

    var startAnimateScroll = function () {
        animationInterval = setInterval(loopAnimateScroll, INTERVAL_TIME);
    };

    startAnimateScroll();
    if (sectionId){
        updateUrl(sectionId);
    }
}

function getViewportHeight () {
    return Math.max(document.documentElement.clientHeight, window.innerHeight || 0);
}

function SmoothScroller(navEl) {

    var TOP_BAR_PADDING = 68;

    if (!navEl) {
        return false;
    }
    this.elem = navEl;
    this.sections = (function(elem) {
        var sections = [];
        var listItems = elem.getElementsByTagName("li");
        for (var i = 0; i < listItems.length; i++) {
            sections.push(new Section(listItems[i]));
        }
        return sections;
    }(this.elem));

    this.fixNavHeight = function () {
        var NAV_PADDING = 40 + TOP_BAR_PADDING;
        var FOOT_PADDING = 200;
        var SCROLL_MAX = this.footerOffset - this.navHeight - FOOT_PADDING;
        var SCROLL_DIST = getScrollDist() + NAV_PADDING;

        if (SCROLL_DIST > this.navOffset) {
            if (SCROLL_DIST > SCROLL_MAX) {
                this.elem.style.top = SCROLL_MAX - this.navOffset + "px";
            } else {
                this.elem.style.top = SCROLL_DIST - this.navOffset + "px";
            }
        } else {
            this.elem.style.top = 0;
        }
    };

    this.update = function () {
        this.fixNavHeight();
        this.sections.forEach(function (section) {
            section.inactivate.call(section);
        });
        var prevSection, section = this.sections[0];
        var sectionOffsetMin = getScrollDist() + this.viewportHeight/3 + TOP_BAR_PADDING/2;
        for (var i = 1; i < this.sections.length; i++) {
            prevSection = section;
            section = this.sections[i];
            if (!section.inSectionOffsetMin(sectionOffsetMin)) {
                section = prevSection;
                break;
            }
        }
        section.activate();
    };

    this.setHeights = function() {
        this.elem.style.top = 0;
        this.navOffset = getOffsetTop(this.elem);
        this.navHeight = this.elem.offsetHeight;
        this.footerOffset = getOffsetTop(document.getElementById("site-footer"));
        this.viewportHeight = getViewportHeight();
        this.sections.forEach(function (section) {
            section.setHeights.call(section);
        });
        this.update();
    };
    this.setHeights();

    function Section(navItemEl) {
        this.elem = navItemEl;
        this.baseClasses = navItemEl.className;
        this.sectionId = (function (that) {
            var link = that.elem.getElementsByTagName("a")[0];
            return link.getAttribute("href").substr(1);
        }(this));

        this.sectionElem = (function( that ) {
            return document.getElementById(that.sectionId);
        }(this));

        this.setHeights = function() {
            this.sectionOffset = getOffsetTop(this.sectionElem);
        };

        this.activate = function () {
            this.elem.className = this.baseClasses + " active";
        };

        this.inactivate = function () {
            this.elem.className = this.baseClasses;
        };

        this.inSectionOffsetMin = function (sectionOffsetMin) {
            return this.sectionOffset < sectionOffsetMin;
        };

        this.scrollTo = function () {
            var padding = 40 + TOP_BAR_PADDING;
            animateScroll(this.sectionOffset, this.sectionId, padding);
        };

        (function(that) {
            var link = that.elem.getElementsByTagName("a")[0];
            link.onclick = function () {
                that.scrollTo.call(that);
                return false;
            };
        }(this));
    }

    (function(that) {
        window.onresize = function () {
            that.setHeights.call(that);
        };
    }(this));

    (function(that) {
        window.onscroll = function () {
            that.update.call(that);
        };
    }(this));

}

new SmoothScroller(document.getElementById("sliding-nav"));

function scrollToProperties() {
    var elem = document.getElementById("home-property-cards");
    var position = getOffsetTop(elem);
    animateScroll(position, false, 90);
}

/////////////////////////////////////////
// DATE PICKER STUFF ////////////////////
/////////////////////////////////////////

function DatePicker ( elem ) {

    if (!elem) {
        return false;
    }

    this.elem = elem;
    this.inputs = this.elem.getElementsByTagName("input");

    this.dateTo = new Pikaday({
        field: this.inputs[1],
        minDate: new Date(Date.now())
    });
    this.dateFrom = new Pikaday({
        field: this.inputs[0],
        minDate: new Date(Date.now()),
        onSelect: (function (that) {
            var dateTo = that.dateTo;
            return function (date) {
                if (dateTo.getDate() < date) {
                    dateTo.setDate(date);
                }
                dateTo.setMinDate(date);
            }
        }(this))
    });
}

new DatePicker(document.getElementById('datepicker'));

function DatePickerShow ( selectElem, containElem ) {

    if (!(selectElem && containElem)) {
        return false
    }

    this.selectElem = selectElem;
    this.containElem = containElem;

    this.showDatePicker = (function (that) {
        var ogClasses = that.containElem.className;
        return function () {
            that.containElem.className = ogClasses + ' show';
        }
    }(this));

    this.hideDatePicker = (function (that) {
        var ogClasses = that.containElem.className;
        return function () {
            that.containElem.className = ogClasses;
        }
    }(this));

    (function (that) {
         that.selectElem.onchange = function () {
             var val = that.selectElem.value;
             if (val == "Booking Possibility") {
                 that.showDatePicker();
             } else {
                 that.hideDatePicker();
             }
         }
    }(this));
}

new DatePickerShow(document.getElementById('datepicker-select'),
    document.getElementById('datepicker-container'));

//////////////////////////////
// OTHER FORM STUFF //////////
//////////////////////////////

function sendForm( formId, url ) {
    var form = document.getElementById(formId);
    var flash = form.getElementsByClassName('flash')[0];
    var button = form.getElementsByClassName('button')[0];
    if (!form || button.disabled) {
        return false;
    }
    var data = (function () {
        var result = {},
            input = null,
            inputs = {
                input: form.getElementsByTagName('input'),
                selects: form.getElementsByTagName('select'),
                textareas: form.getElementsByTagName('textarea')
            };
        for (var key in inputs) {
            data = inputs[key];
            for (var i = 0; i < data.length; i++) {
                input = data.item(i);
                result[input.name] = input.value;
            }
        }
        return result;
    }());

    var changeFormClass = function (className) {
        form.className = className;
    };

    var flashError = function(message) {
        button.disabled = false;
        button.innerHTML = 'Send!';
        changeFormClass('error');
        flash.innerHTML = message;
    };

    var flashSuccess = function(message) {
        changeFormClass('success');
        button.innerHTML = 'Sent!';
    };

    var onResponse = function(response) {
        try {
            response = JSON.parse(response);
        } catch (e) {
            return flashError('Something wen\'t wrong sending email');
        }
        if (response.error) {
            return flashError(response.message);
        }
        return flashSuccess(response.message);
    };

    var send = function () {
        changeFormClass('sending');
        button.innerHTML = 'Sending';
        button.disabled = true;
        ajax.post(url, data, onResponse);
    }
    send();
    return false;
}

// photoswipe

var PhotoSwipe = PhotoSwipe || {};

var initPhotoSwipeFromDOM = function(gallerySelector) {

    // parse slide data (url, title, size ...) from DOM elements
    // (children of gallerySelector)
    var parseThumbnailElements = function(el) {
        var thumbElements = el.childNodes,
            numNodes = thumbElements.length,
            items = [],
            figureEl,
            linkEl,
            size,
            item;

        for(var i = 0; i < numNodes; i++) {

            figureEl = thumbElements[i]; // <figure> element

            // include only element nodes
            if(figureEl.nodeType !== 1) {
                continue;
            }

            linkEl = figureEl.children[0]; // <a> element

            size = linkEl.getAttribute('data-size').split('x');

            // create slide object
            item = {
                src: linkEl.getAttribute('href'),
                w: parseInt(size[0], 10),
                h: parseInt(size[1], 10)
            };



            if(figureEl.children.length > 1) {
                // <figcaption> content
                item.title = figureEl.children[1].innerHTML;
            }

            if(linkEl.children.length > 0) {
                // <img> thumbnail element, retrieving thumbnail url
                item.msrc = linkEl.children[0].getAttribute('src');
            }

            item.el = figureEl; // save link to element for getThumbBoundsFn
            items.push(item);
        }

        return items;
    };

    // find nearest parent element
    var closest = function closest(el, fn) {
        return el && ( fn(el) ? el : closest(el.parentNode, fn) );
    };

    // triggers when user clicks on thumbnail
    var onThumbnailsClick = function(e) {
        e = e || window.event;
        e.preventDefault ? e.preventDefault() : e.returnValue = false;

        var eTarget = e.target || e.srcElement;

        // find root element of slide
        var clickedListItem = closest(eTarget, function(el) {
            return el.tagName === 'FIGURE';
        });

        if(!clickedListItem) {
            return;
        }

        // find index of clicked item by looping through all child nodes
        // alternatively, you may define index via data- attribute
        var clickedGallery = clickedListItem.parentNode,
            childNodes = clickedListItem.parentNode.childNodes,
            numChildNodes = childNodes.length,
            nodeIndex = 0,
            index;

        for (var i = 0; i < numChildNodes; i++) {
            if(childNodes[i].nodeType !== 1) {
                continue;
            }

            if(childNodes[i] === clickedListItem) {
                index = nodeIndex;
                break;
            }
            nodeIndex++;
        }



        if(index >= 0) {
            // open PhotoSwipe if valid index found
            openPhotoSwipe( index, clickedGallery );
        }
        return false;
    };

    // parse picture index and gallery index from URL (#&pid=1&gid=2)
    var photoswipeParseHash = function() {
        var hash = window.location.hash.substring(1),
            params = {};

        if(hash.length < 5) {
            return params;
        }

        var vars = hash.split('&');
        for (var i = 0; i < vars.length; i++) {
            if(!vars[i]) {
                continue;
            }
            var pair = vars[i].split('=');
            if(pair.length < 2) {
                continue;
            }
            params[pair[0]] = pair[1];
        }

        if(params.gid) {
            params.gid = parseInt(params.gid, 10);
        }

        if(!params.hasOwnProperty('pid')) {
            return params;
        }
        params.pid = parseInt(params.pid, 10);
        return params;
    };

    var openPhotoSwipe = function(index, galleryElement, disableAnimation) {
        var pswpElement = document.querySelectorAll('.pswp')[0],
            gallery,
            options,
            items;

        items = parseThumbnailElements(galleryElement);

        // define options (if needed)
        options = {
            index: index,

            // define gallery index (for URL)
            galleryUID: galleryElement.getAttribute('data-pswp-uid'),

            getThumbBoundsFn: function(index) {
                // See Options -> getThumbBoundsFn section of documentation for more info
                var thumbnail = items[index].el.getElementsByTagName('img')[0], // find thumbnail
                    pageYScroll = window.pageYOffset || document.documentElement.scrollTop,
                    rect = thumbnail.getBoundingClientRect();

                return {x:rect.left, y:rect.top + pageYScroll, w:rect.width};
            },

            showAnimationDuration: 200

        };

        if(disableAnimation) {
            options.showAnimationDuration = 0;
        }

        // Pass data to PhotoSwipe and initialize it
        gallery = new PhotoSwipe( pswpElement, PhotoSwipeUI_Default, gallery_items, options);
        gallery.init();
    };

    // loop through all gallery elements and bind events
    var galleryElements = document.getElementsByClassName( gallerySelector );

    for(var i = 0, l = galleryElements.length; i < l; i++) {
        galleryElements[i].setAttribute('data-pswp-uid', i+1);
        galleryElements[i].onclick = onThumbnailsClick;
    }

    // Parse URL and open gallery if it contains #&pid=3&gid=1
    var hashData = photoswipeParseHash();
    if(hashData.pid > 0 && hashData.gid > 0) {
        openPhotoSwipe( hashData.pid - 1 ,  galleryElements[ hashData.gid - 1 ], false );
    }
};

// execute above function
if (PhotoSwipe) {
    initPhotoSwipeFromDOM('gallery');
}

// nav action

(function () {
    var nav_toggle = document.getElementById( "nav-toggle" );
    var nav = document.getElementById("main-navigation");
    var nav_toggle_clicked = false;
    var outside_clicked = false;

    document.addEventListener("click", function(e) {
        if(nav != e.target) {
            nav.className = "";
            nav_toggle.className = "";
        }
    });

    nav_toggle.addEventListener( "click", function(e) {
        if (this.className) {
            this.className = "";
            nav.className = "";
        } else {
            this.className = "active";
            nav.className = "active";
        }
        e.stopPropagation();
        e.preventDefault();
    });
}());
