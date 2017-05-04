document.addEventListener("DOMContentLoaded", function ()
{
  Barba.Pjax.init();
  var FadeTransition = Barba.BaseTransition.extend({
    start:       function ()
                 {
                   /**
                    * This function is automatically called as soon the Transition starts
                    * this.newContainerLoading is a Promise for the loading of the new container
                    * (Barba.js also comes with an handy Promise polyfill!)
                    */

                   // As soon the loading is finished and the old page is faded out, let's fade the new page
                   Promise
                     .all([this.showLoading(), this.newContainerLoading, this.fadeOut()])
                     .then(this.fadeIn.bind(this))
                     .then(this.hideLoading.bind(this));
                 },
    showLoading: function ()
                 {

                   $('#loading-overlay').addClass('show');

                 },
    hideLoading: function ()
                 {
                   $('#loading-overlay').removeClass('show');
                   this.done();
                 },
    fadeOut:     function ()
                 {
                   /**
                    * this.oldContainer is the HTMLElement of the old Container
                    */
                   return $(this.oldContainer).animate({opacity: 0}).promise();
                 },

    fadeIn: function ()
            {

              var $el = $(this.newContainer);

              $(this.oldContainer).hide();

              $el.css({
                visibility: 'visible',
                opacity:    0
              });

              $el.animate({opacity: 1}, 400, function ()
              {
              }).promise();
            }
  });

  /**
   * Next step, you have to tell Barba to use the new Transition
   */

  Barba.Pjax.getTransition = function ()
  {
    /**
     * Here you can use your own logic!
     * For example you can use different Transition based on the current page or link...
     */

    return FadeTransition;
  };
});