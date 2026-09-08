import { clamp, scheduleRaf, watchLayout } from "./utils.js";
import { initScrollExpandMedia } from "./scroll-expand.js";

const CREAM_VIEWPORT_GAP_PX = 24;
const CREAM_SCROLL_SLOWDOWN = 1.8;
const WORD_ROTATION_MS = 5500;
const WORD_TRANSITION_MS = 680;

export function initLaserdermeCreamScroll() {
  const section = document.querySelector("[data-laserderme-cta]");
  const cream = section?.querySelector("[data-laserderme-cream]");
  const tube = cream?.querySelector("[data-laserderme-cream-tube]");
  const box = cream?.querySelector("[data-laserderme-cream-box]");

  if (!section || !cream || !tube || !box) {
    return;
  }

  if (window.matchMedia("(prefers-reduced-motion: reduce)").matches) {
    return;
  }

  let closeDistance = 0;
  let targetCloseProgress = 0;
  let currentCloseProgress = 0;
  let creamFrame = 0;

  const easeInOutCubic = (value) => {
    const clamped = clamp(value, 0, 1);

    return clamped < 0.5
      ? 4 * clamped * clamped * clamped
      : 1 - Math.pow(-2 * clamped + 2, 3) / 2;
  };

  const writeCreamState = () => {
    const easedProgress = easeInOutCubic(currentCloseProgress);
    const offset = closeDistance * (1 - easedProgress);
    const scale = 0.852 + easedProgress * 0.008;

    tube.style.setProperty("--laserderme-cream-close", `${offset}px`);
    tube.style.setProperty("--laserderme-cream-scale", scale.toFixed(4));
    section.dataset.laserdermeCreamClose = (1 - currentCloseProgress).toFixed(4);
  };

  const animateCream = () => {
    creamFrame = 0;

    currentCloseProgress +=
      (targetCloseProgress - currentCloseProgress) * 0.1;

    if (Math.abs(targetCloseProgress - currentCloseProgress) < 0.001) {
      currentCloseProgress = targetCloseProgress;
    }

    writeCreamState();

    if (Math.abs(targetCloseProgress - currentCloseProgress) > 0.001) {
      creamFrame = requestAnimationFrame(animateCream);
    }
  };

  const scheduleCreamAnimation = () => {
    if (!creamFrame) {
      creamFrame = requestAnimationFrame(animateCream);
    }
  };

  const update = ({ sync = false } = {}) => {
    const boxRect = box.getBoundingClientRect();
    const closeStartY = Math.max(
      CREAM_VIEWPORT_GAP_PX,
      window.innerHeight - cream.offsetHeight - CREAM_VIEWPORT_GAP_PX,
    );
    const closeEndY = boxRect.height * -0.25;
    targetCloseProgress = clamp(
      (closeStartY - boxRect.top) /
        (Math.max(closeStartY - closeEndY, 1) * CREAM_SCROLL_SLOWDOWN),
      0,
      1,
    );

    if (sync) {
      currentCloseProgress = targetCloseProgress;
      writeCreamState();
      return;
    }

    scheduleCreamAnimation();
  };

  const measure = () => {
    closeDistance = Math.max(cream.offsetHeight - box.offsetHeight + 2, 0);
    update({ sync: true });
  };

  const scheduleUpdate = scheduleRaf(update);

  watchLayout(measure, [section, cream, box]);
  measure();

  window.addEventListener("scroll", scheduleUpdate, { passive: true });
  window.addEventListener("resize", scheduleUpdate);
  window.addEventListener("pageshow", scheduleUpdate);
}

export function initLaserderme() {
  initLaserdermeWordRotator();
  initLaserdermeBannerExpand();
}

function initLaserdermeBannerExpand() {
  const easeOutCubic = (value) => 1 - Math.pow(1 - clamp(value, 0, 1), 3);

  initScrollExpandMedia({
    sceneSelector: "[data-laserderme-banner-scene]",
    mediaSelector: "[data-laserderme-banner-media]",
    progressProperty: "--laserderme-banner-progress",
    progressDataKey: "laserdermeBannerProgress",
    smooth: true,
    smoothFactor: 0.12,
    progressTransforms: [
      {
        property: "--laserderme-banner-width-progress",
        transform: (progress) => easeOutCubic(progress),
      },
      {
        property: "--laserderme-banner-height-progress",
        transform: (progress) => easeOutCubic(clamp((progress - 0.06) / 0.94, 0, 1)),
      },
      {
        property: "--laserderme-banner-radius-progress",
        transform: (progress) => easeOutCubic(clamp(progress * 1.18, 0, 1)),
      },
    ],
  });
}

function initLaserdermeWordRotator() {
  const root = document.querySelector("[data-laserderme-word-rotator]");
  const wordEl = root?.querySelector("[data-laserderme-word]");

  if (!root || !wordEl) {
    return;
  }

  const words = (root.dataset.words ?? "")
    .split(",")
    .map((word) => word.trim())
    .filter(Boolean);

  if (words.length < 2) {
    return;
  }

  const reduceMotion = window.matchMedia(
    "(prefers-reduced-motion: reduce)",
  ).matches;
  let index = words.indexOf(wordEl.textContent.trim());

  if (index === -1) {
    index = 0;
  }

  wordEl.textContent = words[index];
  root.dataset.activeWord = words[index];

  const showWord = (word) => {
    const outgoing = wordEl.cloneNode(true);
    outgoing.removeAttribute("data-laserderme-word");
    outgoing.setAttribute("aria-hidden", "true");
    outgoing.classList.add("laserderme-word--leaving");

    root.appendChild(outgoing);
    wordEl.classList.add("laserderme-word--entering");
    wordEl.textContent = word;
    root.dataset.activeWord = word;

    window.requestAnimationFrame(() => {
      outgoing.classList.add("is-active");
      wordEl.classList.add("is-active");
    });

    window.setTimeout(() => {
      outgoing.remove();
      wordEl.classList.remove("laserderme-word--entering", "is-active");
    }, WORD_TRANSITION_MS + 90);
  };

  window.setInterval(() => {
    index = (index + 1) % words.length;

    if (reduceMotion) {
      wordEl.textContent = words[index];
      root.dataset.activeWord = words[index];
      return;
    }

    showWord(words[index]);
  }, WORD_ROTATION_MS);
}
