$(document).ready(function () {

    //mobile menu script
    //$("body").attr('id', 'page');
    $("#top-menu").clone().appendTo("#mobile-menu");
    $("#main-menu").clone().appendTo("#mobile-menu");
    $("#mobile-menu-icon").click(function () {
        if ($(this).hasClass("active"))
        {
            $(this).removeClass("active");
            $("#wrapper").animate({"left": "0"}, 500);
        } else
        {
            $(this).addClass("active");
            $("#wrapper").animate({"left": "-250px"}, 500);

        }

        if ($("#mobile-menu").hasClass("active")) {
            $("#mobile-menu").removeClass("active");
            $("#mobile-menu").animate({"right": "-250px"}, 500);
        } else
        {
            $("#mobile-menu").addClass("active");
            $("#mobile-menu").animate({"right": "0"}, 500);
        }
    });

    $('#mobile-menu ul li.submenu-one>a').prepend('<span class="submenu"></span>');
    $('#mobile-menu ul li.submenu-one>a').click(function (e) {
        $(this).parent().children().eq(1).slideToggle(500);
        $(this).parent().toggleClass('changebg');
        return false;
    });

    $('#mobile-menu ul li ul li.submenu-two>a').prepend('<span class="submenu"></span>');
    $('#mobile-menu ul li ul li.submenu-two>a').click(function (e) {
        $(this).parent().children().eq(1).slideToggle(500);
        $(this).parent().toggleClass('changebg');
        return false;
    });

    $('#mobile-menu ul li ul li ul li.submenu-three>a').prepend('<span class="submenu"></span>');
     $('#mobile-menu ul li ul li ul li.submenu-three>a').click(function (e) {
     $(this).parent().children().eq(1).slideToggle(500);
     $(this).parent().toggleClass('changebg');
     return false;
     });
     
     /* Dashboard Sidebar Menu */
    $("#dashboard-menu-icon").click(function () {
        if ($(this).hasClass("active"))
        {
            $(this).removeClass("active");
            $("#myaccount-sidebar ul").slideUp();
        } else
        {
            $(this).addClass("active");
            $("#myaccount-sidebar ul").slideDown();
        }
    });


});