import {
  clamp,
  isMobile,
  scrollRiseProgress,
  watchLayout,
} from "./utils.js";

const scrollTasks = [];
let scrollListenerReady = false;

function ensureScrollListener() {
  if (scrollListenerReady) {
    return;
  }

  scrollListenerReady = true;

  let ticking = false;

  const run = () => {
    ticking = false;
    scrollTasks.forEach((task) => task());
  };

  const handleScroll = () => {
    if (!ticking) {
      ticking = true;
      requestAnimationFrame(run);
    }
  };

  window.addEventListener("scroll", handleScroll, { passive: true });
  window.addEventListener("resize", run);
  run();
}

export function registerScrollTask(task) {
  scrollTasks.push(task);
  task();
  ensureScrollListener();
}

export function initScrollEffects() {
  const header = document.querySelector("[data-navbar-scroll]");

  if (header) {
    registerScrollTask(() => {
      if (window.scrollY > 5) {
        header.setAttribute("data-scrolled", "true");
      } else {
        header.removeAttribute("data-scrolled");
      }
    });
  }

  ensureScrollListener();
}

export function initHomeSectionStack() {
  const stack = document.querySelector("[data-home-section-stack]");
  const panels = stack
    ? [...stack.querySelectorAll("[data-home-stack-panel]")]
    : [];

  if (panels.length === 0) {
    return;
  }

  const measure = () => {
    const viewportHeight = window.visualViewport?.height ?? window.innerHeight;
    const headerHeight = document.querySelector("header")?.offsetHeight ?? 0;
    const usesDesktopCardStack = window.matchMedia("(min-width: 992px)").matches;

    panels.forEach((panel, index) => {
      const shouldPinAtTop = panel.hasAttribute("data-home-stack-pin-top");
      const isExperienceCard = panel.hasAttribute("data-home-stack-card");
      let stickyTop = Math.min(0, viewportHeight - panel.offsetHeight);

      if (shouldPinAtTop) {
        stickyTop = 0;
      } else if (isExperienceCard && usesDesktopCardStack) {
        const preferredTop = headerHeight + 24;
        const fullyVisibleTop = viewportHeight - panel.offsetHeight - 24;
        stickyTop = Math.max(headerHeight, Math.min(preferredTop, fullyVisibleTop));
      }

      panel.style.setProperty(
        "--home-stack-stick-top",
        `${Math.round(stickyTop)}px`,
      );
      panel.style.setProperty("--home-stack-layer", `${(index + 1) * 10}`);
    });
  };

  measure();
  watchLayout(measure, [stack, ...panels]);
}

// A <video>'s <source media="..."> is only evaluated once, when the browser
// first picks a source - unlike <picture>, it never re-checks on resize.
// Without this, resizing the window across the mobile/desktop breakpoint
// keeps playing whichever video loaded first (wrong crop/framing) until a
// hard refresh. This listens for the breakpoint to actually cross and
// swaps the source live.
export function initHeroVideoSource() {
  const video = document.querySelector(".hero-bg__video");

  if (!video) {
    return;
  }

  const sources = [...video.querySelectorAll("source")];
  const mobileSource = sources.find((source) =>
    source.media.includes("max-width"),
  );
  const desktopSource = sources.find((source) =>
    source.media.includes("min-width"),
  );

  if (!mobileSource || !desktopSource) {
    return;
  }

  const mobileQuery = window.matchMedia("(max-width: 991px)");
  let activeSrc = mobileQuery.matches ? mobileSource.src : desktopSource.src;

  mobileQuery.addEventListener("change", (event) => {
    const nextSrc = event.matches ? mobileSource.src : desktopSource.src;

    if (nextSrc === activeSrc) {
      return;
    }

    activeSrc = nextSrc;

    const wasPlaying = !video.paused;
    video.src = nextSrc;
    video.load();

    if (wasPlaying) {
      video.play().catch(() => {});
    }
  });
}

export function initScrollGradients() {
  const sections = [...document.querySelectorAll("[data-scroll-gradient]")];
  const detailSections = [
    ...document.querySelectorAll("[data-clinics-detail-gradient]"),
  ];

  if (
    (sections.length === 0 && detailSections.length === 0) ||
    window.matchMedia("(prefers-reduced-motion: reduce)").matches
  ) {
    return;
  }

  const states = sections
    .map((section) => ({
      section,
      field: section.querySelector(".clinics-section__glow-field"),
    }))
    .filter(({ field }) => field);

  if (states.length === 0 && detailSections.length === 0) {
    return;
  }

  const update = () => {
    const viewportHeight = window.innerHeight;
    const mobile = isMobile();
    const travelX = mobile
      ? Math.min(260, window.innerWidth * 0.68)
      : Math.min(840, window.innerWidth * 0.64);
    const startX = mobile ? -72 : -160;
    const travelY = mobile ? 90 : 180;

    states.forEach(({ section, field }) => {
      const rect = section.getBoundingClientRect();
      const progress = clamp(
        (viewportHeight - rect.top) / (viewportHeight + rect.height),
        0,
        1,
      );
      const easedProgress = progress * progress * (3 - 2 * progress);
      const scale = 0.94 + Math.sin(easedProgress * Math.PI) * 0.12;

      field.style.setProperty(
        "--clinics-glow-x",
        `${startX + travelX * easedProgress}px`,
      );
      field.style.setProperty(
        "--clinics-glow-y",
        `${travelY * easedProgress}px`,
      );
      field.style.setProperty("--clinics-glow-scale", scale.toFixed(3));
    });

    detailSections.forEach((section) => {
      const rect = section.getBoundingClientRect();
      const progress = clamp(
        (viewportHeight - rect.top) / (viewportHeight + rect.height),
        0,
        1,
      );
      const easedProgress = progress * progress * (3 - 2 * progress);

      section.style.setProperty(
        "--clinics-detail-gradient-x",
        `${(-10 + easedProgress * 20).toFixed(2)}px`,
      );
      section.style.setProperty(
        "--clinics-detail-gradient-y",
        `${(easedProgress * 16).toFixed(2)}px`,
      );
    });
  };

  registerScrollTask(update);
}

export function initSectionRise() {
  const sections = [...document.querySelectorAll("[data-section-rise]")];

  if (sections.length === 0) {
    return;
  }

  const states = sections.map((section, index) => {
    section.style.zIndex = String(30 + index * 10);

    return { section, metrics: { scrollStart: 0, scrollEnd: 1 } };
  });

  let metricsReady = false;

  const measureAll = () => {
    const viewport = window.innerHeight;
    const mobile = isMobile();
    const stickyHeaderHeight = mobile
      ? document.querySelector("[data-navbar-scroll]")?.getBoundingClientRect()
          .height ?? 0
      : 0;

    states.forEach(({ section }) => {
      section.style.marginTop = "0px";
      section.style.transform = "none";
    });

    states.forEach(({ section, metrics }) => {
      if (mobile && section.hasAttribute("data-section-rise-static-mobile")) {
        metrics.scrollStart = Number.POSITIVE_INFINITY;
        metrics.scrollEnd = Number.POSITIVE_INFINITY;
        return;
      }

      const sectionTop = section.getBoundingClientRect().top + window.scrollY;
      const mobileAnchorSelector = section.dataset.sectionRiseMobileAnchor;
      const mobileAnchor =
        mobile && mobileAnchorSelector
          ? document.querySelector(mobileAnchorSelector)
          : null;

      if (mobileAnchor) {
        const anchorTop =
          mobileAnchor.getBoundingClientRect().top + window.scrollY;
        const mobileRange = Math.max(
          Number.parseFloat(section.dataset.sectionRiseMobileRange) || 0.85,
          0.1,
        );

        // Start the cover only after the anchored heading reaches the bottom
        // of the sticky navigation. Until then the next section stays in flow.
        metrics.scrollStart = Math.max(
          0,
          anchorTop - stickyHeaderHeight,
        );
        metrics.scrollEnd = metrics.scrollStart + viewport * mobileRange;
      } else {
        metrics.scrollStart = sectionTop - viewport;
        metrics.scrollEnd = metrics.scrollStart + viewport * 0.85;
      }
    });
  };

  const updateAll = () => {
    if (!metricsReady) {
      states.forEach(({ section }) => {
        section.style.marginTop = "0px";
        section.style.transform = "none";
      });

      return;
    }

    const overlap = Math.min(320, window.innerHeight * 0.38);

    states.forEach(({ section, metrics }, index) => {
      if (
        isMobile() &&
        section.hasAttribute("data-section-rise-static-mobile")
      ) {
        section.style.removeProperty("margin-top");
        section.style.transform = "none";
        return;
      }

      const { riseProgress } = scrollRiseProgress(
        window.scrollY,
        metrics.scrollStart,
        metrics.scrollEnd,
      );
      const maxRise = section.dataset.sectionRiseMax
        ? Number.parseInt(section.dataset.sectionRiseMax, 10)
        : overlap;
      const overlapAmount = Math.min(overlap, maxRise);

      if (riseProgress <= 0) {
        section.style.marginTop = "0px";
        section.style.transform = "none";
      } else {
        section.style.marginTop = `${-overlapAmount}px`;
        const translateY = (1 - riseProgress) * overlapAmount;
        section.style.transform =
          translateY > 0.5
            ? `translate3d(0, ${translateY}px, 0)`
            : "none";
      }

      const customZ = section.dataset.sectionRiseZ;
      section.style.zIndex = customZ
        ? String(Number.parseInt(customZ, 10))
        : String(30 + index * 10);
    });
  };

  const remeasure = () => {
    measureAll();
    metricsReady = true;
    updateAll();
  };

  registerScrollTask(updateAll);

  const layoutRoots = [];

  states.forEach(({ section }) => {
    layoutRoots.push(section, section.previousElementSibling);
  });

  document
    .querySelectorAll(".packs-section, .end-section")
    .forEach((element) => layoutRoots.push(element));

  watchLayout(remeasure, layoutRoots);
}

function wrapLeaderLetters(root) {
  const textNodes = [];
  const walker = document.createTreeWalker(root, NodeFilter.SHOW_TEXT);

  while (walker.nextNode()) {
    const text = walker.currentNode.textContent ?? "";

    if (text.length > 0) {
      textNodes.push(walker.currentNode);
    }
  }

  textNodes.forEach((node) => {
    const fragment = document.createDocumentFragment();

    (node.textContent ?? "").split(/(\s+)/).forEach((token) => {
      if (token.length === 0) {
        return;
      }

      if (/^\s+$/.test(token)) {
        fragment.appendChild(document.createTextNode(token));
        return;
      }

      const word = document.createElement("span");
      word.className = "leader-word";

      [...token].forEach((char) => {
        const letter = document.createElement("span");
        letter.className = "leader-letter";
        letter.dataset.leaderLetter = "";

        const charSpan = document.createElement("span");
        charSpan.className = "leader-letter__char";
        charSpan.textContent = char;

        const fillSpan = document.createElement("span");
        fillSpan.className = "leader-letter__fill";
        fillSpan.textContent = char;
        fillSpan.setAttribute("aria-hidden", "true");

        letter.appendChild(charSpan);
        letter.appendChild(fillSpan);
        word.appendChild(letter);
      });

      fragment.appendChild(word);
    });

    node.replaceWith(fragment);
  });
}

function getDocumentFlowTop(element) {
  const previousPosition = element.style.position;
  const previousTop = element.style.top;

  element.style.position = "relative";
  element.style.top = "auto";

  const top = element.getBoundingClientRect().top + window.scrollY;

  if (previousPosition) {
    element.style.position = previousPosition;
  } else {
    element.style.removeProperty("position");
  }

  if (previousTop) {
    element.style.top = previousTop;
  } else {
    element.style.removeProperty("top");
  }

  return top;
}

export function initLeaderSection() {
  const section = document.querySelector("[data-leader-section]");
  const headline = section?.querySelector("[data-leader-headline]");

  if (!section || !headline) {
    return;
  }

  wrapLeaderLetters(headline);

  const letters = [...headline.querySelectorAll("[data-leader-letter]")];

  if (letters.length === 0) {
    return;
  }

  let scrollStart = 0;
  let scrollEnd = 1;
  let targetTextProgress = 0;
  let currentTextProgress = 0;
  let targetRiseProgress = 0;
  let currentRiseProgress = 0;
  let animationFrame = 0;
  const isStackedPanel = section.hasAttribute("data-home-stack-panel");

  const easeProgress = (value) => {
    const clamped = clamp(value, 0, 1);

    return clamped * clamped * (3 - 2 * clamped);
  };

  const paintLetters = () => {
    const total = Math.max(letters.length - 1, 1);
    const sweepSoftness = isMobile() ? 7.5 : 10;

    letters.forEach((letter, index) => {
      const letterStart = index / total;
      const rawProgress = (currentTextProgress - letterStart) * sweepSoftness;
      const letterProgress = easeProgress(rawProgress);

      letter.style.setProperty(
        "--leader-letter-progress",
        letterProgress.toFixed(4),
      );
      letter.classList.toggle("is-filled", letterProgress > 0.995);
    });
  };

  const paintLeaderMotion = () => {
    if (isStackedPanel) {
      section.style.removeProperty("transform");
      return;
    }

    const overlap = isMobile()
      ? 0
      : Math.min(84, window.innerHeight * 0.095);

    section.style.transform = `translate3d(0, ${-currentRiseProgress * overlap}px, 0)`;
  };

  const animateProgress = () => {
    animationFrame = 0;

    currentTextProgress += (targetTextProgress - currentTextProgress) * 0.12;
    currentRiseProgress += (targetRiseProgress - currentRiseProgress) * 0.14;

    if (Math.abs(targetTextProgress - currentTextProgress) < 0.001) {
      currentTextProgress = targetTextProgress;
    }

    if (Math.abs(targetRiseProgress - currentRiseProgress) < 0.001) {
      currentRiseProgress = targetRiseProgress;
    }

    paintLetters();
    paintLeaderMotion();

    if (
      Math.abs(targetTextProgress - currentTextProgress) > 0.001 ||
      Math.abs(targetRiseProgress - currentRiseProgress) > 0.001
    ) {
      animationFrame = requestAnimationFrame(animateProgress);
    }
  };

  const scheduleProgressPaint = () => {
    if (!animationFrame) {
      animationFrame = requestAnimationFrame(animateProgress);
    }
  };

  const measureLetters = () => {
    const headlineRect = headline.getBoundingClientRect();
    headline.style.setProperty("--headline-width", `${headlineRect.width}px`);

    letters.forEach((letter) => {
      const letterRect = letter.getBoundingClientRect();
      letter.style.setProperty(
        "--letter-x",
        `${letterRect.left - headlineRect.left}px`,
      );
    });
  };

  const measure = () => {
    if (!isStackedPanel) {
      section.style.transform = "none";
    }

    const sectionTop = isStackedPanel
      ? getDocumentFlowTop(section)
      : section.getBoundingClientRect().top + window.scrollY;
    const viewport = window.innerHeight;
    scrollStart = sectionTop - viewport;
    // Let the colour sweep continue while the panel is pinned. The previous
    // half-viewport reveal completed before the headline could be read.
    scrollEnd = scrollStart + viewport * (isMobile() ? 1.45 : 1.75);

    if (!isStackedPanel) {
      section.style.removeProperty("transform");
    }

    measureLetters();
  };

  const update = () => {
    // Keep the rounded panel overlap without allowing its heading to travel
    // underneath the 96px sticky navigation.
    const overlap = isMobile()
      ? 0
      : Math.min(84, window.innerHeight * 0.095);
    const { progress, riseProgress } = scrollRiseProgress(
      window.scrollY,
      scrollStart,
      scrollEnd,
    );
    targetTextProgress = clamp((progress - 0.08) / 0.86, 0, 1);
    targetRiseProgress = riseProgress;

    if (isStackedPanel) {
      section.style.removeProperty("transform");
    } else {
      paintLeaderMotion();
    }

    scheduleProgressPaint();

    if (riseProgress > 0 || targetTextProgress > 0) {
      measureLetters();
    }
  };

  const remeasure = () => {
    measure();
    update();
  };

  remeasure();
  registerScrollTask(update);
  watchLayout(remeasure, [section]);
}
