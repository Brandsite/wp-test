import { gsap } from 'gsap';
import { ScrollTrigger } from 'gsap/ScrollTrigger';
import { ScrollSmoother } from 'gsap/ScrollSmoother';
import { ScrollToPlugin } from 'gsap/ScrollToPlugin';

import { everyPage } from './main/every_page';

gsap.registerPlugin(ScrollTrigger, ScrollSmoother);

//-------------------------------------------------------------------------------------------------------------------------------
//Media query
const mm = gsap.matchMedia(),
  breakPoint = 1100,
  sm = 700;

mm.add(
  {
    // set up any number of arbitrarily-named conditions. The function below will be called when ANY of them match.
    isDesktop: `(min-width: ${breakPoint}px)`,
    isMobile: `(max-width: ${breakPoint - 1}px)`,
    isSm: `(max-width: ${sm - 1}px)`,
  },
  (context) => {
    // context.conditions has a boolean property for each condition defined above indicating if it's matched or not.
    let { isDesktop, isMobile, isSm } = context.conditions;

    /**
     * -------------------------------------------------------------------------------------------------------------------------------
     * Initialize stuff
     */

    window.addEventListener('DOMContentLoaded', () => {
      gsap.registerPlugin(ScrollTrigger, ScrollToPlugin);

      gsap.config({ nullTargetWarn: false });
      console.warn = () => {};
    });

    //-------------------------------------------------------------------------------------------------------------------------------
    window.addEventListener('load', () => {
      everyPage();
    });

    //---------------------------------------------------------------------------------
    window.addEventListener('resize', () => {
      ScrollTrigger.refresh();
    });

    return () => {
      // optionally return a cleanup function that will be called when none of the conditions match anymore (after having matched)
    };
  }
);
