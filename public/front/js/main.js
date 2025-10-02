AOS.init({
    duration: 800,
    easing: 'slide',
    once: true
});

document.addEventListener("DOMContentLoaded", function () {
    // فتح وإغلاق البحث
    const searchOpen = document.querySelector(".js-search-open");
    const searchClose = document.querySelector(".js-search-close");
    const searchWrap = document.querySelector(".search-wrap");

    if (searchOpen && searchClose && searchWrap) {
        searchOpen.addEventListener("click", function (e) {
            e.preventDefault();
            searchWrap.classList.add("active");
        });

        searchClose.addEventListener("click", function (e) {
            e.preventDefault();
            searchWrap.classList.remove("active");
        });

        document.addEventListener("click", function (event) {
            if (!searchWrap.contains(event.target) && !searchOpen.contains(event.target)) {
                searchWrap.classList.remove("active");
            }
        });
    }

    const menuToggle = document.querySelector(".js-menu-toggle");
    const siteNav = document.querySelector(".site-navigation");
    const body = document.body;

    if (menuToggle && siteNav) {
        menuToggle.addEventListener("click", function (e) {
            e.preventDefault();
            body.classList.toggle("offcanvas-menu");
            siteNav.classList.toggle("active");
        });

        document.addEventListener("click", function (event) {
            if (!menuToggle.contains(event.target) && !siteNav.contains(event.target)) {
                body.classList.remove("offcanvas-menu");
                siteNav.classList.remove("active");
            }
        });
    }
});

document.addEventListener("DOMContentLoaded", function () {
    const dropdownToggle = document.getElementById("dropdownToggle");
    const dropdownMenu = document.getElementById("dropdownMenu");

    dropdownToggle.addEventListener("click", function (event) {
        event.preventDefault();
        dropdownMenu.style.display = dropdownMenu.style.display === "block" ? "none" : "block";
    });

    document.addEventListener("click", function (event) {
        if (!dropdownToggle.contains(event.target) && !dropdownMenu.contains(event.target)) {
            dropdownMenu.style.display = "none";
        }
    });
});

$(document).ready(function(){
    "use strict";

    var owl = $(".nonloop-block-3");

    owl.owlCarousel({
        items: 3,
        loop: false,        // لا تكرار لا نهائي
        margin: 20,
        nav: false,         // إزالة الأسهم نهائيًا
        dots: true,         // تفعيل النقاط
        dotsEach: 1,        // جعل كل نقطة تتحكم في منتج واحد
        autoplay: true,     // تشغيل تلقائي
        autoplayTimeout: 3000,
        autoplayHoverPause: true, // إيقاف التشغيل عند التفاعل
        rewind: true,       // العودة للبداية بعد النهاية
        responsive: {
            0: { items: 1 },
            600: { items: 2 },
            1000: { items: 3 },
        }
    });

    // إزالة النقطة الرابعة إن وجدت
    setTimeout(function() {
        $(".owl-dots .owl-dot").eq(3).remove();
    }, 500);
});
