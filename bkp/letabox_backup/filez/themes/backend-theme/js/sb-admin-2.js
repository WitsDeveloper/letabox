$(function() {
    $('#side-menu').metisMenu();
});

//Loads the correct sidebar on window load,
//collapses the sidebar on window resize.
// Sets the min-height of #page-wrapper to window size
$(function() {
    $(window).bind("load resize", function() {
        var topOffset = 50;
        var width = (this.window.innerWidth > 0) ? this.window.innerWidth : this.screen.width;
        if (width < 768) {
            $('div.navbar-collapse').addClass('collapse');
            topOffset = 100; // 2-row-menu
        } else {
            $('div.navbar-collapse').removeClass('collapse');
        }

        var height = ((this.window.innerHeight > 0) ? this.window.innerHeight : this.screen.height) - 1;
        height = height - topOffset;
        if (height < 1) height = 1;
        if (height > topOffset) {
            $("#page-wrapper").css("min-height", (height) + "px");
        }
    });

    var url = window.location;
    // var element = $('ul.nav a').filter(function() {
    //     return this.href == url;
    // }).addClass('active').parent().parent().addClass('in').parent();
    var element = $('ul.nav a').filter(function() {
        return this.href == url;
    }).addClass('active').parent();

    while (true) {
        if (element.is('li')) {
            element = element.parent().addClass('in').parent();
        } else {
            break;
        }
    }
	
	// Tab Cookies require jQuery Cookie plugin
	// Any time a tab is clicked, save a cookie describing which tab it was, on which page.
	$("ul.nav-tabs.cookie li").on("click", function() {
        var cookieName = 'tab-'+document.URL.replace("/", "").replace(":", "").replace("%", "").replace("#", "");
        var cookieValue = $(this).find("a[role='tab']").attr("href");
        $.cookie(cookieName, cookieValue);
    })
	
	// Look up any cookies related to this page, and if we find one, read it and repick the related tab.
	var cookieName = 'tab-'+document.URL.replace("/", "").replace(":", "");
    if ($.cookie(cookieName)) {
        $("ul.nav-tabs.cookie li a[href='"+$.cookie(cookieName)+"']").click();
    }
	
});
