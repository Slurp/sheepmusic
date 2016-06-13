// Javascript file.
// Start of main application
$(function () {
    $('[data-toggle="offcanvas"]').click(function () {
        $('.row-offcanvas').toggleClass('active')
    });
    $('[data-toggle="popover"]').popover();
    $('.button-collapse').sideNav({
            menuWidth: 200, // Default is 240
        }
    );
});