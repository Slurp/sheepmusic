// Javascript file.
// Start of main application

$(function ()
{
  $('[data-activates="side-nav"]').sideNav({
      menuWidth: 150, // Default is 240
    }
  );
  $('.backdrop  .info-bar').pushpin({
    top:    300,
    offset: 0
  });
  Barba.Dispatcher.on('transitionCompleted', function ()
  {
    $('.backdrop .info-bar').pushpin({
      top:    500,
      offset: 0
    });
  });
  $('body').on('click', '[data-expand]', function ()
  {
    $($(this).data('expand')).toggleClass('expanded');
  });

  $(document).on('submit', 'form', function (e)
  {
    jQuery.ajax({
      url:   e.target.getAttribute('action'),
      type: e.target.method || 'get',
      data: $(e.target).serialize()
    }).then(function (response)
    {
      var newContainer = new Promise(function (resolve, reject)
      {
        var container = Barba.Pjax.Dom.parseResponse(response);
        Barba.Pjax.Dom.putContainer(container);
        Barba.Pjax.History.add(response.url);
        window.history.pushState({}, '', response.url);
        setTimeout(resolve(container), 1);
      });

      var transition = Object.create(Barba.Pjax.getTransition());

      Barba.Pjax.transitionProgress = true;

      Barba.Dispatcher.trigger('initStateChange',
        Barba.Pjax.History.currentStatus(),
        Barba.Pjax.History.prevStatus()
      );

      var transitionInstance = transition.init(
        Barba.Pjax.Dom.getContainer(),
        newContainer
      );

      newContainer.then(
        Barba.Pjax.onNewContainerLoaded.bind(Barba.Pjax)
      );

      transitionInstance.then(
        Barba.Pjax.onTransitionEnd.bind(Barba.Pjax)
      );
    });

  });
});