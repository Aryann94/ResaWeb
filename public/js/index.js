document.addEventListener('DOMContentLoaded', function() {
const wrapper = document.getElementById("tiles");
const categorieContainer = document.querySelector(".categorie-container");
const tileWidth = 100; // Augmenter la taille des tuiles
const tileHeight = 100; // Augmenter la taille des tuiles

let columns = Math.floor(categorieContainer.offsetWidth / tileWidth);
let rows = Math.floor(categorieContainer.offsetHeight / tileHeight);

const colors = [
  "hsl(159, 27%, 50%)",
  "hsl(158, 27%, 40%)",
  "hsl(159, 78%, 30%)",
  "hsl(156, 6%, 0%)"
];

let count = -1;

const handleOnClick = index => {
  count = count + 1;

  anime({
    targets: ".tile",
    backgroundColor: colors[count % (colors.length - 1)],
    delay: anime.stagger(50, {
      grid: [columns, rows],
      from: index
    })
  })
}

const createTile = (index) => {
  const tile = document.createElement("div");
  tile.classList.add("tile");
  tile.onclick = e => handleOnClick(index);
  return tile;
}

const createTiles = () => {
  const fragment = document.createDocumentFragment();
  for (let i = 0; i < columns * rows; i++) {
    fragment.appendChild(createTile(i));
  }
  wrapper.appendChild(fragment);
}

const createGrid = () => {
  wrapper.innerHTML = "";

  columns = Math.floor(categorieContainer.offsetWidth / tileWidth);
  rows = Math.floor(categorieContainer.offsetHeight / tileHeight);

  wrapper.style.setProperty("--columns", columns);
  wrapper.style.setProperty("--rows", rows);

  createTiles();
}

createGrid();

window.addEventListener("resize", createGrid);

let lastTime = 0;
const animate = (time) => {
  if (time - lastTime > 2000) {
    const randomIndex = Math.floor(Math.random() * (columns * rows));
    handleOnClick(randomIndex);
    lastTime = time;
  }
  requestAnimationFrame(animate);
}
requestAnimationFrame(animate);



  window.addEventListener('load', (event) => {
    setTimeout(() => {
      gsap.registerPlugin(ScrollTrigger);
  
      const splitTypes = document.querySelectorAll('.reveal-type');
  
      splitTypes.forEach((char,i) => {
        const text = new SplitType(char, { types: 'chars'})
  
        gsap.from(text.chars, {
          scrollTrigger: {
            trigger: char,
            start: 'top 80%',
            end: 'top 20%',
            scrub: true,
            markers: false
          },
          opacity: 0.2,
          stagger: 0.1
        })
      })
  
      // Force ScrollTrigger to recalculate positions
      ScrollTrigger.refresh();
    }, 1000); // Delay of 1 second
  
    // Force ScrollTrigger to recalculate positions
    ScrollTrigger.refresh();
  });

  if (!window.matchMedia("(prefers-reduced-motion: reduce)").matches) {
    gsap.to('.content', {
      scrollTrigger: {
        trigger: '.ecology-container',
        scrub: 0.5,
        start: "top 70%",
        end: "bottom top",
      },
      scale: 1
    })
  
    gsap.from(".hero h1, .hero p, .hero a", {
      opacity: 0,
      y: 50,
      duration: 1,
      delay: 0.5
    });
  }





  
  // https://www.youtube.com/watch?v=PsNaoDhzQm0&list=PLpwngcHZlPae68z_mLFNfbJFIJVJ_Zcx2
  const bestProducts = document.getElementById("best-products");
  const newProducts = document.getElementById("new-products");
  const prevSlideButton = document.getElementById("prev-slide");
  const nextSlideButton = document.getElementById("next-slide");

  let currentProductContainer = bestProducts;
  let maxScrollLeft;

  const updateMaxScrollLeft = () => {
      maxScrollLeft = currentProductContainer.scrollWidth - currentProductContainer.clientWidth;
  };

  const handleSlideButtons = () => {
      prevSlideButton.style.display = "block";
      nextSlideButton.style.display = "block";
  };

  const switchProductContainer = (newContainer) => {
      currentProductContainer = newContainer;
      updateMaxScrollLeft();
      handleSlideButtons();
  };

  // Slide products based on button clicks
  prevSlideButton.addEventListener("click", () => {
      const scrollAmount = -currentProductContainer.clientWidth;
      currentProductContainer.scrollBy({ left: scrollAmount, behavior: "smooth" });
  });

  nextSlideButton.addEventListener("click", () => {
      const scrollAmount = currentProductContainer.clientWidth;
      currentProductContainer.scrollBy({ left: scrollAmount, behavior: "smooth" });
  });

  // Switch between best and new products
  window.showBestProducts = () => {
      document.getElementById("best-products").style.display = "flex";
      document.getElementById("new-products").style.display = "none";
      document.getElementById("newButton").classList.remove("active");
      document.getElementById("bestButton").classList.add("active");
      switchProductContainer(bestProducts);
  };

  window.showNewProducts = () => {
      document.getElementById("best-products").style.display = "none";
      document.getElementById("new-products").style.display = "flex";
      document.getElementById("bestButton").classList.remove("active");
      document.getElementById("newButton").classList.add("active");
      switchProductContainer(newProducts);
  };

  // Initial setup
  updateMaxScrollLeft();
  handleSlideButtons();
  showNewProducts();
  window.addEventListener("resize", updateMaxScrollLeft);
  });

