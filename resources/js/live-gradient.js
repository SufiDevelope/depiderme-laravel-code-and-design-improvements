import { clamp } from "./utils.js";

const PURPLE_GRADIENT_PATTERN =
  /(?:136\s*,\s*119\s*,\s*194|91\s*,\s*43\s*,\s*130|218\s*,\s*169\s*,\s*250|225\s*,\s*199\s*,\s*249|138\s*,\s*114\s*,\s*175|180\s*,\s*111\s*,\s*235)/i;
const PURPLE_CLASS_PATTERN =
  /(?:8877c2|5b2b82|daa9fa|e1c7f9|8a72af|b46feb|136,119,194|91,43,130|218,169,250|225,199,249)/i;

function hasPurpleGradient(element, style) {
  const backgroundImage = style.backgroundImage || "";
  const className =
    typeof element.className === "string" ? element.className : "";
  const computedGradient =
    backgroundImage.includes("gradient") &&
    PURPLE_GRADIENT_PATTERN.test(backgroundImage);
  const classGradient =
    className.toLowerCase().includes("gradient") &&
    PURPLE_CLASS_PATTERN.test(className);

  return computedGradient || classGradient;
}

function getGradientMode(element, style) {
  if (element.hasAttribute("data-live-gradient-vector")) {
    return "vector";
  }

  if (element.hasAttribute("data-live-gradient-pseudo")) {
    return "pseudo";
  }

  if (hasPurpleGradient(element, style)) {
    return "background";
  }

  return null;
}

function getIntensityScale(element) {
  const intensity =
    element.getAttribute("data-live-gradient-intensity") ||
    element.closest("[data-live-gradient-intensity]")?.getAttribute(
      "data-live-gradient-intensity",
    ) ||
    "default";

  if (intensity === "cinematic") {
    return 1.55;
  }

  if (intensity === "strong") {
    return 1.28;
  }

  if (intensity === "soft") {
    return 0.82;
  }

  return 1;
}

function createState(element, index) {
  if (element.hasAttribute("data-live-gradient-disabled")) {
    return null;
  }

  const style = getComputedStyle(element);
  const mode = getGradientMode(element, style);

  if (!mode) {
    return null;
  }

  if (
    mode === "background" &&
    style.animationName !== "none" &&
    !element.hasAttribute("data-live-gradient")
  ) {
    return null;
  }

  if (element.closest("[data-scroll-laser-beam], .laser-beam")) {
    return null;
  }

  const isText =
    style.backgroundClip === "text" || style.webkitBackgroundClip === "text";
  const isCompact = element.matches(
    "a, button, [role='button'], [class*='rounded-full']",
  );
  const intensityScale = getIntensityScale(element);
  const minX = isText ? 12 : isCompact ? 18 : 20;
  const minY = isText ? 50 : isCompact ? 20 : 20;
  const baseSizeX = isText ? 260 : isCompact ? 220 : 135;
  const baseSizeY = isText ? 100 : isCompact ? 220 : 135;

  element.dataset.liveGradientReady = "";

  if (mode === "background") {
    element.classList.add("live-gradient");
    element.classList.toggle("live-gradient--text", isText);
    element.classList.toggle("live-gradient--compact", isCompact && !isText);
  } else {
    element.classList.add(`live-gradient--${mode}`);
  }

  return {
    element,
    mode,
    isText,
    isCompact,
    scrollOnly: element.hasAttribute("data-live-gradient-scroll-only"),
    currentX: 50,
    currentY: 50,
    targetX: 50,
    targetY: 50,
    pointerX: 0.5,
    pointerY: 0.5,
    isHovered: false,
    hoverBoost: 0,
    isVisible: false,
    minX,
    maxX: 100 - minX,
    minY,
    maxY: isText ? 50 : 100 - minY,
    intensityScale,
    autoAmplitudeX: (isText ? 24 : isCompact ? 18 : 16) * intensityScale,
    autoAmplitudeY: (isText ? 0 : isCompact ? 14 : 13) * intensityScale,
    autoSpeed: (0.52 + (index % 4) * 0.045) * Math.sqrt(intensityScale),
    phase: index * 1.37,
    baseSizeX,
    baseSizeY,
    currentSizeX: baseSizeX,
    currentSizeY: baseSizeY,
    sizePulse: (isText ? 24 : isCompact ? 22 : 18) * intensityScale,
  };
}

function findHoveredState(states, clientX, clientY) {
  let match = null;
  let matchArea = Number.POSITIVE_INFINITY;

  states.forEach((state) => {
    if (!state.isVisible) {
      return;
    }

    const rect = state.element.getBoundingClientRect();

    if (
      clientX < rect.left ||
      clientX > rect.right ||
      clientY < rect.top ||
      clientY > rect.bottom
    ) {
      return;
    }

    const area = Math.max(rect.width * rect.height, 1);

    if (area < matchArea) {
      match = { state, rect };
      matchArea = area;
    }
  });

  return match;
}

export function initLiveGradients() {
  const reducedMotion = window.matchMedia(
    "(prefers-reduced-motion: reduce)",
  ).matches;
  const candidates = [
    ...document.querySelectorAll(
      "body *:not(script):not(style), [data-live-gradient-vector], [data-live-gradient-pseudo]",
    ),
  ];
  const states = candidates.map(createState).filter(Boolean);
  const stateByElement = new Map(
    states.map((state) => [state.element, state]),
  );

  if (states.length === 0 || reducedMotion) {
    return;
  }

  let animationFrame = 0;

  const writeState = (state) => {
    state.element.style.setProperty(
      "--live-gradient-x",
      `${state.currentX.toFixed(2)}%`,
    );
    state.element.style.setProperty(
      "--live-gradient-y",
      `${state.currentY.toFixed(2)}%`,
    );

    if (state.mode !== "vector") {
      state.element.style.setProperty(
        "--live-gradient-size-x",
        `${state.currentSizeX.toFixed(2)}%`,
      );
      state.element.style.setProperty(
        "--live-gradient-size-y",
        `${state.currentSizeY.toFixed(2)}%`,
      );
    }

    if (state.mode === "vector") {
      state.element.style.setProperty(
        "--live-gradient-shift-x",
        `${((state.currentX - 50) * 0.65).toFixed(2)}px`,
      );
      state.element.style.setProperty(
        "--live-gradient-shift-y",
        `${((state.currentY - 50) * 0.45).toFixed(2)}px`,
      );
    }
  };

  const animate = (timestamp) => {
    animationFrame = 0;
    let hasVisibleState = false;
    const time = timestamp / 1000;

    states.forEach((state) => {
      if (!state.isVisible) {
        return;
      }

      hasVisibleState = true;
      state.hoverBoost +=
        (((state.isHovered && !state.scrollOnly) ? 1 : 0) - state.hoverBoost) *
        0.1;

      // Two overlapping waves keep the drift organic instead of looking like
      // a repeating left-to-right CSS animation.
      const hoverSpeedMultiplier = 1 + state.hoverBoost * (state.isText ? 1.35 : 1.9);
      const hoverMotionMultiplier =
        1 +
        state.hoverBoost *
          (state.isText ? 0.55 : 0.85) *
          Math.sqrt(state.intensityScale);
      const primaryWave =
        time * state.autoSpeed * hoverSpeedMultiplier + state.phase;
      const secondaryWave =
        time * state.autoSpeed * hoverSpeedMultiplier * 0.57 +
        state.phase * 1.71;
      const autoX = state.scrollOnly
        ? 0
        : (Math.sin(primaryWave) * state.autoAmplitudeX +
            Math.sin(secondaryWave) * state.autoAmplitudeX * 0.38) *
          hoverMotionMultiplier;
      const autoY = state.scrollOnly
        ? 0
        : (Math.cos(primaryWave * 0.83) * state.autoAmplitudeY +
            Math.sin(secondaryWave * 1.19) * state.autoAmplitudeY * 0.34) *
          hoverMotionMultiplier;
      const desiredX = clamp(
        state.targetX + autoX,
        state.minX,
        state.maxX,
      );
      const desiredY = clamp(
        state.targetY + autoY,
        state.minY,
        state.maxY,
      );
      const pulse = (Math.sin(primaryWave * 0.71) + 1) * 0.5;
      const desiredSizeX = state.scrollOnly
        ? state.baseSizeX
        : state.baseSizeX + pulse * state.sizePulse * hoverMotionMultiplier;
      const desiredSizeY = state.scrollOnly
        ? state.baseSizeY
        : state.baseSizeY +
          (state.isText ? 0 : pulse * state.sizePulse * hoverMotionMultiplier);

      const positionEase = 0.08 + state.hoverBoost * 0.09;
      const sizeEase = 0.055 + state.hoverBoost * 0.065;

      state.currentX += (desiredX - state.currentX) * positionEase;
      state.currentY += (desiredY - state.currentY) * positionEase;
      state.currentSizeX += (desiredSizeX - state.currentSizeX) * sizeEase;
      state.currentSizeY += (desiredSizeY - state.currentSizeY) * sizeEase;
      writeState(state);
    });

    if (hasVisibleState) {
      animationFrame = requestAnimationFrame(animate);
    }
  };

  const scheduleAnimation = () => {
    if (!animationFrame) {
      animationFrame = requestAnimationFrame(animate);
    }
  };

  const updateTargets = () => {
    const viewportHeight = window.visualViewport?.height ?? window.innerHeight;

    states.forEach((state) => {
      if (!state.isVisible) {
        return;
      }

      const rect = state.element.getBoundingClientRect();
      const progress = clamp(
        (viewportHeight - rect.top) / Math.max(viewportHeight + rect.height, 1),
        0,
        1,
      );
      const scrollOffset = progress - 0.5;
      const scrollXStrength = state.isText ? 30 : state.isCompact ? 24 : 20;
      const scrollYStrength = state.isText ? 0 : state.isCompact ? 24 : 30;
      const scrollX =
        state.mode === "vector" ? 50 : 50 + scrollOffset * scrollXStrength;
      const scrollY =
        state.mode === "vector" ? 50 : 50 - scrollOffset * scrollYStrength;
      const pointerStrength = state.isHovered && !state.scrollOnly
        ? state.isText
          ? 56 * state.intensityScale
          : state.isCompact
            ? 48 * state.intensityScale
            : 42 * state.intensityScale
        : 0;

      state.targetX = clamp(
        scrollX + (state.pointerX - 0.5) * pointerStrength,
        state.minX,
        state.maxX,
      );
      state.targetY = clamp(
        scrollY + (state.pointerY - 0.5) * pointerStrength,
        state.minY,
        state.maxY,
      );
    });

    scheduleAnimation();
  };

  const observer = new IntersectionObserver(
    (entries) => {
      entries.forEach((entry) => {
        const state = stateByElement.get(entry.target);

        if (state) {
          state.isVisible = entry.isIntersecting;
        }
      });

      updateTargets();
    },
    { rootMargin: "15% 0px" },
  );

  states.forEach((state) => {
    observer.observe(state.element);
    writeState(state);
  });

  window.addEventListener("scroll", updateTargets, { passive: true });
  window.addEventListener("resize", updateTargets, { passive: true });

  document.addEventListener(
    "pointermove",
    (event) => {
      if (event.pointerType && event.pointerType !== "mouse") {
        return;
      }

      const hoveredElement = document.elementFromPoint(
        event.clientX,
        event.clientY,
      );
      const hovered = hoveredElement?.closest(".booking-section")
        ? null
        : findHoveredState(states, event.clientX, event.clientY);

      states.forEach((state) => {
        state.isHovered = state === hovered?.state;

        if (!state.isHovered) {
          state.pointerX = 0.5;
          state.pointerY = 0.5;
        }
      });

      if (hovered) {
        hovered.state.pointerX = clamp(
          (event.clientX - hovered.rect.left) / Math.max(hovered.rect.width, 1),
          0,
          1,
        );
        hovered.state.pointerY = clamp(
          (event.clientY - hovered.rect.top) / Math.max(hovered.rect.height, 1),
          0,
          1,
        );
      }

      updateTargets();
    },
    { passive: true },
  );

  document.addEventListener("pointerleave", () => {
    states.forEach((state) => {
      state.isHovered = false;
      state.pointerX = 0.5;
      state.pointerY = 0.5;
    });
    updateTargets();
  });

  updateTargets();
}
