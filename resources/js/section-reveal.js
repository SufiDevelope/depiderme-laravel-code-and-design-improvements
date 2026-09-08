/**
 * Global scroll reveal — each <section> reveals its content when it enters view.
 */
const VISIBLE_CLASS = "is-visible";
const SECTION_CLASS = "scroll-reveal-section";

const SKIP_CONTAINER =
  "nav, .packs-marquee, [data-laser-beam-loop], [data-scroll-laser-beam], .laser-beam, [data-reveal-skip]";

const TEXT_REVEAL_SELECTOR = [
  "h1",
  "h2",
  "h3",
  "h4",
  "h5",
  "h6",
  "p",
  "li",
  "summary",
  "blockquote",
  "figcaption",
  "dt",
  "dd",
  "label",
  "legend",
  "small",
  "span",
  "button",
  ".scroll-reveal-text",
  "a.rounded-full",
  ".booking-form__label",
].join(", ");

const TEXT_LEAF_SELECTOR = "div, span, a, button, label, dt, dd, small";
const VISUAL_REVEAL_SELECTOR = [
  ".booking-map",
  ".booking-section__form",
].join(", ");

function prefersReducedMotion() {
  return window.matchMedia("(prefers-reduced-motion: reduce)").matches;
}

function shouldSkipElement(element) {
  return !element || element.closest(SKIP_CONTAINER);
}

function isContainedBy(target, container) {
  return container !== target && container.contains(target);
}

function isTextLeaf(element) {
  if (!element.matches(TEXT_LEAF_SELECTOR) || !element.textContent?.trim()) {
    return false;
  }

  return [...element.children].every((child) => {
    const tagName = child.tagName.toLowerCase();

    return ["br", "svg", "img"].includes(tagName);
  });
}

function collectSectionTargets(section) {
  const targets = [];
  const seen = new Set();
  const stagger = section.hasAttribute("data-reveal-stagger");
  const delayScale = Number.parseFloat(section.dataset.revealDelayScale ?? "1");
  const scaledDelay = (delay) =>
    Math.round(delay * (Number.isFinite(delayScale) ? delayScale : 1));

  const add = (element, direction = "up", delay = 0) => {
    const hasRevealedRelative = targets.some(({ element: target }) =>
      isContainedBy(element, target) || isContainedBy(target, element),
    );

    if (
      !element ||
      seen.has(element) ||
      hasRevealedRelative ||
      shouldSkipElement(element)
    ) {
      return;
    }

    seen.add(element);
    targets.push({ element, direction, delay: scaledDelay(delay) });
  };

  const isTaken = (element) => [...seen].some((item) => isContainedBy(element, item));
  const candidates = [
    ...section.querySelectorAll(TEXT_REVEAL_SELECTOR),
    ...section.querySelectorAll(TEXT_LEAF_SELECTOR),
    ...section.querySelectorAll(VISUAL_REVEAL_SELECTOR),
  ]
    .filter((element) => {
      const isVisualReveal = element.matches(VISUAL_REVEAL_SELECTOR);

      if (
        shouldSkipElement(element) ||
        (!isVisualReveal && !element.textContent?.trim()) ||
        (!isVisualReveal && !element.matches(TEXT_REVEAL_SELECTOR) && !isTextLeaf(element))
      ) {
        return false;
      }

      return !isTaken(element);
    })
    .sort((a, b) => {
      if (a === b) {
        return 0;
      }

      return a.compareDocumentPosition(b) & Node.DOCUMENT_POSITION_FOLLOWING
        ? -1
        : 1;
    });

  candidates.forEach((element, index) => {
    const direction = stagger ? (index % 2 === 0 ? "right" : "left") : "up";
    add(element, direction, Math.min(index * 70, 560));
  });

  return targets;
}

function shouldSkipSection(section) {
  if (section.closest(SKIP_CONTAINER)) {
    return true;
  }

  return false;
}

function revealOptions(section) {
  const threshold = Number.parseFloat(section.dataset.revealThreshold ?? "0.12");

  return {
    threshold: Number.isFinite(threshold) ? threshold : 0.12,
    rootMargin: section.dataset.revealRootMargin || "0px 0px -12% 0px",
  };
}

export function initSectionReveal() {
  const root = document.querySelector(".site-shell");

  if (!root) {
    return;
  }

  const sections = [
    ...root.querySelectorAll("section, .packs-section, .footer-shell, .scroll-reveal-root"),
  ].filter((section) => !shouldSkipSection(section));

  const activeSections = sections.flatMap((section) => {
    const targets = collectSectionTargets(section);

    if (targets.length === 0) {
      return [];
    }

    section.classList.add(SECTION_CLASS);
    section.classList.add("scroll-reveal-section--items");

    targets.forEach(({ element, direction, delay }) => {
      element.classList.add("scroll-reveal", `scroll-reveal--${direction}`);

      if (delay > 0) {
        element.style.setProperty("--scroll-reveal-delay", `${delay}ms`);
      }
    });

    return [{ section, targets }];
  });

  if (activeSections.length === 0) {
    return;
  }

  if (prefersReducedMotion()) {
    activeSections.forEach(({ section, targets }) => {
      section.classList.add(VISIBLE_CLASS);
      targets.forEach(({ element }) => element.classList.add(VISIBLE_CLASS));
    });

    return;
  }

  const observers = new Map();
  const getObserver = (section) => {
    const options = revealOptions(section);
    const key = `${options.threshold}|${options.rootMargin}`;

    if (!observers.has(key)) {
      observers.set(
        key,
        new IntersectionObserver((entries, observer) => {
      entries.forEach((entry) => {
        if (entry.isIntersecting) {
          entry.target.classList.add(VISIBLE_CLASS);
          observer.unobserve(entry.target);
        }
      });
        }, options),
      );
    }

    return observers.get(key);
  };

  activeSections.forEach(({ section, targets }) => {
    const observer = getObserver(section);

    targets.forEach(({ element }) => observer.observe(element));
  });
}
