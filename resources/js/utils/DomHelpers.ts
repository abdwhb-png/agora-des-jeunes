/*eslint no-empty: "off"*/

function getCSS(el: HTMLElement, styleProp: string) {
    const defaultView = (el.ownerDocument || document).defaultView;

    if (!defaultView) {
        return "";
    }

    // sanitize property name to css notation
    // (hyphen separated words eg. font-Size)
    styleProp = styleProp.replace(/([A-Z])/g, "-$1").toLowerCase();

    return defaultView.getComputedStyle(el, null).getPropertyValue(styleProp);
}

export function getCSSVariableValue(variableName: string) {
    let hex = getComputedStyle(document.documentElement).getPropertyValue(
        variableName,
    );
    if (hex && hex.length > 0) {
        hex = hex.trim();
    }

    return hex;
}

function getElementActualCss(el: HTMLElement, prop: any, cache: boolean) {
    let css = "";

    if (!el.getAttribute("kt-hidden-" + prop) || cache === false) {
        let value;

        // the element is hidden so:
        // making the el block so we can meassure its height but still be hidden
        css = el.style.cssText;
        el.style.cssText =
            "position: absolute; visibility: hidden; display: block;";

        if (prop === "width") {
            value = el.offsetWidth;
        } else if (prop === "height") {
            value = el.offsetHeight;
        }

        el.style.cssText = css;

        // store it in cache
        if (value !== undefined) {
            el.setAttribute("kt-hidden-" + prop, value.toString());
            return parseFloat(value.toString());
        }
        return 0;
    } else {
        // store it in cache
        const attributeValue = el.getAttribute("kt-hidden-" + prop);
        if (attributeValue || attributeValue === "0") {
            return parseFloat(attributeValue);
        }
    }
}

function getElementActualHeight(el: HTMLElement) {
    return getElementActualCss(el, "height", false);
}

function getElementActualWidth(el: HTMLElement, cache: boolean = false) {
    return getElementActualCss(el, "width", cache);
}

function getElementIndex(element: HTMLElement) {
    if (element.parentNode) {
        const c = element.parentNode.children;
        for (let i = 0; i < c.length; i++) {
            if (c[i] === element) return i;
        }
    }
    return -1;
}

// https://developer.mozilla.org/en-US/docs/Web/API/Element/matches
function getElementMatches(element: HTMLElement, selector: string) {
    const p = Element.prototype;
    const f = p.matches || p.webkitMatchesSelector;

    if (element && element.tagName) {
        return f.call(element, selector);
    } else {
        return false;
    }
}

function getElementParents(element: Element, selector: string) {
    // Element.matches() polyfill
    if (!Element.prototype.matches) {
        Element.prototype.matches = function (s) {
            const matches = (document || this.ownerDocument).querySelectorAll(
                s,
            );
            let i = matches.length;
            while (--i >= 0 && matches.item(i) !== this) {}
            return i > -1;
        };
    }

    // Set up a parent array
    const parents: Array<Element> = [];

    let el: Element | null = element;

    // Push each parent element to the array
    for (; el && el !== document.body; el = el.parentElement) {
        if (selector) {
            if (el.matches(selector)) {
                parents.push(el);
            }
            continue;
        }
        parents.push(el);
    }

    // Return our parent array
    return parents;
}

function getHighestZindex(el: HTMLElement) {
    let bufferNode: Node | null = el as Node;
    let buffer = el;
    while (bufferNode && bufferNode !== document) {
        // Ignore z-index if position is set to a value where z-index is ignored by the browser
        // This makes behavior of this function consistent across browsers
        // WebKit always returns auto if the element is positioned
        const position = buffer.style.getPropertyValue("position");
        if (
            position === "absolute" ||
            position === "relative" ||
            position === "fixed"
        ) {
            // IE returns 0 when zIndex is not specified
            // other browsers return a string
            // we ignore the case of nested elements with an explicit value of 0
            // <div style="z-index: -10;"><div style="z-index: 0;"></div></div>
            const value = parseInt(buffer.style.getPropertyValue("z-index"));
            if (!isNaN(value) && value !== 0) {
                return value;
            }
        }

        bufferNode = bufferNode.parentNode;
        buffer = bufferNode as HTMLElement;
    }
    return null;
}

function getScrollTop(): number {
    return (document.scrollingElement || document.documentElement).scrollTop;
}
