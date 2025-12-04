class Carousel {
  constructor() {
    this.track = document.querySelector(".carousel-track");
    this.items = document.querySelectorAll(".carousel-item");
    this.itemWidth = 140; // width + gap
    this.currentIndex = 2; // Start from Earth (center)
    this.isTransitioning = false;

    this.init();
  }

  init() {
    this.updateCarousel();
    this.setupEventListeners();
  }

  updateCarousel() {
    const offset = (this.currentIndex - 2) * this.itemWidth;
    this.track.style.transform = `translateX(-${offset}px)`;

    this.updateItemClasses();
  }

  updateItemClasses() {
    this.items.forEach((item, index) => {
      item.classList.remove("center", "side");

      if (index === this.currentIndex) {
        item.classList.add("center");
      } else if (
        index === this.currentIndex - 1 ||
        index === this.currentIndex - 2 ||
        index === this.currentIndex + 1 ||
        index === this.currentIndex + 2
      ) {
        item.classList.add("side");
      }
    });
  }

  next() {
    if (this.isTransitioning || this.currentIndex >= this.items.length - 2)
      return;
    this.currentIndex++;
    this.updateCarousel();
  }

  prev() {
    if (this.isTransitioning || this.currentIndex <= 2) return;
    this.currentIndex--;
    this.updateCarousel();
  }

  setupEventListeners() {
    document.addEventListener("keydown", (e) => {
      if (e.key === "ArrowRight") this.next();
      if (e.key === "ArrowLeft") this.prev();
    });

    this.items.forEach((item, index) => {
      item.addEventListener("click", () => {
        this.currentIndex = index;
        this.updateCarousel();
      });
    });

    let touchStartX = 0;
    this.track.addEventListener("touchstart", (e) => {
      touchStartX = e.touches[0].clientX;
    });

    this.track.addEventListener("touchend", (e) => {
      const touchEndX = e.changedTouches[0].clientX;
      const diff = touchStartX - touchEndX;

      if (diff > 50) this.next();
      if (diff < -50) this.prev();
    });
  }
}

document.addEventListener("DOMContentLoaded", () => {
  new Carousel();
});
