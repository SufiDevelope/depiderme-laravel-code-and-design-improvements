export const clamp = (value, min, max) => Math.min(Math.max(value, min), max);

export const isMobile = () => window.matchMedia("(max-width: 991px)").matches;

export const isDesktopHover = () =>
  window.matchMedia("(min-width: 992px) and (hover: hover)").matches;

export function scheduleRaf(callback) {
  let pending = false;

  return () => {
    if (pending) {
      return;
    }

    pending = true;
    requestAnimationFrame(() => {
      pending = false;
      callback();
    });
  };
}

export function scrollRiseProgress(scrollY, scrollStart, scrollEnd, riseEase = 0.55) {
  const riseStart = Math.max(0, scrollStart);
  const riseRange = Math.max(scrollEnd - riseStart, 1);
  const progress =
    scrollY < riseStart
      ? 0
      : clamp((scrollY - riseStart) / riseRange, 0, 1);

  const ease = Math.max(parseFloat(riseEase) || 0.55, 0.1);

  return {
    progress,
    riseProgress: clamp(progress / ease, 0, 1),
  };
}

export function bindHorizontalSwipe(element, onLeft, onRight, threshold = 48) {
  let startX = 0;
  let startY = 0;
  let tracking = false;

  element.addEventListener(
    "touchstart",
    (event) => {
      if (event.touches.length !== 1) {
        tracking = false;
        return;
      }

      tracking = true;
      startX = event.touches[0].clientX;
      startY = event.touches[0].clientY;
    },
    { passive: true },
  );

  element.addEventListener(
    "touchend",
    (event) => {
      if (!tracking || event.changedTouches.length === 0) {
        return;
      }

      tracking = false;
      const deltaX = event.changedTouches[0].clientX - startX;
      const deltaY = event.changedTouches[0].clientY - startY;

      if (
        Math.abs(deltaX) < threshold ||
        Math.abs(deltaX) < Math.abs(deltaY)
      ) {
        return;
      }

      (deltaX < 0 ? onLeft : onRight)();
    },
    { passive: true },
  );
}

export function watchLayout(callback, roots = []) {
  const schedule = scheduleRaf(callback);

  window.addEventListener("resize", schedule);
  window.addEventListener("pageshow", schedule);

  if (document.readyState === "complete") {
    schedule();
  } else {
    window.addEventListener("load", schedule, { once: true });
  }

  document.querySelectorAll("img").forEach((img) => {
    if (!img.complete) {
      img.addEventListener("load", schedule, { once: true });
      img.addEventListener("error", schedule, { once: true });
    }
  });

  if (typeof ResizeObserver === "undefined") {
    return schedule;
  }

  const seen = new Set();
  const observer = new ResizeObserver(schedule);

  roots.forEach((root) => {
    if (root && !seen.has(root)) {
      seen.add(root);
      observer.observe(root);
    }
  });

  return schedule;
}
