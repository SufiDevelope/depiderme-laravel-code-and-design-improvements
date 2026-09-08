import { clamp, scheduleRaf, watchLayout } from "./utils.js";

export function initScrollExpandMedia({
  sceneSelector = "[data-scroll-expand-scene]",
  mediaSelector = "[data-scroll-expand-media]",
  progressProperty = "--scroll-expand-progress",
  progressDataKey = "scrollExpandProgress",
  progressTransforms = [],
  smooth = false,
  smoothFactor = 0.14,
  settleThreshold = 0.001,
} = {}) {
  const reducedMotion = window.matchMedia(
    "(prefers-reduced-motion: reduce)",
  ).matches;
  const states = [...document.querySelectorAll(sceneSelector)]
    .filter((scene) => !scene.hasAttribute("data-scroll-expand-ready"))
    .map((scene) => ({
      scene,
      media: scene.querySelector(mediaSelector),
      mobilePosition: scene.hasAttribute("data-scroll-expand-mobile-position"),
      mobilePositionMax: Number.parseInt(
        scene.dataset.scrollExpandMobileMax || "639",
        10,
      ),
      hasProgress: false,
      renderedProgress: 0,
      targetProgress: 0,
    }))
    .filter(({ media }) => media);

  if (states.length === 0) {
    return;
  }

  states.forEach(({ scene }) => {
    scene.setAttribute("data-scroll-expand-ready", "");
  });

  if (reducedMotion) {
    states.forEach(({ scene }) => {
      scene.dataset[progressDataKey] = "0.0000";
    });

    return;
  }

  let animationFrame = 0;
  const smoothEase = (value) => value * value * (3 - 2 * value);
  const applyProgress = (state, progress) => {
    state.media.style.setProperty(progressProperty, progress.toFixed(4));

    progressTransforms.forEach(({ property, transform }) => {
      if (!property || typeof transform !== "function") {
        return;
      }

      state.media.style.setProperty(property, transform(progress).toFixed(4));
    });
  };

  const animate = () => {
    let shouldContinue = false;

    states.forEach((state) => {
      const distance = state.targetProgress - state.renderedProgress;

      if (Math.abs(distance) <= settleThreshold) {
        state.renderedProgress = state.targetProgress;
      } else {
        state.renderedProgress += distance * smoothFactor;
        shouldContinue = true;
      }

      applyProgress(state, state.renderedProgress);
    });

    if (shouldContinue) {
      animationFrame = requestAnimationFrame(animate);
    } else {
      animationFrame = 0;
    }
  };

  const startAnimation = () => {
    if (!smooth || animationFrame) {
      return;
    }

    animationFrame = requestAnimationFrame(animate);
  };

  const update = () => {
    states.forEach((state) => {
      const { scene, mobilePosition, mobilePositionMax } = state;
      const rect = scene.getBoundingClientRect();
      const mobileMax = Number.isFinite(mobilePositionMax)
        ? mobilePositionMax
        : 639;
      const usesMobilePosition =
        mobilePosition &&
        window.matchMedia(`(max-width: ${mobileMax}px)`).matches;
      const progress = usesMobilePosition
        ? clamp(
            (window.innerHeight * 0.82 - rect.top) /
              Math.max(window.innerHeight * 0.46, 1),
            0,
            1,
          )
        : clamp(
            -rect.top / Math.max(rect.height - window.innerHeight, 1),
            0,
            1,
          );
      const easedProgress = smoothEase(progress);

      state.targetProgress = easedProgress;

      if (!state.hasProgress) {
        state.hasProgress = true;
        state.renderedProgress = easedProgress;
      }

      if (!smooth) {
        state.renderedProgress = easedProgress;
        applyProgress(state, easedProgress);
      }

      scene.dataset[progressDataKey] = progress.toFixed(4);
    });

    startAnimation();
  };

  const scheduleUpdate = scheduleRaf(update);

  update();
  window.addEventListener("scroll", scheduleUpdate, { passive: true });
  watchLayout(scheduleUpdate, states.map(({ scene }) => scene));
}
