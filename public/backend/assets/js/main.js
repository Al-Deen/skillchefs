(function ($) {
  "use strict";


    let interSectedLastItemOfElement = false;

    const identifyLastItemOfMenuElement = (function () {
    const init = function () {
        createObserver();
    };

    const createObserver = function () {
        let options = {
        root: document.querySelector("#sidebar"),
        rootMargin: "0px 0px -200px 0px",
        threshold: 1.0,
        };

        let observer = new IntersectionObserver(function (entries, observer) {
        handleIntersect(entries, observer);
        }, options);

        // sidebar - menu - item;

        let targetElements = document.querySelectorAll(
        ".sidebar-menu-item:last-child"
        );

        targetElements.forEach((targetElement) => {
        observer.observe(targetElement);
        });
    };

    const handleIntersect = function (entries, observer) {
        entries.forEach((entry) => {
        if (entry.isIntersecting) {
            interSectedLastItemOfElement = true;
        }
        });
    };

    return {
        init,
    };
    })();

    identifyLastItemOfMenuElement.init();

    $(document).ready(function () {
    // Sibear Scroll on half expand start

    let sidebarOffsetTop = $(".sidebar-menu").offset().top;
    let scrollTop = sidebarOffsetTop;

    $(".sidebar").on("wheel", function (event) {
        let direction = event.originalEvent.deltaY;

        if (direction > 0) {
        scrollTop = scrollTop - 10;

        if (!interSectedLastItemOfElement) {
            $(".sidebar-menu").css("top", `${scrollTop}px`);
        }
        } else {
        if (sidebarOffsetTop > scrollTop) {
            interSectedLastItemOfElement = false;
            scrollTop = scrollTop + 10;
            $(".sidebar-menu").css("top", `${scrollTop}px`);
        }
        }
    });

    // Sibear Scroll on half expand end



    //selected menu item start

    let current = location.pathname.split("/")[1];

    $(".sidebar-dropdown-menu li a").each(function () {
        let $this = $(this);

        if ($this.attr("href") == current) {
        $this.parents(".child-menu-list").addClass("mm-show");
        $this.parents(".sidebar-menu-item").addClass("mm-active");

        // scroll to selected menu item start
        let $container = $(".sidebar-menu");
        let $scrollTo = $this.parents(".sidebar-menu-item .mm-active");

        $container.animate(
            {
            scrollTop:
                $scrollTo.offset().top -
                $container.offset().top +
                $container.scrollTop(),
            scrollLeft: 0,
            },
            300
        );
        }
    });
    //selected menu item end

    //menubar
    $(".sidebar-dropdown-menu").metisMenu();


    // transition to dropdown menu
    $(".item-content button").on("click", function () {
        let thisBtn = this;

        setTimeout(function () {
        let headerHeight = $(".header").outerHeight();
        let menuPosition = $(thisBtn).siblings(".dropdown-menu").offset().top;
        for (let i = 0; i < headerHeight - menuPosition; i++) {
            $(".dropdown-menu").css("top", headerHeight - menuPosition);
            $(".dropdown-menu").css("transition", "top .4s");
        }
        }, 200);
    });


    // nice select
    if ($(".niceSelect").length) {
        $(".niceSelect").niceSelect();
    }


    // Select 2 Active
    $(".language-select, .multi-select2").select2();


    // top header on scroll background color change
    $(window).scroll(function () {
        if ($(window).scrollTop() >= 20) {
        $(".header").addClass("on-scroll");
        } else {
        $(".header").removeClass("on-scroll");
        }
    });

    // sidebar toggle
    $(".half-expand-toggle").on("click", function () {
        scrollTop = $(".sidebar-menu").offset().top;
        $("#layout-wrapper").toggleClass("half-expand");
    });

    $(".close-toggle").on("click", function () {
        $("#layout-wrapper").toggleClass("sidebar-expand");
    });

    // onclick browse by class name
    $('.file-upload-browse').on('change', function(event) {
        var fileName = event.target.files[0].name;
        $(this).find('.file_placeholder').attr('placeholder', fileName);
    });


   // ONLICK BROUSE FILE UPLOADER by ID
    var fileInp = document.getElementById("fileBrouse");
    var fileInp2 = document.getElementById("fileBrouse2");
    var fileInp3 = document.getElementById("fileBrouse3");
    var fileInp4 = document.getElementById("fileBrouse4");

    if (fileInp) {
        fileInp.addEventListener("change", showFileName);

        function showFileName(event) {
        var fileInp = event.srcElement;
        var fileName = fileInp.files[0].name;
        document.getElementById("placeholder").placeholder = fileName;
        }
    }

    if (fileInp2) {
        fileInp2.addEventListener("change", showFileName);

        function showFileName(event) {
        var fileInp = event.srcElement;
        var fileName = fileInp.files[0].name;
        document.getElementById("placeholder2").placeholder = fileName;
        }
    }
    if (fileInp3) {
        fileInp3.addEventListener("change", showFileName);

        function showFileName(event) {
        var fileInp = event.srcElement;
        var fileName = fileInp.files[0].name;
        document.getElementById("placeholder3").placeholder = fileName;
        }
    }
    if (fileInp4) {
        fileInp4.addEventListener("change", showFileName);

        function showFileName(event) {
        var fileInp = event.srcElement;
        var fileName = fileInp.files[0].name;
        document.getElementById("placeholder4").placeholder = fileName;
        }
    }

    });

    // sidebar_scrollbar_active
    $(".sidebar_scrollbar_active").mCustomScrollbar({
        setTop: 0,
        autoHideScrollbar : true,
        mouseWheel : true,
    });

    // sidebar_scrollbar_active
    $(".scroll-table2-active").mCustomScrollbar({
        setTop: 0,
        autoHideScrollbar : true,
        mouseWheel : true,
    });

    if ($(".card_scroll_active .card-body").length > 0) {
        $(".card_scroll_active .card-body").mCustomScrollbar({
            setTop: 0,
            autoHideScrollbar: true,
            mouseWheel: true,
        });
    }
    function responsiveScroll(){
        $(".table_scrollbar_active").mCustomScrollbar({
            setTop: 0,
            autoHideScrollbar: true,
            mouseWheel: true,
            axis: "x",
        });
    }
    responsiveScroll();


    /*-----------------------------------
        chat-box message active single
    -----------------------------------*/
    $('.single-chat').click(function(){
        $(this).addClass('active');
        $(this).siblings().removeClass('active');
    })



})(jQuery);


