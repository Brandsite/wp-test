import { gsap } from 'gsap';
import { ScrollToPlugin } from 'gsap/ScrollToPlugin';
import { ScrollTrigger } from 'gsap/ScrollTrigger';

gsap.registerPlugin(ScrollToPlugin, ScrollTrigger);

export function backToTop() {
  const toTopBut = document.getElementById('to-top');
  const head = toTopBut.querySelector('.head');
  // const toTopTime =
  //   document.querySelector('body').offsetHeight / window.innerHeight / 2;
  //console.log(toTopBut);
  toTopBut.addEventListener('click', () => {
    gsap.to(window, {
      scrollTo: 'body',
      duration: 1,
      ease: 'power2.out',
    });
  });

  const toTopEnterance = gsap.to(toTopBut, {
    autoAlpha: 1,
    duration: 1,
    ease: 'power1.inOut',
    lazy: false,
  });

  const toTopHover = gsap
    .timeline({ defaults: { ease: 'none' } })
    .to(head, { y: -20, duration: 0.2 })
    .set(head, { y: 100 })
    .to(head, { y: 0 })
    .pause(0);

  toTopBut.addEventListener('mouseenter', () => {
    toTopHover.play();
  });

  toTopBut.addEventListener('mouseleave', () => {
    toTopHover.pause(0);
  });

  ScrollTrigger.create({
    start: '+=200px',
    animation: toTopEnterance,
    toggleActions: 'play none none reverse',
  });
}
