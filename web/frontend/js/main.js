// Javascript file.
// Start of main application

$(function ()
{
  $('[data-activates="side-nav"]').sideNav({
      menuWidth: 200, // Default is 240
    }
  );
  $('.backdrop  .info-bar').pushpin({
    top:    300,
    offset: 0
  });
  Barba.Dispatcher.on('transitionCompleted', function()
  {
    $('.backdrop .info-bar').pushpin({
      top:    500,
      offset: 0
    });
  });
  $('body').on('click','[data-expand]',function(){
    $($(this).data('expand')).toggleClass('expanded');
  })
});