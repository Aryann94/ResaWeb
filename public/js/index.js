const wrapper = document.getElementById("tiles");
const categorieContainer = document.querySelector(".categorie-container");
const tileWidth = 50;
const tileHeight = 50;

// Calculer le nombre de colonnes et de lignes en fonction de la taille de la .categorie-container
let columns = Math.floor(categorieContainer.offsetWidth / tileWidth);
let rows = Math.floor(categorieContainer.offsetHeight / tileHeight);

const colors = [
"hsl(159, 27%, 16%)",
"hsl(158, 27%, 16%)",
"hsl(159, 78%, 11%)",
"hsl(156, 6%, 10%)"
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
for (let i = 0; i < columns * rows; i++) {
    wrapper.appendChild(createTile(i));
}
}

const createGrid = () => {
// Nettoyer le contenu existant de la grille
wrapper.innerHTML = "";

// Mettre à jour le nombre de colonnes et de lignes en fonction de la taille de .categorie-container
columns = Math.floor(categorieContainer.offsetWidth / tileWidth);
rows = Math.floor(categorieContainer.offsetHeight / tileHeight);

// Définir les propriétés de la grille CSS personnalisées
wrapper.style.setProperty("--columns", columns);
wrapper.style.setProperty("--rows", rows);

// Créer les tuiles dans la grille mise à jour
createTiles();
}

// Appeler createGrid une fois pour créer la grille initiale
createGrid();

// Appeler createGrid à nouveau lors du redimensionnement de la fenêtre pour mettre à jour la grille en conséquence
window.addEventListener("resize", createGrid);

// Déclencher les clics de manière aléatoire à des intervalles réguliers
setInterval(() => {
const randomIndex = Math.floor(Math.random() * (columns * rows));
handleOnClick(randomIndex);
}, 2000); // Changement de tuile toutes les 2 secondes (2000 millisecondes)


let typeSplit;

// Split the text up
function runSplit() {
typeSplit = new SplitType(".split-word", {
  types: "words" // Split the text into words
});
createAnimation();
}

runSplit();

// Register GSAP plugins
gsap.registerPlugin(ScrollTrigger);

// Create staggered animation
  function createAnimation() {
  let words = document.querySelectorAll(".word");

  let tl = gsap.timeline({
    scrollTrigger: {
      trigger: ".split-word",
      start: "top 10%",
      end: "bottom top",
      scrub: 1
    }
  });

  tl.to(words, {
    opacity: 1,
    duration: 1,
    stagger: 0.5
  });
  }



function showBestProducts() {
    document.getElementById("best-products").style.display = "flex";
    document.getElementById("new-products").style.display = "none";
    document.getElementById("newButton").classList.remove("active");
    document.getElementById("bestButton").classList.add("active");
  }

  function showNewProducts() {
    document.getElementById("best-products").style.display = "none";
    document.getElementById("new-products").style.display = "flex";
    document.getElementById("bestButton").classList.remove("active");
    document.getElementById("newButton").classList.add("active");
  }

  showNewProducts();



  gsap.to('.content', {
    scrollTrigger: {
      trigger: '.custom-container',
      scrub: 0.5,
      start: "top 70%",
      end: "bottom top",
    },
    scale: 1
  })