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

            // Improved submenu hover handling in collapsed mode
            function setupSubmenuHover() {
                // Remove any existing hover handlers first
                $("#sidebar-menu ul li").off("mouseenter mouseleave");

                // Only handle hover events in collapsed mode
                if ($("body").hasClass("vertical-collpsed")) {
                    $("#sidebar-menu > ul > li").each(function () {
                        var $menuItem = $(this);

                        // Only apply hover handling to menu items with submenus
                        if ($menuItem.find("ul.sub-menu").length > 0) {
                            // Reset submenu display properties for collapsed mode
                            $menuItem.find("ul.sub-menu").css({
                                "display": "none",
                                "opacity": 0,
                                "visibility": "hidden",
                                "height": "auto",
                                "position": "absolute",
                                "left": "70px", // Match the width of collapsed sidebar
                                "top": "0",
                                "min-width": "220px",
                                "background": "#fff",
                                "box-shadow": "0 5px 20px rgba(0, 0, 0, 0.1)",
                                "border-radius": "0 8px 8px 0"
                            }).removeClass("mm-show");

                            // Apply hover event handlers
                            $menuItem.hover(
                                function () { // Mouse enter
                                    var $item = $(this);
                                    var $submenu = $item.find("ul.sub-menu");

                                    // First show with visibility hidden to measure dimensions
                                    $submenu.css({
                                        "display": "block",
                                        "visibility": "hidden",
                                        "opacity": 0
                                    });

                                    // Calculate proper position to stay in viewport
                                    var parentTop = $item.offset().top - $(window).scrollTop();
                                    var windowHeight = $(window).height();
                                    var submenuHeight = $submenu.outerHeight();

                                    // Position submenu to stay in viewport
                                    var newTop = parentTop;
                                    if (parentTop + submenuHeight > windowHeight) {
                                        newTop = Math.max(0, windowHeight - submenuHeight - 20);
                                    }

                                    // Apply positioning and show submenu with animation
                                    $submenu.css({
                                        "top": newTop,
                                        "visibility": "visible",
                                        "display": "block",
                                        "z-index": 1001,
                                        "border-left": "3px solid var(--merchant-primary)"
                                    }).stop().animate({
                                        "opacity": 1
                                    }, 200);

                                    $item.addClass("submenu-active");
                                },
                                function () { // Mouse leave
                                    var $item = $(this);
                                    var $submenu = $item.find("ul.sub-menu");

                                    $submenu.stop().animate({
                                        "opacity": 0
                                    }, 150, function () {
                                        $submenu.css({
                                            "display": "none",
                                            "visibility": "hidden"
                                        });
                                    });

                                    $item.removeClass("submenu-active");
                                }
                            );
                        }
                    });
                } else {
                    // Handle submenu visibility in expanded mode
                    $("#sidebar-menu > ul > li").each(function () {
                        var $menuItem = $(this);

                        if ($menuItem.find("ul.sub-menu").length > 0) {
                            var $submenu = $menuItem.find("ul.sub-menu");

                            // Reset proper positioning for expanded mode
                            $submenu.css({
                                "position": "",
                                "left": "",
                                "top": "",
                                "min-width": "",
                                "box-shadow": "",
                                "border-radius": "",
                                "border-left": "",
                                "z-index": ""
                            });

                            // If menu item is active, show its submenu
                            if ($menuItem.hasClass("mm-active")) {
                                $submenu.addClass("mm-show").css({
                                    "display": "block",
                                    "opacity": 1,
                                    "visibility": "visible"
                                });
                            }
                        }
                    });
                }
            }

            // Toggle menu state
            $("#vertical-menu-btn").on("click", function(e) {
                e.preventDefault();

                // Remember active submenus before toggling
                var activeMenuItems = [];
                $("#sidebar-menu ul li.mm-active").each(function () {
                    activeMenuItems.push($(this).index());
                });

                // Toggle mobile menu state
                $("body").toggleClass("sidebar-enable");

                // Only toggle collapsed state on desktop
                if ($(window).width() >= 992) {
                    $("body").toggleClass("vertical-collpsed");

                    // Handle menu state change
                    var isCollapsed = $("body").hasClass("vertical-collpsed");

                    // Reset submenus to appropriate state
                    $("#sidebar-menu ul li ul.sub-menu").each(function () {
                        var $submenu = $(this);
                        var $parent = $submenu.parent();

                        if (isCollapsed) {
                            // In collapsed mode, hide all submenus initially
                            $submenu.removeClass("mm-show").css({
                                "display": "none",
                                "opacity": 0,
                                "visibility": "hidden"
                            });

                            // But keep track of which ones were active
                            if ($parent.hasClass("mm-active")) {
                                $parent.data("was-active", true);
                            }
                        } else {
                            // In expanded mode, restore previously active submenus
                            if ($parent.hasClass("mm-active") || $parent.data("was-active")) {
                                $parent.addClass("mm-active").data("was-active", false);
                                $submenu.addClass("mm-show").css({
                                    "display": "block",
                                    "opacity": 1,
                                    "visibility": "visible"
                                });
                            }
                        }
                    });
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
                }, 100);
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
            });            // Handle submenu toggle in expanded mode
            $(document).on("click", ".has-arrow", function(e) {
                e.preventDefault(); // Prevent default action

                if (!$("body").hasClass("vertical-collpsed")) {
                    // Fixed submenu toggle for expanded mode
                    var $subMenu = $(this).next(".sub-menu");
                    var $parent = $(this).parent();

                    if ($parent.hasClass("mm-active")) {
                        // Close this submenu
                        $subMenu.slideUp(200, function () {
                            $(this).removeClass("mm-show").css({
                                "display": "none",
                                "opacity": 0,
                                "visibility": "hidden"
                            });
                            $parent.removeClass("mm-active");
                        });
                    } else {
                        // Close other open menus
                        $("#sidebar-menu .mm-active").each(function () {
                            var $activeItem = $(this);
                            if ($activeItem[0] !== $parent[0]) { // Don't close the current item
                                $activeItem.find(".sub-menu").slideUp(200, function () {
                                    $(this).removeClass("mm-show").css({
                                        "display": "none",
                                        "opacity": 0,
                                        "visibility": "hidden"
                                    });
                                    $activeItem.removeClass("mm-active");
                                });
                            }
                        });

                        // Open this menu
                        $parent.addClass("mm-active");
                        $subMenu.slideDown(200, function () {
                            $(this).addClass("mm-show").css({
                                "display": "block",
                                "opacity": 1,
                                "visibility": "visible"
                            });
                        });
                    }
                } else {
                    // Don't trigger click in collapsed mode
                    return false;
                }
            });

            // Initialize menu state
            setInitialMenuState();
            setupSubmenuHover();
        });

    })(jQuery);
}

