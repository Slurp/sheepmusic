'use strict';

export default class Toaster {

  constructor () {
    this.view = document.getElementById('kebab');
    // Create toast container if it does not exist
    if (this.view === null) {
      // create notification this.view
      let view = document.createElement('div');
      view.id = 'kebab';
      view.classList.add('toast-view');
      this.view = document.body.appendChild(view);
    }
    this.hideTimeout = 0;
    this.hideBound = this.hide.bind(this);
  }

  toast (message) {

    this.view.textContent = message;
    this.view.classList.add('toast-view--visible');
    clearTimeout(this.hideTimeout);
    this.hideTimeout = setTimeout(this.hideBound, 5000);
  }

  hide () {
    this.view.classList.remove('toast-view--visible');
  }
}