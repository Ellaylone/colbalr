//NOTE scroll time for page jumping
const SCROLL_TIME = 700;

//NOTE offset from top needed to show anchor-top
const ANCHOR_TOP_OFFSET = 800;

//NOTE catalog carousel settings
const CATALOG_CAROUSEL = '#catalogCarousel';
const CATALOG_CAROUSEL_INTERVAL = 3000;
const CATALOG_CAROUSEL_ITEMS_XS = 1;
const CATALOG_CAROUSEL_ITEMS_SM = 4;
const CATALOG_CAROUSEL_ITEMS_MD = 6;
const CATALOG_CAROUSEL_ITEMS_LG = 8;

//NOTE partners carousel settings
const PARTNERS_CAROUSEL = '#partnersCarousel';
const PARTNERS_CAROUSEL_INTERVAL = 3000;
const PARTNERS_CAROUSEL_ITEMS_XS = 1;
const PARTNERS_CAROUSEL_ITEMS_SM = 2;
const PARTNERS_CAROUSEL_ITEMS_MD = 3;
const PARTNERS_CAROUSEL_ITEMS_LG = 4;
var viewportWidth = window.innerWidth;

function throttle(fn, threshhold, scope) {
    threshhold || (threshhold = 250);
    var last,
        deferTimer;
    return function () {
        var context = scope || this;

        var now = +new Date,
            args = arguments;
        if (last && now < last + threshhold) {
            // hold on to it
            clearTimeout(deferTimer);
            deferTimer = setTimeout(function () {
                last = now;
                fn.apply(context, args);
            }, threshhold);
        } else {
            last = now;
            fn.apply(context, args);
        }
    };
}

window.onresize = throttle(function(event){
    viewportWidth = window.innerWidth;
    if(typeof catalogCarousel !== 'undefined' && catalogCarousel.length > 0){
        formCatalogCarousel();
    }
    if(typeof partnersCarousel !== 'undefined' && partnersCarousel.length > 0){
        formPartnersCarousel();
    }
});

//NOTE form carousel
function formCarousel(elem, items, itemLimit, interval){
    var i = 0;
    var result = '';
    items.forEach((item, key) => {
        if(i == 0) result += `<div class="item"><div>`;
        result += item;
        i++;
        if(i >= itemLimit || key === catalogCarousel.length - 1){
            result += `</div></div>`;
            i = 0;
        }
    });
    document.querySelector(elem + ' .carousel-inner').innerHTML = result;
    document.querySelector(elem + ' .item:first-child').classList.add('active');
    $(elem).carousel({
        interval: interval
    });
}

//NOTE form catalog carousel
function formCatalogCarousel(){
    var itemLimit;
    switch(true){
    case (viewportWidth <= 640):
        itemLimit = CATALOG_CAROUSEL_ITEMS_XS;
        break;
    case (viewportWidth <= 890):
        itemLimit = CATALOG_CAROUSEL_ITEMS_SM;
        break;
    case (viewportWidth <= 1180):
        itemLimit = CATALOG_CAROUSEL_ITEMS_MD;
        break;
    default:
        itemLimit = CATALOG_CAROUSEL_ITEMS_LG;
        break;
    }
    formCarousel(CATALOG_CAROUSEL, catalogCarousel, itemLimit, CATALOG_CAROUSEL_INTERVAL);
}

//NOTE form partners carousel
function formPartnersCarousel(){
    var itemLimit;
    switch(true){
    case (viewportWidth <= 640):
        itemLimit = PARTNERS_CAROUSEL_ITEMS_XS;
        break;
    case (viewportWidth <= 890):
        itemLimit = PARTNERS_CAROUSEL_ITEMS_SM;
        break;
    case (viewportWidth <= 1180):
        itemLimit = PARTNERS_CAROUSEL_ITEMS_MD;
        break;
    default:
        itemLimit = PARTNERS_CAROUSEL_ITEMS_LG;
        break;
    }
    formCarousel(PARTNERS_CAROUSEL, partnersCarousel, itemLimit, PARTNERS_CAROUSEL_INTERVAL);
}

//NOTE setup hammer swiper for catalog carousel
function setupCatalogHammerSwiper(){
    var catalogHammer = new Hammer(document.querySelector(CATALOG_CAROUSEL));
    catalogHammer.on('swipeleft', (function(){
        $(this.element).carousel('next');
    }).bind(catalogHammer));
    catalogHammer.on('swiperight', (function(){
        $(this.element).carousel('prev');
    }).bind(catalogHammer));
}

//NOTE setup hammer swiper for catalog carousel
function setupPartnersHammerSwiper(){
    var partnersHammer = new Hammer(document.querySelector(PARTNERS_CAROUSEL));
    partnersHammer.on('swipeleft', (function(){
        $(this.element).carousel('next');
    }).bind(partnersHammer));
    partnersHammer.on('swiperight', (function(){
        $(this.element).carousel('prev');
    }).bind(partnersHammer));
}

function emailValidate(target){
    if(defaultValidate(target, false)){
        if(target.value.match(/(@).*(\.)/g) == null){
            target.classList.add('error');
            return false;
        }
        target.classList.remove('error');
        return true
    }
    target.classList.add('error');
    return false;
}

function defaultValidate(target, show){
    if(target.value.trim() == ''){
        if(show)
            target.classList.add('error');
        return false;
    }
    if(show)
        target.classList.remove('error');
    return true;
}

function contactsFormChange(e) {
    switch(e.target.id){
    case 'contactform-email':
        emailValidate(e.target);
        break;
    case 'contactform-body':
        defaultValidate(e.target, true);
        break;
    default:
        defaultValidate(e.target, true);
        break;
    }

    var captcha = true;
    [].forEach.call(
        e.target.closest('form').querySelectorAll(
            '.form-group > input, .form-group > textarea'
        ),
        (field) => {
            console.log(field);
            if(field.value.trim() == '' || field.classList.contains('error'))
                captcha = false;
        }
    );

    if(captcha){
        document.querySelector('.contactsForm-form__capcha').classList.remove('hidden');
    } else {
        document.querySelector('.contactsForm-form__capcha').classList.add('hidden');
    }
}

$(document).ready(function() {
    if(typeof showBack !== 'undefined'){
        document.querySelector('.navbar > .container').classList.add('hidden');
        document.querySelector('.catalog-back').classList.remove('hidden');
        var url = '/#catalog';
        if(document.referrer.match('catalog') != null && window.location.pathname != '/catalog'){
            url = document.referrer;
        }
        document.querySelector('.catalog-back').closest('a').href = url;
    } else {
        document.querySelector('.catalog-back').classList.add('hidden');
        document.querySelector('.navbar > .container').classList.remove('hidden');
    }

    //NOTE anchor top sliding
    $(window).scroll(function() {
        if($(this).scrollTop() > ANCHOR_TOP_OFFSET){
            $('.anchor-top').stop().animate({
                right: '0px'
            }, 500);
        }
        else{
            $('.anchor-top').stop().animate({
                right: '-100px'
            }, 500, () => {
                $('.anchor-top').blur();
            });
        }
    });

    //NOTE smooth page jupming
    $(function() {
        $('nav a[href*="#"]:not([href="#"]), .anchor-top').click(function() {
            if (location.pathname.replace(/^\//,'') == this.pathname.replace(/^\//,'') && location.hostname == this.hostname) {
                var target = $(this.hash);
                if(target.selector == '#top'){
                    $('html, body').animate({
                        scrollTop: 0
                    }, SCROLL_TIME);
                    return false;
                } else {
                    target = target.length ? target : $('[name=' + this.hash.slice(1) +']');
                    if (target.length) {
                        $('html, body').animate({
                            scrollTop: target.offset().top
                        }, SCROLL_TIME);
                        return false;
                    }
                }
            }
        });
    });

    if(document.querySelector(".contactsForm iframe"))
        document.querySelector(".contactsForm iframe").style.width = "100%"

    if(typeof catalogCarousel !== 'undefined' && catalogCarousel.length > 0){
        formCatalogCarousel();
        setupCatalogHammerSwiper();
    }

    if(typeof partnersCarousel !== 'undefined' && partnersCarousel.length > 0){
        formPartnersCarousel();
        setupPartnersHammerSwiper();
    }

    if(document.querySelector('#contactsForm-form')){
        var contactsForm = document.querySelector('#contactsForm-form');
        contactsForm.onchange = contactsFormChange;
        contactsForm.querySelector('textarea').onblur = contactsFormChange;
        contactsForm.querySelector('textarea').onfocus = ((e) => {
            document.querySelector('.contactsForm-form__capcha').classList.add('hidden');
        });
        contactsForm.querySelector('#contactform-verifycode').onchange = ((e) => {
            contactsForm.querySelector('button').disabled = !defaultValidate(e.target);
        });
    }
});
