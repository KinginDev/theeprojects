/**
 * Merchant Portal - Menu Fix Script
 * This script ensures proper sidebar menu functionality
 */

// Check if jQuery is loaded
if (typeof jQuery !== 'undefined') {
    (function ($) {
        "use strict";

        $(document).ready(function () {
            // Initialize data-title attributes for all menu items
            function initMenuAttributes() {
                $("#sidebar-menu ul li a").each(function () {
                    // Add data-title if it doesn't exist
                    if (!$(this).attr('data-title') && $(this).find('span').length > 0) {
                        $(this).attr('data-title', $(this).find('span').text().trim());
                    }

                    // Handle submenu items
                    if ($(this).hasClass("has-arrow")) {
                        var menuTitle = $(this).find('span').text().trim();
                        $(this).attr("title", menuTitle + " (has submenu)");

                        // Set data-title for submenu
                        var subMenu = $(this).next("ul.sub-menu");
                        if (subMenu.length && !subMenu.attr('data-title')) {
                            subMenu.attr('data-title', menuTitle);
                        }
                    }
                });

                // Set data-title for submenu items
                $("#sidebar-menu ul.sub-menu li a").each(function() {
                    if (!$(this).attr('data-title')) {
                        $(this).attr('data-title', $(this).text().trim());
                    }
                });
            }

            // Initialize menu attributes
            initMenuAttributes();

            // Create overlay for mobile if it doesn't exist
            if ($(".vertical-menu-overlay").length === 0) {
                $("body").append('<div class="vertical-menu-overlay"></div>');
            }

            // Set initial menu state based on window size
            function setInitialMenuState() {
                if ($(window).width() < 992) {
                    $("body").addClass("vertical-collpsed");
                    $(".vertical-menu").css("left", "-70px");
                }

                applyMenuStyles();
            }

            // Apply appropriate styles based on menu state
            function applyMenuStyles() {
                if ($("body").hasClass("vertical-collpsed")) {
                    // Collapsed mode styles
                    $("#sidebar-menu ul li a i").css({
                        "margin-right": "0",
                        "margin": "0 auto"
                    });

                    $("#sidebar-menu ul li a span").css("opacity", "0");

                    // Set proper menu dimensions
                    $(".vertical-menu").css("width", "70px");
                    $(".main-content").css("margin-left", "70px");
                } else {
                    // Expanded mode styles
                    $("#sidebar-menu ul li a i").css({
                        "margin-right": "10px",
                        "margin": ""
                    });

                    $("#sidebar-menu ul li a span").css("opacity", "1");

                    // Set proper menu dimensions
                    $(".vertical-menu").css("width", "250px");
                    $(".main-content").css("margin-left", "250px");
                }
            }

            // Handle submenu hover in collapsed mode
            function setupSubmenuHover() {
                // Remove any existing hover handlers first
                $("#sidebar-menu ul li").off("mouseenter mouseleave");

                // Only add hover handlers if we're in collapsed mode
                if ($("body").hasClass("vertical-collpsed")) {
                    $("#sidebar-menu ul li").hover(
                        function() {
                            if ($(this).find("ul.sub-menu").length > 0) {
                                var parentTop = $(this).position().top;
                                var windowHeight = $(window).height();
                                var submenuHeight = $(this).find("ul.sub-menu").outerHeight() || 200;

                                // Adjust position to keep submenu in viewport
                                if (parentTop + submenuHeight > windowHeight) {
                                    var newTop = Math.max(0, windowHeight - submenuHeight - 20);
                                    $(this).find("ul.sub-menu").css("top", newTop);
                                } else {
                                    $(this).find("ul.sub-menu").css("top", parentTop);
                                }

                                $(this).find("ul.sub-menu").stop().fadeIn(150);
                                $(this).addClass("submenu-active");
                            }
                        },
                        function() {
                            $(this).find("ul.sub-menu").stop().fadeOut(100);
                            $(this).removeClass("submenu-active");
                        }
                    );
                }
            }

            // Toggle menu state
            $("#vertical-menu-btn").on("click", function(e) {
                e.preventDefault();

                // Toggle mobile menu state
                $("body").toggleClass("sidebar-enable");

                // Only toggle collapsed state on desktop
                if ($(window).width() >= 992) {
                    $("body").toggleClass("vertical-collpsed");
                }

                // Update mobile overlay state
                if ($(window).width() < 992 && $("body").hasClass("sidebar-enable")) {
                    $(".vertical-menu-overlay").addClass("active");
                } else {
                    $(".vertical-menu-overlay").removeClass("active");
                }

                // Apply appropriate styles after a short delay
                setTimeout(function() {
                    applyMenuStyles();
                    setupSubmenuHover();
                }, 50);
            });

            // Close sidebar when clicking outside or on overlay
            $(document).on("click", ".vertical-menu-overlay", function() {
                $("body").removeClass("sidebar-enable");
                $(".vertical-menu-overlay").removeClass("active");
            });

            $(document).on("click", function(e) {
                if ($(e.target).closest('.vertical-menu, #vertical-menu-btn').length === 0) {
                    $("body").removeClass("sidebar-enable");
                    $(".vertical-menu-overlay").removeClass("active");
                }
            });

            // Handle window resize
            $(window).resize(function() {
                if ($(window).width() < 992) {
                    if (!$("body").hasClass("sidebar-enable")) {
                        $(".vertical-menu").css("left", "-70px");
                        $("body").addClass("vertical-collpsed");
                    }
                } else {
                    if (!$("body").hasClass("vertical-collpsed")) {
                        $(".vertical-menu").css("left", "0");
                    }
                }

                applyMenuStyles();
                setupSubmenuHover();
            });

            // Handle submenu toggle in expanded mode
            $(document).on("click", ".has-arrow", function(e) {
                if (!$("body").hasClass("vertical-collpsed")) {
                    if ($(this).parent().hasClass("mm-active")) {
                        $(this).next(".sub-menu").slideUp(200, function() {
                            $(this).removeClass("mm-show");
                        });
                        $(this).parent().removeClass("mm-active");
                    } else {
                        $(this).next(".sub-menu").slideDown(200, function() {
                            $(this).addClass("mm-show");
                        });
                        $(this).parent().addClass("mm-active");
                    }
                }
            });

            // Initialize menu state
            setInitialMenuState();
            setupSubmenuHover();
        });

    })(jQuery);
}

