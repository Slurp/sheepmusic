// Javascript file.
// Start of main application
$(function () {
    $('[data-toggle="offcanvas"]').click(function () {
        $('.row-offcanvas').toggleClass('active')
    });
    $('[data-toggle="popover"]').popover();
    $('.brand-logo').sideNav({
            menuWidth: 200, // Default is 240
        }
    );

  var config = {
    // How long Waves effect duration
    // when it's clicked (in milliseconds)
    duration: 500,

    // Delay showing Waves effect on touch
    // and hide the effect if user scrolls
    // (0 to disable delay) (in milliseconds)
    delay: 200
  };

// Initialise Waves with the config
  Waves.init(config);

  // Adds .waves-effect and .waves-light to <button> elems
  Waves.attach('button', 'waves-light');

// Make .box ripple when user moves the mouse over it
// with no additional classes
  Waves.attach('.btn', null);
});