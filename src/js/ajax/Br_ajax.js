import { brSpinner } from './br_spinner';
import { gsap } from 'gsap';

/**
 * Extend this class
 */
export class BrAjax {
  constructor() {
    this.nonce = wp_ajax.restNonce;

    this.productId;
    this.action;
    this.spinner = brSpinner;
    this.isLoading = false;
  }

  /**
   * -------------------------------------------------------------------------------------------------------------------------------
   * Setters
   */
  setAction(action) {
    this.action = action;
    return this;
  }

  setSpinner(spinner) {
    this.spinner = spinner;
    return this;
  }

  /**
   * @param {string} endpoint REST api endpoint after baseUrl/wp-json/
   */
  setEndpoint(endpoint) {
    this.endpoint = wp_ajax.restUrl + endpoint;
    return this;
  }

  setAfterFetchCallback(afterFetchCallback) {
    this.afterFetchCallback = afterFetchCallback;
    return this;
  }

  /**
   * -------------------------------------------------------------------------------------------------------------------------------
   * @param {string} container CSS class selector of the container loader will be appended to
   * @param {string} position  CSS position
   */
  addLoader(container, position = 'fixed') {
    const parent = document.querySelectorAll(container);
    if (parent.length) {
      for (let i = 0; i < parent.length; i++) {
        const loaderContainer = document.createElement('div');
        loaderContainer.setAttribute(
          'style',
          `width:100%; height:100%; background-color: rgb(218, 199, 200, 0.36); z-index:900; position:${position}; top:0; left:0;`
        );
        loaderContainer.classList.add('br-loader-wrap');
        loaderContainer.insertAdjacentHTML('beforeend', brSpinner);

        const spinner = loaderContainer.querySelector('.rect-spinner');

        gsap.to(spinner, {
          rotate: 180,
          ease: 'power3.inOut',
          repeat: -1,
          duration: 1,
        });

        if (parent[i]) parent[i].appendChild(loaderContainer);
      }
    }
  }

  /**
   * -------------------------------------------------------------------------------------------------------------------------------
   */
  removeLoader() {
    const loader = document.querySelectorAll('.br-loader-wrap');

    if (loader.length) {
      for (let i = 0; i < loader.length; i++) {
        loader[i].remove();
      }
    }
  }
}
