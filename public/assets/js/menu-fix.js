/**
 * Merchant Portal - Menu Fix Script
 * This script ensures proper sidebar menu functionality
 */

// Check if jQuery is loaded
if (typeof jQuery !== 'undefined') {
    (function ($) {
        "use strict";

        $(document).ready(function () {
            // Improved initialization of data-title attributes for all menu items
            $("#sidebar-menu ul li a").each(function () {
                // Add data-title if it doesn't exist
                if (!$(this).attr('data-title') && $(this).find('span').length > 0) {
                    $(this).attr('data-title', $(this).find('span').text().trim());
                }

                // Better handling for submenu items
                if ($(this).hasClass("has-arrow")) {
                    // Add tooltip for has-arrow items
                    var menuTitle = $(this).find('span').text().trim();
                    $(this).attr("title", menuTitle + " (has submenu)");

                    // Also ensure the submenu has a data-title attribute
                    var subMenu = $(this).next("ul.sub-menu");
                    if (subMenu.length && !subMenu.attr('data-title')) {
                        subMenu.attr('data-title', menuTitle);
                    }
                }
            });

            // Add tooltip handling to submenu items too
            $("#sidebar-menu ul.sub-menu li a").each(function () {
                if (!$(this).attr('data-title')) {
                    $(this).attr('data-title', $(this).text().trim());
                }
            });

            // Enhanced vertical menu toggle button with smooth transitions
            $("#vertical-menu-btn").on("click", function (e) {
                e.preventDefault();
                $("body").toggleClass("sidebar-enable");

                if ($(window).width() >= 992) {
                    $("body").toggleClass("vertical-collpsed");

                    // Toggle menu appearance with smooth transition
                    if ($("body").hasClass("vertical-collpsed")) {
                        $(".vertical-menu").css({
                            "width": "70px",
                            "transition": "width 0.25s ease-in-out"
                        });
                        $(".main-content").css({
                            "margin-left": "70px",
                            "transition": "margin-left 0.25s ease-in-out"
                        });

                        // Fix icon alignment in collapsed mode
                        $("#sidebar-menu ul li a i").css({
                            "margin-right": "0",
                            "margin": "0 auto",
                            "transition": "all 0.25s ease-in-out"
                        });

                        // Hide all menu text with a slight delay for smoother animation
                        setTimeout(function () {
                            $("#sidebar-menu ul li a span").css("opacity", "0");
                        }, 100);
                    } else {
                        $(".vertical-menu").css({
                            "width": "250px",
                            "transition": "width 0.25s ease-in-out"
                        });
                        $(".main-content").css({
                            "margin-left": "250px",
                            "transition": "margin-left 0.25s ease-in-out"
                        });

                        // Restore icon margins in expanded mode
                        $("#sidebar-menu ul li a i").css({
                            "margin-right": "10px",
                            "margin": "",
                            "transition": "all 0.25s ease-in-out"
                        });

                        // Show all menu text with a slight delay for smoother animation
                        setTimeout(function () {
                            $("#sidebar-menu ul li a span").css("opacity", "1");
                        }, 100);
                    }
                }
            });

            // Fix icon alignment if page loads in collapsed mode
            if ($("body").hasClass("vertical-collpsed")) {
                $("#sidebar-menu ul li a i").css({
                    "margin-right": "0",
                    "margin": "0 auto"
                });

                // Add special handling for submenu hover
                $("#sidebar-menu ul li").hover(function () {
                    if ($(this).find("ul.sub-menu").length > 0) {
                        // Position the submenu correctly relative to the parent
                        var parentTop = $(this).position().top;
                        $(this).find("ul.sub-menu").css("top", parentTop);

                        // Ensure submenu appears beside the parent item
                        $(this).find("ul.sub-menu").show();
                    }
                }, function () {
                    $(this).find("ul.sub-menu").hide();
                });
            }

            // Create overlay for mobile if it doesn't exist
            if ($(".vertical-menu-overlay").length === 0) {
                $("body").append('<div class="vertical-menu-overlay"></div>');
            }

            // Close sidebar when clicking outside or on overlay
            $(document).on("click", ".vertical-menu-overlay", function () {
                $("body").removeClass("sidebar-enable");
                $(".vertical-menu-overlay").removeClass("active");
            });

            // Also close when clicking outside
            $(document).on("click", function (e) {
                if ($(e.target).closest('.vertical-menu, #vertical-menu-btn').length === 0) {
                    $("body").removeClass("sidebar-enable");
                    $(".vertical-menu-overlay").removeClass("active");
                }
            });

            // Add overlay when mobile menu is opened
            $("#vertical-menu-btn").on("click", function () {
                if ($(window).width() < 992 && $("body").hasClass("sidebar-enable")) {
                    $(".vertical-menu-overlay").addClass("active");
                } else {
                    $(".vertical-menu-overlay").removeClass("active");
                }
            });

            // Resize event handler
            function handleWindowResize() {
                if ($(window).width() < 992) {
                    $("body").addClass("vertical-collpsed");

                    if (!$("body").hasClass("sidebar-enable")) {
                        $(".vertical-menu").css("left", "-70px");
                    }

                    // Ensure proper icon alignment in mobile
                    $("#sidebar-menu ul li a i").css({
                        "margin-right": "0",
                        "margin": "0 auto"
                    });
                } else {
                    if (!$("body").hasClass("vertical-collpsed")) {
                        $(".vertical-menu").css("left", "0");

                        // Restore icon margins in desktop
                        $("#sidebar-menu ul li a i").css({
                            "margin-right": "10px"
                        });
                    }
                }
            }

            // Initial call and bind to resize event
            handleWindowResize();
            $(window).resize(function () {
                handleWindowResize();
            });

            // Handle submenu open/close
            $(".has-arrow").on("click", function (e) {
                if ($(this).parent().hasClass("mm-active")) {
                    $(this).next(".sub-menu").slideUp(300, function () {
                        $(this).removeClass("mm-show");
                    });
                } else {
                    $(this).next(".sub-menu").slideDown(300, function () {
                        $(this).addClass("mm-show");
                    });
                }
            });
        });

    })(jQuery);
}
