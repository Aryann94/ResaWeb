document.addEventListener('DOMContentLoaded', function() {
  const wrapper = document.getElementById("tiles");
  const categorieContainer = document.querySelector(".categorie-container");
  const tileWidth = 50;
  const tileHeight = 50;

  // Calculer le nombre de colonnes et de lignes en fonction de la taille de la .categorie-container
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



  window.showBestProducts = function() {
    document.getElementById("best-products").style.display = "flex";
    document.getElementById("new-products").style.display = "none";
    document.getElementById("newButton").classList.remove("active");
    document.getElementById("bestButton").classList.add("active");
  }
  
  window.showNewProducts = function() {
    document.getElementById("best-products").style.display = "none";
    document.getElementById("new-products").style.display = "flex";
    document.getElementById("bestButton").classList.remove("active");
    document.getElementById("newButton").classList.add("active");
  }
  
  showNewProducts();

    showNewProducts();

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
  });

