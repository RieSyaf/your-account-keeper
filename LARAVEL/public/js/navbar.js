jQuery(function ($) {
    $(".sidebar-dropdown > a").click(function (e) {
      e.preventDefault();
  
      const parent = $(this).parent();
  
      if (parent.hasClass("active")) {
        // Close the current dropdown if it's already open
        parent.removeClass("active");
        parent.find(".sidebar-submenu").slideUp(200);
      } else {
        // Open the clicked dropdown
        parent.addClass("active");
        parent.find(".sidebar-submenu").slideDown(200);
      }
    });
  
    $("#close-sidebar").click(function () {
      $(".page-wrapper").removeClass("toggled");
    });
  
    $("#show-sidebar").click(function () {
      $(".page-wrapper").addClass("toggled");
    });
  });
  