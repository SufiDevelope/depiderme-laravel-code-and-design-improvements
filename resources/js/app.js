import {
  initLaserderme,
  initLaserdermeCreamScroll,
} from "./laserderme.js";
import { initLaserBeamLoop, initScrollLaserBeams } from "./laser-beam.js";
import { initLiveGradients } from "./live-gradient.js";
import {
  initHomeSectionStack,
  initLeaderSection,
  initScrollGradients,
  initScrollEffects,
  initSectionRise,
} from "./scroll.js";
import { initSectionReveal } from "./section-reveal.js";
import { initScrollExpandMedia } from "./scroll-expand.js";
import {
  initCarousels,
  initFaqAccordion,
  initMobileMenu,
  initPricingHeroMotion,
  initPricingToggle,
} from "./widgets.js";

const clamp01 = (value) => Math.min(Math.max(value, 0), 1);
const easeOutCubic = (value) => 1 - Math.pow(1 - clamp01(value), 3);

function loadPageModules() {
  if (document.querySelector("[data-clinics-accordion]")) {
    import("./clinics.js").then(({ initClinics }) => initClinics());
  }

  if (
    document.querySelector("[data-laserderme-cta]") ||
    document.querySelector("[data-laserderme-word-rotator]")
  ) {
    initLaserderme();
  }
}

document.addEventListener("DOMContentLoaded", () => {
  initLiveGradients();
  initHomeSectionStack();
  initSectionRise();
  initLeaderSection();
  initScrollGradients();
  initScrollLaserBeams();
  initScrollExpandMedia({
    smooth: true,
    smoothFactor: 0.12,
    progressTransforms: [
      {
        property: "--end-section-width-progress",
        transform: (progress) => easeOutCubic(progress),
      },
      {
        property: "--end-section-height-progress",
        transform: (progress) => easeOutCubic((progress - 0.06) / 0.94),
      },
      {
        property: "--end-section-radius-progress",
        transform: (progress) => easeOutCubic(progress * 1.18),
      },
    ],
  });

  initSectionReveal();

  if (document.querySelector("[data-laser-beam-loop]")) {
    initLaserBeamLoop();
  }

  initLaserdermeCreamScroll();

  initScrollEffects();

  initMobileMenu();
  initCarousels();
  initFaqAccordion();
  initPricingHeroMotion();
  initPricingToggle();
  loadPageModules();
});
