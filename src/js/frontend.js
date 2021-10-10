document.addEventListener('DOMContentLoaded', function($) { 
    let progscroll = document.querySelector('#progscroll');

    if (!progscroll) {
        console.log('ProgScroll element is undefined.')
    }


    let html = document.documentElement;

    let win_height = window.innerHeight;
    let win_width = window.innerWidth;
    let doc_height = html.scrollHeight;

    let vert_location = 0;
    let horz_location = 0;

    setAttrs();

    function scaleDimens(scrollTop) {
        html = document.documentElement;
        win_height = window.innerHeight;
        win_width = window.innerWidth;
        doc_height = html.scrollHeight;
        
        vert_location = scrollTop;

        if (vert_location < doc_height - win_height) {
            horz_location = (vert_location / doc_height) * win_width;
        }
        else {
            vert_location = doc_height;
            horz_location = win_width;
        }

        progscroll.style.width = horz_location + 'px';
    }

    function getPositionFromScreenSize() {
        let position = 0;
        let units = 'px';

        console.log(win_width)
        if (win_width < 576) { // xs
            position = getAttr('data-position-xs', 0);
            units = getAttr('data-position-xs-unit', 'px');
        } else if (win_width >= 576 && win_width < 768) { // sm
            position = getAttr('data-position-sm', 0);
            units = getAttr('data-position-sm-unit', 'px');
        } else if (win_width >= 768 && win_width < 992) { // md
            position = getAttr('data-position-md', 0);
            units = getAttr('data-position-md-unit', 'px');
        } else if (win_width >= 992 && win_width < 1200) { // lg
            position = getAttr('data-position-lg', 0);
            units = getAttr('data-position-lg-unit', 'px');
        } else { // xl
            position = getAttr('data-position-xl', 0);
            units = getAttr('data-position-xl-unit', 'px');
        }

        return {position, units};
    }

    function hasAttr(attr) {
        return progscroll.hasAttribute(attr);
    }

    function getAttr(attr, default_val = '') {
        if (progscroll.hasAttribute(attr)) {
            let val = progscroll.getAttribute(attr);
            return val || val != '' ? val : default_val;
        }
        return 0;
    }

    function setAttrs() {
        let color = progscroll.getAttribute('data-color');
        let z_index = progscroll.getAttribute('data-z-index');
        let thickness = progscroll.getAttribute('data-thickness');
        let thickness_unit = progscroll.getAttribute('data-thickness-unit');

        let styles = '';

        if (color) {
            styles += `border-top-color: ${color} !important;`;
        }
    
        if (z_index) {
            styles += `z-index: ${z_index} !important;`;
        }

        if (thickness) {
            styles += `border-top-width: ${thickness}${thickness_unit} !important;`;
        }
    
        let {position, units} = getPositionFromScreenSize();
        console.log(position, units);
        if (position) {
            styles += `top: ${position}${units} !important;`;
        }
       
        if (styles) {
            progscroll.setAttribute('style', styles);
        }
    }

    document.addEventListener('scroll', (e) => {
        let scrollTop = Math.ceil(e.target.documentElement.scrollTop);
        scaleDimens(scrollTop);
    });

    window.addEventListener('resize', (e) => { 		
        html = document.documentElement;
        win_height = window.innerHeight;
        win_width = window.innerWidth;
        doc_height = html.scrollHeight;

        scaleDimens(html.scrollTop);
        setAttrs();
    });
});
