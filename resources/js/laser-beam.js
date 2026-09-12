import { registerScrollTask } from "./scroll.js";
import { clamp } from "./utils.js";

export function initLaserBeamLoop() {
  const beams = [...document.querySelectorAll("[data-laser-beam-loop]")];

  beams.forEach((beam) => {
    const video = beam.querySelector("video");

    if (!video) {
      return;
    }

    video.muted = true;
    video.defaultMuted = true;
    video.playsInline = true;
    video.setAttribute("playsinline", "");
    video.loop = true;

    if (video.preload !== "none") {
      video.preload = "metadata";
    }

    const play = () => {
      video.play().catch(() => {});
    };

    const pause = () => {
      video.pause();
    };

    if (typeof IntersectionObserver === "undefined") {
      if (video.readyState >= 2) {
        play();
      } else {
        video.addEventListener("loadeddata", play, { once: true });
      }

      return;
    }

    const observer = new IntersectionObserver(
      ([entry]) => {
        if (entry.isIntersecting) {
          if (video.readyState >= 2) {
            play();
          } else {
            video.addEventListener("loadeddata", play, { once: true });
          }
        } else {
          pause();
        }
      },
      { rootMargin: "80px 0px", threshold: 0.01 },
    );

    observer.observe(beam);
  });
}

function setScrollBeamProgress(
  beam,
  progress,
  linear = false,
  minScale = 0,
  minOpacity = 0.18,
) {
  const animatedProgress = linear
    ? progress
    : progress * progress * (3 - 2 * progress);
  const scale = minScale + animatedProgress * (1 - minScale);
  const opacity = minOpacity + animatedProgress * (1 - minOpacity);
  const flareScale = 0.45 + scale * 0.55;
  const sweepOpacity = clamp(animatedProgress * 1.2, 0, 1);
  const sweepScale = 0.35 + animatedProgress * 0.65;

  beam.style.setProperty("--scroll-laser-scale", scale.toFixed(4));
  beam.style.setProperty("--scroll-laser-opacity", opacity.toFixed(4));
  beam.style.setProperty("--scroll-laser-end", `${(scale * 100).toFixed(2)}%`);
  beam.style.setProperty(
    "--scroll-laser-sweep-opacity",
    sweepOpacity.toFixed(4),
  );
  beam.style.setProperty(
    "--scroll-laser-sweep-scale",
    sweepScale.toFixed(4),
  );
  beam.style.setProperty(
    "--scroll-laser-flare-scale",
    flareScale.toFixed(4),
  );

  const aboutSpacesDivider = beam.closest(".about-spaces-divider");

  if (aboutSpacesDivider) {
    aboutSpacesDivider.style.setProperty(
      "--about-spaces-gradient-progress",
      animatedProgress.toFixed(4),
    );
    aboutSpacesDivider.style.setProperty(
      "--about-spaces-gradient-end",
      `${(scale * 100).toFixed(2)}%`,
    );
  }

  beam.dataset.laserProgress = animatedProgress.toFixed(3);
  beam.dataset.laserSweepProgress = animatedProgress.toFixed(3);
}

export function initScrollLaserBeams() {
  const beams = [...document.querySelectorAll("[data-scroll-laser-beam]")];

  if (beams.length === 0) {
    return;
  }

  if (window.matchMedia("(prefers-reduced-motion: reduce)").matches) {
    beams.forEach((beam) => setScrollBeamProgress(beam, 1));
    return;
  }

  const beamSections = beams
    .map((beam) => ({
      beam,
      section:
        beam.closest("[data-scroll-laser-section]") || beam.parentElement,
      itemSelector: beam.dataset.scrollLaserItems,
      scrollMode: beam.dataset.scrollLaserMode,
      speed: Number.parseFloat(beam.dataset.scrollLaserSpeed) || 1,
      minScale: clamp(
        Number.parseFloat(beam.dataset.scrollLaserMinScale) || 0,
        0,
        1,
      ),
      minOpacity: clamp(
        Number.parseFloat(beam.dataset.scrollLaserMinOpacity) || 0.18,
        0,
        1,
      ),
    }))
    .filter(({ section }) => section);

  const update = () => {
    const viewportHeight = window.innerHeight;
    const startLine = viewportHeight * 0.88;
    const endLine = viewportHeight * 0.28;

    beamSections.forEach(
      ({
        beam,
        section,
        itemSelector,
        scrollMode,
        speed,
        minScale,
        minOpacity,
      }) => {
      if (itemSelector) {
        const items = [...section.querySelectorAll(itemSelector)];

        if (items.length > 1) {
          if (scrollMode === "cumulative-items") {
            const progress =
              items.reduce((total, item) => {
                const rect = item.getBoundingClientRect();
                const stickyTop =
                  Number.parseFloat(getComputedStyle(item).top) || 0;
                const itemProgress = clamp(
                  (viewportHeight - rect.top) /
                    Math.max(viewportHeight - stickyTop, 1),
                  0,
                  1,
                );

                return total + itemProgress;
              }, 0) / items.length;

            setScrollBeamProgress(
              beam,
              clamp(progress * speed, 0, 1),
              true,
              minScale,
              minOpacity,
            );
            return;
          }

          const firstRect = items[0].getBoundingClientRect();
          const lastRect = items.at(-1).getBoundingClientRect();
          const itemTravel = Math.max(lastRect.top - firstRect.top, 1);
          const progress = clamp(
            (startLine - firstRect.top) / itemTravel,
            0,
            1,
          );

          setScrollBeamProgress(
            beam,
            clamp(progress * speed, 0, 1),
            false,
            minScale,
            minOpacity,
          );
          return;
        }
      }

      const rect = section.getBoundingClientRect();

      if (scrollMode === "beam") {
        const line = beam.querySelector(".scroll-laser-beam__line");
        const beamRect = (line || beam).getBoundingClientRect();
        const beamStartLine = viewportHeight * 0.96;
        const beamEndLine = viewportHeight * 0.34;
        const progress = clamp(
          (beamStartLine - beamRect.top) /
            Math.max(beamStartLine - beamEndLine, 1),
          0,
          1,
        );

        setScrollBeamProgress(
          beam,
          clamp(progress * speed, 0, 1),
          false,
          minScale,
          minOpacity,
        );
        return;
      }

      if (scrollMode === "section") {
        const scrollDistance = Math.max(
          rect.height - viewportHeight * 0.3,
          1,
        );
        const progress = clamp(-rect.top / scrollDistance, 0, 1);

        setScrollBeamProgress(
          beam,
          clamp(progress * speed, 0, 1),
          false,
          minScale,
          minOpacity,
        );
        return;
      }

      const travelDistance = Math.max(
        rect.height + startLine - endLine,
        1,
      );
      const progress = clamp(
        (startLine - rect.top) / travelDistance,
        0,
        1,
      );

      setScrollBeamProgress(
        beam,
        clamp(progress * speed, 0, 1),
        false,
        minScale,
        minOpacity,
      );
      },
    );
  };

  registerScrollTask(update);
}
