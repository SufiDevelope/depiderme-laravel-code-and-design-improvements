import { bindHorizontalSwipe, isDesktopHover } from "./utils.js";

export function initClinics() {
  initClinicsAccordion();
  initClinicsCarousels();
}

function initClinicsAccordion() {
  const accordion = document.querySelector("[data-clinics-accordion]");

  if (!accordion) {
    return;
  }

  const slugByIndex = ["leiria", "coimbra", "viseu", "vila-real", "porto"];
  const headerOffset = 96;

  let activeIndex =
    accordion
      .querySelector(".clinics-accordion__item.is-expanded")
      ?.getAttribute("data-clinic-index") ?? "0";

  const updateAccordionVisual = (openIndex) => {
    accordion.querySelectorAll("[data-clinic-item]").forEach((item) => {
      const isOpen = item.getAttribute("data-clinic-index") === openIndex;

      item.classList.toggle("is-expanded", isOpen);
      item.setAttribute("aria-expanded", isOpen ? "true" : "false");
      item
        .querySelector("[data-clinic-panel]")
        ?.setAttribute("aria-hidden", isOpen ? "false" : "true");
    });
  };

  const scrollToClinic = (index) => {
    const target = document.getElementById(
      `clinica-${slugByIndex[Number.parseInt(index ?? "0", 10)]}`,
    );

    if (!target) {
      return;
    }

    window.scrollTo({
      top: Math.max(
        0,
        target.getBoundingClientRect().top + window.scrollY - headerOffset,
      ),
      behavior: "smooth",
    });
  };

  const scrollAccordionItem = (item) => {
    const scroller = item.closest(".overflow-x-auto");

    if (!scroller) {
      return;
    }

    scroller.scrollTo({
      left: Math.max(
        0,
        item.offsetLeft - (scroller.clientWidth - item.offsetWidth) / 2,
      ),
      behavior: "smooth",
    });
  };

  const navigateToClinic = (index, item, { scrollToDetail = true } = {}) => {
    activeIndex = index ?? "0";
    updateAccordionVisual(activeIndex);

    if (isDesktopHover()) {
      if (scrollToDetail) {
        scrollToClinic(activeIndex);
      }

      return;
    }

    if (item) {
      scrollAccordionItem(item);
    }

    window.setTimeout(() => {
      if (item) {
        scrollAccordionItem(item);
      }

      if (scrollToDetail) {
        scrollToClinic(activeIndex);
      }
    }, 320);
  };

  const syncFromHash = () => {
    const match = window.location.hash.match(/^#clinica-(.+)$/);
    const index = match ? slugByIndex.indexOf(match[1]) : -1;

    if (index === -1) {
      return;
    }

    navigateToClinic(
      String(index),
      accordion.querySelector(`[data-clinic-index="${index}"]`),
      { scrollToDetail: true },
    );
  };

  accordion.querySelectorAll("[data-clinic-item]").forEach((item) => {
    const index = item.getAttribute("data-clinic-index");

    item.addEventListener("click", () => {
      navigateToClinic(index ?? "0", item, {
        scrollToDetail: isDesktopHover(),
      });
    });

    item.addEventListener("mouseenter", () => {
      if (isDesktopHover()) {
        updateAccordionVisual(index ?? "0");
      }
    });
  });

  accordion.addEventListener("mouseleave", () => {
    if (isDesktopHover()) {
      updateAccordionVisual(activeIndex);
    }
  });

  updateAccordionVisual(activeIndex);

  if (window.location.hash.match(/^#clinica-/)) {
    window.addEventListener("load", syncFromHash, { once: true });
  }

  window.addEventListener("hashchange", syncFromHash);
}

function initClinicsCarousels() {
  document.querySelectorAll("[data-clinic-carousel]").forEach((carousel) => {
    const slides = carousel.querySelectorAll("[data-clinic-slide]");
    const dots = carousel.querySelectorAll("[data-clinic-dot]");
    let current = 0;

    if (slides.length === 0) {
      return;
    }

    const show = (index) => {
      current = (index + slides.length) % slides.length;

      slides.forEach((slide, slideIndex) => {
        slide.classList.toggle("is-active", slideIndex === current);
      });

      dots.forEach((dot, dotIndex) => {
        dot.classList.toggle("is-active", dotIndex === current);
      });
    };

    carousel
      .querySelector("[data-clinic-prev]")
      ?.addEventListener("click", () => show(current - 1));

    carousel
      .querySelector("[data-clinic-next]")
      ?.addEventListener("click", () => show(current + 1));

    dots.forEach((dot) => {
      dot.addEventListener("click", () => {
        show(Number.parseInt(dot.getAttribute("data-clinic-dot") ?? "0", 10));
      });
    });

    if (slides.length > 1) {
      bindClinicGalleryDrag(
        carousel,
        () => show(current + 1),
        () => show(current - 1),
      );
    }
  });
}

function bindClinicGalleryDrag(element, onLeft, onRight, threshold = 48) {
  if (window.PointerEvent) {
    let pointerDown = false;
    let dragged = false;
    let startX = 0;
    let startY = 0;
    let lastX = 0;
    let lastY = 0;

    const endDrag = (event) => {
      if (!pointerDown) {
        return;
      }

      pointerDown = false;
      element.classList.remove("is-dragging");

      try {
        element.releasePointerCapture?.(event.pointerId);
      } catch {
        // Capture may already be released after pointer cancellation.
      }

      const deltaX = lastX - startX;
      const deltaY = lastY - startY;

      if (Math.abs(deltaX) >= threshold && Math.abs(deltaX) > Math.abs(deltaY)) {
        (deltaX < 0 ? onLeft : onRight)();
      }
    };

    element.addEventListener("pointerdown", (event) => {
      if (
        event.button !== 0 ||
        event.target.closest("button, a, input, textarea, select, summary")
      ) {
        return;
      }

      pointerDown = true;
      dragged = false;
      startX = event.clientX;
      startY = event.clientY;
      lastX = event.clientX;
      lastY = event.clientY;
      element.classList.add("is-dragging");

      try {
        element.setPointerCapture?.(event.pointerId);
      } catch {
        // The gesture can still complete through bubbling pointer events.
      }
    });

    element.addEventListener("pointermove", (event) => {
      if (!pointerDown) {
        return;
      }

      lastX = event.clientX;
      lastY = event.clientY;

      const deltaX = lastX - startX;
      const deltaY = lastY - startY;

      if (Math.abs(deltaX) > 6 && Math.abs(deltaX) > Math.abs(deltaY)) {
        dragged = true;
        event.preventDefault();
      }
    });

    element.addEventListener("pointerup", endDrag);
    element.addEventListener("pointercancel", endDrag);
    element.addEventListener("lostpointercapture", endDrag);
    element.addEventListener("dragstart", (event) => event.preventDefault());

    element.addEventListener("click", (event) => {
      if (!dragged) {
        return;
      }

      event.preventDefault();
      event.stopPropagation();
      dragged = false;
    });

    return;
  }

  bindHorizontalSwipe(element, onLeft, onRight, threshold);
}
