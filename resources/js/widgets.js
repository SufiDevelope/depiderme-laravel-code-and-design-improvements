import { registerScrollTask } from "./scroll.js";
import { clamp } from "./utils.js";

export function initMobileMenu() {
  const menu = document.getElementById("mobile-menu");
  const openBtn = document.getElementById("menu-open");
  const closeBtn = document.getElementById("menu-close");

  if (!menu || !openBtn || !closeBtn) {
    return;
  }

  const openMenu = () => {
    menu.classList.remove("hidden");
    menu.setAttribute("aria-hidden", "false");
    openBtn.setAttribute("aria-expanded", "true");
    document.body.classList.add("overflow-hidden");
  };

  const closeMenu = () => {
    menu.classList.add("hidden");
    menu.setAttribute("aria-hidden", "true");
    openBtn.setAttribute("aria-expanded", "false");
    document.body.classList.remove("overflow-hidden");
  };

  openBtn.addEventListener("click", openMenu);
  closeBtn.addEventListener("click", closeMenu);

  menu.querySelectorAll("a[href]").forEach((link) => {
    link.addEventListener("click", closeMenu);
  });

  document.addEventListener("keydown", (event) => {
    if (event.key === "Escape" && !menu.classList.contains("hidden")) {
      closeMenu();
    }
  });
}

export function initCarousels() {
  document.querySelectorAll("[data-carousel]").forEach((carousel) => {
    if (
      carousel.dataset.carouselMobileOnly === "true" &&
      window.matchMedia("(min-width: 992px)").matches
    ) {
      return;
    }

    const gapOverride = carousel.dataset.scrollGap
      ? Number.parseFloat(carousel.dataset.scrollGap)
      : null;
    const tapMode = carousel.dataset.carouselTap;
    const isLooping = carousel.dataset.carouselLoop === "true";
    const isMarquee = carousel.dataset.carouselAuto === "marquee";
    let pointerDown = false;
    let dragged = false;
    let startX = 0;
    let lastX = 0;
    let startScrollLeft = 0;
    let startIndex = 0;
    let progressFrame = 0;
    let autoFrame = 0;
    let autoLastTime = 0;
    let autoPausedUntil = 0;
    let loopOriginalCount = 0;
    let normalizingLoop = false;
    let loopNormalizeTimer = 0;

    const cards = () =>
      [...carousel.querySelectorAll("article")].filter(
        (item) => item.offsetParent !== null,
      );

    const originalCards = () =>
      cards().filter((item) => item.dataset.carouselClone !== "true");

    const setupLoop = () => {
      const originals = originalCards();
      loopOriginalCount = originals.length;

      if (!isLooping || originals.length < 2 || carousel.dataset.loopReady === "true") {
        return;
      }

      originals.forEach((item, index) => {
        item.dataset.carouselIndex = String(index);
      });

      const before = document.createDocumentFragment();
      const after = document.createDocumentFragment();

      originals.forEach((item, index) => {
        const beforeClone = item.cloneNode(true);
        const afterClone = item.cloneNode(true);

        [beforeClone, afterClone].forEach((clone) => {
          clone.dataset.carouselClone = "true";
          clone.dataset.carouselIndex = String(index);
          clone.setAttribute("aria-hidden", "true");
        });

        before.appendChild(beforeClone);
        after.appendChild(afterClone);
      });

      carousel.insertBefore(before, originals[0]);
      carousel.appendChild(after);
      carousel.dataset.loopReady = "true";
      loopOriginalCount = originals.length;

      window.requestAnimationFrame(() => {
        carousel.scrollLeft = originals[0].offsetLeft;
        requestProgressUpdate();
      });
    };

    const scrollStep = () => {
      const card = carousel.querySelector("article");
      const styles = window.getComputedStyle(carousel);
      const gap =
        gapOverride ??
        (Number.parseFloat(styles.columnGap || styles.gap || "0") || 0);

      return (card?.offsetWidth ?? 360) + gap;
    };

    const closestIndex = () => {
      const items = cards();

      if (items.length === 0) {
        return 0;
      }

      return items.reduce((closest, item, index) => {
        const distance = Math.abs(item.offsetLeft - carousel.scrollLeft);
        const closestDistance = Math.abs(
          items[closest].offsetLeft - carousel.scrollLeft,
        );

        return distance < closestDistance ? index : closest;
      }, 0);
    };

    const scrollToIndex = (index) => {
      const items = cards();

      if (items.length === 0) {
        return;
      }

      const target = items[(index + items.length) % items.length];

      carousel.scrollTo({
        left: target.offsetLeft,
        behavior: "smooth",
      });
    };

    const updateProgress = () => {
      const items = cards();
      const maxScroll = Math.max(carousel.scrollWidth - carousel.clientWidth, 0);
      let progress = 1;

      if (isLooping && loopOriginalCount > 1 && items.length > 0) {
        const active = items[closestIndex()];
        const activeIndex = Number.parseInt(
          active?.dataset.carouselIndex ?? "0",
          10,
        );

        progress = 0.24 + (clamp(activeIndex, 0, loopOriginalCount - 1) /
          (loopOriginalCount - 1)) * 0.76;
      } else {
        const scrollProgress =
          maxScroll > 0 ? clamp(carousel.scrollLeft / maxScroll, 0, 1) : 1;
        progress = maxScroll > 0 ? 0.24 + scrollProgress * 0.76 : 1;
      }

      document
        .querySelectorAll(`[data-carousel-progress="${carousel.id}"]`)
        .forEach((element) => {
          element.style.setProperty("--carousel-progress", progress.toFixed(4));
          element.style.setProperty(
            "--carousel-progress-percent",
            `${(progress * 100).toFixed(2)}%`,
          );
        });
    };

    const requestProgressUpdate = () => {
      if (progressFrame) {
        return;
      }

      progressFrame = window.requestAnimationFrame(() => {
        progressFrame = 0;
        updateProgress();
      });
    };

    const scroll = (direction) => {
      if (cards().length === 0) {
        carousel.scrollBy({
          left: direction * scrollStep(),
          behavior: "smooth",
        });
        return;
      }

      scrollToIndex(closestIndex() + direction);
    };

    const jumpToLoopPosition = (left) => {
      const previousBehavior = carousel.style.scrollBehavior;
      const previousSnap = carousel.style.scrollSnapType;

      carousel.style.scrollBehavior = "auto";
      carousel.style.scrollSnapType = "none";
      carousel.scrollTo({ left, behavior: "auto" });

      window.requestAnimationFrame(() => {
        window.requestAnimationFrame(() => {
          carousel.style.scrollBehavior = previousBehavior;
          carousel.style.scrollSnapType = previousSnap;
        });
      });
    };

    const normalizeLoopScroll = () => {
      if (!isLooping || normalizingLoop || pointerDown) {
        return;
      }

      const originals = originalCards();

      if (originals.length < 2) {
        return;
      }

      const first = originals[0];
      const last = originals[originals.length - 1];
      const step = scrollStep();
      const start = first.offsetLeft;
      const end = last.offsetLeft + last.offsetWidth + (gapOverride ?? 0);
      const width = end - start;
      const tolerance = Math.max(3, step * 0.02);

      if (width <= 0) {
        return;
      }

      normalizingLoop = true;

      if (carousel.scrollLeft <= start - step + tolerance) {
        jumpToLoopPosition(carousel.scrollLeft + width);
      } else if (carousel.scrollLeft >= end - tolerance) {
        jumpToLoopPosition(carousel.scrollLeft - width);
      }

      normalizingLoop = false;
    };

    const scheduleLoopNormalize = () => {
      if (!isLooping) {
        return;
      }

      window.clearTimeout(loopNormalizeTimer);
      loopNormalizeTimer = window.setTimeout(normalizeLoopScroll, 160);
    };

    const marqueeLoopWidth = () => {
      const group = carousel.querySelector(".tech-hero-gallery__group");

      return group?.getBoundingClientRect().width || 0;
    };

    const normalizeMarqueeScroll = () => {
      if (!isMarquee) {
        return;
      }

      const loopWidth = marqueeLoopWidth();

      if (loopWidth <= 0) {
        return;
      }

      if (carousel.scrollLeft >= loopWidth) {
        carousel.scrollLeft -= loopWidth;
      } else if (pointerDown && carousel.scrollLeft <= 1) {
        carousel.scrollLeft += loopWidth;
      }
    };

    const startAutoMarquee = () => {
      const respectsReducedMotion =
        carousel.dataset.carouselIgnoreReducedMotion !== "true";

      if (
        !isMarquee ||
        (respectsReducedMotion &&
          window.matchMedia("(prefers-reduced-motion: reduce)").matches)
      ) {
        return;
      }

      autoLastTime = performance.now();

      const tick = (time) => {
        const delta = Math.min(time - autoLastTime, 48);
        autoLastTime = time;

        if (!pointerDown && !document.hidden && time > autoPausedUntil) {
          const speed = Number.parseFloat(carousel.dataset.carouselAutoSpeed) || 34;
          carousel.scrollLeft += (speed * delta) / 1000;
          normalizeMarqueeScroll();
          requestProgressUpdate();
        }

        autoFrame = window.requestAnimationFrame(tick);
      };

      const placeMarqueeStart = (attempt = 0) => {
        const loopWidth = marqueeLoopWidth();

        if (loopWidth > 0 && carousel.scrollLeft < 2) {
          carousel.scrollLeft = 2;
          requestProgressUpdate();
          return;
        }

        if (loopWidth <= 0 && attempt < 12) {
          window.requestAnimationFrame(() => placeMarqueeStart(attempt + 1));
        }
      };

      window.requestAnimationFrame(() => placeMarqueeStart());

      carousel.querySelectorAll("img").forEach((image) => {
        if (!image.complete) {
          image.addEventListener(
            "load",
            () => window.requestAnimationFrame(() => placeMarqueeStart()),
            { once: true },
          );
        }
      });

      autoFrame = window.requestAnimationFrame(tick);
    };

    setupLoop();

    document
      .querySelector(`[data-carousel-prev="${carousel.id}"]`)
      ?.addEventListener("click", () => scroll(-1));

    document
      .querySelector(`[data-carousel-next="${carousel.id}"]`)
      ?.addEventListener("click", () => scroll(1));

    updateProgress();
    window.addEventListener("resize", requestProgressUpdate);
    carousel.addEventListener("scroll", requestProgressUpdate, { passive: true });

    const canStartDrag = (event) => {
      if (
        event.button !== 0 ||
        event.target.closest("button, a, input, textarea, select, summary")
      ) {
        return false;
      }

      return true;
    };

    const startDrag = (event, clientX, pointerId = null) => {
      if (!canStartDrag(event)) {
        return false;
      }

      normalizeLoopScroll();
      pointerDown = true;
      dragged = false;
      startX = clientX;
      lastX = clientX;
      startScrollLeft = carousel.scrollLeft;
      startIndex = closestIndex();
      autoPausedUntil = performance.now() + 900;
      carousel.classList.add("is-dragging");
      carousel.style.scrollSnapType = "none";

      if (pointerId !== null) {
        try {
          carousel.setPointerCapture?.(pointerId);
        } catch {
          // The drag still works without pointer capture.
        }
      }

      return true;
    };

    const moveDrag = (event, clientX) => {
      if (!pointerDown) {
        return;
      }

      lastX = clientX;
      const deltaX = clientX - startX;

      if (Math.abs(deltaX) > 4) {
        dragged = true;
        event.preventDefault();
      }

      carousel.scrollLeft = startScrollLeft - deltaX;
      requestProgressUpdate();
    };

    const endDrag = (event, clientX = lastX, pointerId = null) => {
      if (!pointerDown) {
        return;
      }

      pointerDown = false;
      carousel.classList.remove("is-dragging");
      if (pointerId !== null) {
        try {
          carousel.releasePointerCapture?.(pointerId);
        } catch {
          // Pointer capture may already be released by the browser.
        }
      }
      carousel.style.scrollSnapType = "";
      autoPausedUntil = performance.now() + 1200;

      if (dragged) {
        const deltaX = clientX - startX;
        const threshold = Math.min(scrollStep() * 0.18, 72);

        if (isMarquee) {
          normalizeMarqueeScroll();
          requestProgressUpdate();
        } else if (Math.abs(deltaX) > threshold) {
          scrollToIndex(startIndex + (deltaX < 0 ? 1 : -1));
        } else {
          scrollToIndex(startIndex);
        }

        if (isLooping) {
          window.setTimeout(normalizeLoopScroll, 260);
        }
      }
    };

    carousel.addEventListener("pointerdown", (event) => {
      startDrag(event, event.clientX, event.pointerId);
    });

    carousel.addEventListener("pointermove", (event) => {
      moveDrag(event, event.clientX);
    });

    carousel.addEventListener("pointerup", (event) => {
      endDrag(event, event.clientX, event.pointerId);
    });

    carousel.addEventListener("pointercancel", (event) => {
      endDrag(event, event.clientX ?? lastX, event.pointerId);
    });

    carousel.addEventListener("lostpointercapture", (event) => {
      endDrag(event, event.clientX ?? lastX, event.pointerId);
    });

    const endDocumentPointerDrag = (event) => {
      endDrag(event, event.clientX ?? lastX, event.pointerId ?? null);
    };

    document.addEventListener("pointerup", endDocumentPointerDrag);
    document.addEventListener("pointercancel", endDocumentPointerDrag);

    window.addEventListener("blur", () => {
      endDrag(new Event("blur"), lastX);
    });

    document.addEventListener("visibilitychange", () => {
      if (document.hidden) {
        endDrag(new Event("visibilitychange"), lastX);
        return;
      }

      autoLastTime = performance.now();
      autoPausedUntil = 0;
    });

    carousel.addEventListener("mousedown", (event) => {
      if (pointerDown || !startDrag(event, event.clientX)) {
        return;
      }

      const onMouseMove = (moveEvent) => moveDrag(moveEvent, moveEvent.clientX);
      const onMouseUp = (upEvent) => {
        document.removeEventListener("mousemove", onMouseMove);
        document.removeEventListener("mouseup", onMouseUp);
        endDrag(upEvent, upEvent.clientX);
      };

      document.addEventListener("mousemove", onMouseMove);
      document.addEventListener("mouseup", onMouseUp, { once: true });
    });

    carousel.addEventListener("dragstart", (event) => event.preventDefault());

    carousel.addEventListener("click", (event) => {
      if (dragged) {
        event.preventDefault();
        event.stopPropagation();
        dragged = false;
        return;
      }

      const card = event.target.closest("article");

      if (card && carousel.contains(card)) {
        if (tapMode === "next") {
          scroll(1);
          return;
        }

        scrollToIndex(cards().indexOf(card));
      }
    });

    carousel.addEventListener("scroll", normalizeMarqueeScroll, { passive: true });
    carousel.addEventListener("scroll", scheduleLoopNormalize, { passive: true });
    carousel.addEventListener("scrollend", normalizeLoopScroll);
    window.addEventListener("resize", normalizeMarqueeScroll);
    window.addEventListener("resize", normalizeLoopScroll);
    startAutoMarquee();
  });
}

function setFaqItem(item, open) {
  const toggle = item.querySelector("[data-faq-toggle]");
  const panel = item.querySelector("[data-faq-panel]");
  const chevron = item.querySelector("[data-faq-chevron]");

  if (!toggle || !panel) {
    return;
  }

  toggle.setAttribute("aria-expanded", open ? "true" : "false");
  panel.classList.toggle("max-h-0", !open);
  panel.classList.toggle("max-h-[400px]", open);
  panel.setAttribute("aria-hidden", open ? "false" : "true");
  chevron?.classList.toggle("rotate-180", open);
}

function setFaqRevealProgress(question, progress) {
  const eased = progress * progress * (3 - 2 * progress);
  const glowOpacity = Math.sin(eased * Math.PI);

  question.style.setProperty("--faq-reveal", `${(eased * 100).toFixed(2)}%`);
  question.style.setProperty(
    "--faq-reveal-glow-opacity",
    glowOpacity.toFixed(3),
  );
  question.dataset.faqRevealProgress = eased.toFixed(3);
}

function initFaqTextReveal(accordion) {
  const questions = [
    ...accordion.querySelectorAll("[data-faq-reveal-text]"),
  ];

  if (questions.length === 0) {
    return;
  }

  if (window.matchMedia("(prefers-reduced-motion: reduce)").matches) {
    questions.forEach((question) => setFaqRevealProgress(question, 1));
    return;
  }

  const update = () => {
    const viewportHeight = window.innerHeight;
    const startLine = viewportHeight * 0.86;
    const endLine = viewportHeight * 0.18;
    const revealDistance = Math.max(startLine - endLine, 1);

    questions.forEach((question) => {
      const item = question.closest("[data-faq-item]") || question;
      const progress = clamp(
        (startLine - item.getBoundingClientRect().top) / revealDistance,
        0,
        1,
      );

      setFaqRevealProgress(question, progress);
    });
  };

  registerScrollTask(update);
}

function initFaqScrollOpen(accordion) {
  if (!accordion.hasAttribute("data-faq-scroll-open")) {
    return;
  }

  const mobileQuery = window.matchMedia("(max-width: 991px)");

  if (!mobileQuery.matches) {
    return;
  }

  if (window.matchMedia("(prefers-reduced-motion: reduce)").matches) {
    return;
  }

  const items = [...accordion.querySelectorAll("[data-faq-item]")];

  if (items.length === 0) {
    return;
  }

  let activeIndex = items.findIndex(
    (item) =>
      item.querySelector("[data-faq-toggle]")?.getAttribute("aria-expanded") ===
      "true",
  );
  let pendingIndex = activeIndex;
  let pendingSince = performance.now();
  const switchDelay = 340;

  const openByIndex = (index) => {
    if (index === activeIndex || !items[index]) {
      return;
    }

    activeIndex = index;
    items.forEach((item, itemIndex) => {
      setFaqItem(item, itemIndex === activeIndex);
    });
  };

  const update = () => {
    if (!mobileQuery.matches) {
      return;
    }

    const accordionRect = accordion.getBoundingClientRect();
    const viewportHeight = window.innerHeight;

    if (
      accordionRect.bottom < viewportHeight * 0.18 ||
      accordionRect.top > viewportHeight * 0.86
    ) {
      return;
    }

    const focusLine = viewportHeight * 0.42;
    let closestIndex = 0;
    let closestDistance = Number.POSITIVE_INFINITY;

    items.forEach((item, index) => {
      const rect = item.getBoundingClientRect();
      const itemLine = rect.top + Math.min(rect.height * 0.35, 52);
      const distance = Math.abs(itemLine - focusLine);

      if (distance < closestDistance) {
        closestDistance = distance;
        closestIndex = index;
      }
    });

    if (closestIndex === activeIndex) {
      pendingIndex = closestIndex;
      pendingSince = performance.now();
      return;
    }

    const now = performance.now();

    if (closestIndex !== pendingIndex) {
      pendingIndex = closestIndex;
      pendingSince = now;
      return;
    }

    if (now - pendingSince >= switchDelay) {
      openByIndex(closestIndex);
    }
  };

  registerScrollTask(update);
}

export function initFaqAccordion() {
  const accordion = document.querySelector("[data-faq-accordion]");

  if (!accordion) {
    return;
  }

  const items = [...accordion.querySelectorAll("[data-faq-item]")];

  if (items.length === 0) {
    return;
  }

  const hasOpenItem = items.some(
    (item) =>
      item.querySelector("[data-faq-toggle]")?.getAttribute("aria-expanded") ===
      "true",
  );

  if (!hasOpenItem) {
    setFaqItem(items[0], true);
  }

  initFaqScrollOpen(accordion);

  items.forEach((item) => {
    const toggle = item.querySelector("[data-faq-toggle]");

    toggle?.addEventListener("click", () => {
      const opening = toggle.getAttribute("aria-expanded") !== "true";

      if (!opening) {
        return;
      }

      accordion
        .querySelectorAll("[data-faq-item]")
        .forEach((other) => setFaqItem(other, false));

      setFaqItem(item, true);
    });
  });
}

export function initPricingToggle() {
  const root = document.querySelector("[data-pricing-table]");

  if (!root) {
    return;
  }

  const toggles = root.querySelectorAll("[data-pricing-toggle]");
  const panels = root.querySelectorAll("[data-pricing-panel]");

  toggles.forEach((toggle) => {
    toggle.addEventListener("click", () => {
      const target = toggle.getAttribute("data-pricing-toggle");

      toggles.forEach((button) => {
        button.setAttribute(
          "aria-pressed",
          button.getAttribute("data-pricing-toggle") === target
            ? "true"
            : "false",
        );
      });

      panels.forEach((panel) => {
        panel.classList.toggle(
          "hidden",
          panel.getAttribute("data-pricing-panel") !== target,
        );
      });
    });
  });
}

export function initPricingHeroMotion() {
  const hero = document.querySelector("[data-pricing-hero-motion]");

  if (
    !hero ||
    window.matchMedia("(prefers-reduced-motion: reduce)").matches
  ) {
    return;
  }

  const orbs = [...hero.querySelectorAll(".pricing-hero__orb")].map(
    (element, index) => ({
      element,
      depth: 4 + index * 0.65,
      direction: index % 2 === 0 ? 1 : -1,
      currentX: 0,
      currentY: 0,
      targetX: 0,
      targetY: 0,
    }),
  );

  if (orbs.length === 0) {
    return;
  }

  let frame = 0;

  const write = () => {
    frame = 0;
    let shouldContinue = false;

    orbs.forEach((orb) => {
      orb.currentX += (orb.targetX - orb.currentX) * 0.12;
      orb.currentY += (orb.targetY - orb.currentY) * 0.12;

      if (
        Math.abs(orb.targetX - orb.currentX) > 0.04 ||
        Math.abs(orb.targetY - orb.currentY) > 0.04
      ) {
        shouldContinue = true;
      }

      orb.element.style.setProperty(
        "--pricing-orb-pointer-x",
        `${orb.currentX.toFixed(2)}px`,
      );
      orb.element.style.setProperty(
        "--pricing-orb-pointer-y",
        `${orb.currentY.toFixed(2)}px`,
      );
    });

    if (shouldContinue) {
      frame = window.requestAnimationFrame(write);
    }
  };

  const scheduleWrite = () => {
    if (!frame) {
      frame = window.requestAnimationFrame(write);
    }
  };

  hero.addEventListener(
    "pointermove",
    (event) => {
      if (event.pointerType && event.pointerType !== "mouse") {
        return;
      }

      const rect = hero.getBoundingClientRect();
      const x = clamp(
        (event.clientX - rect.left) / Math.max(rect.width, 1) - 0.5,
        -0.5,
        0.5,
      );
      const y = clamp(
        (event.clientY - rect.top) / Math.max(rect.height, 1) - 0.5,
        -0.5,
        0.5,
      );

      orbs.forEach((orb) => {
        orb.targetX = x * orb.depth * orb.direction;
        orb.targetY = y * orb.depth * 0.72 * orb.direction;
      });

      scheduleWrite();
    },
    { passive: true },
  );

  hero.addEventListener("pointerleave", () => {
    orbs.forEach((orb) => {
      orb.targetX = 0;
      orb.targetY = 0;
    });

    scheduleWrite();
  });
}
