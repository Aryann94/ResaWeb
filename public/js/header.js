document.addEventListener('DOMContentLoaded', function() {
  const searchBtn = document.getElementById('search-btn');
  const searchContainer = document.getElementById('search-container');
  const blurBackground = document.getElementById('blur-background');

  window.addEventListener('load', () => {
    const loader = document.querySelector('.loader');
    loader.style.display = 'none';
    
    const loaderContainer = document.querySelector('.loader-container');
    loaderContainer.style.display = 'none';
    });
  
  searchBtn.addEventListener('click', function() {
    if (searchContainer.classList.contains('show')) {
      searchContainer.classList.remove('show');
      setTimeout(() => {
        searchContainer.style.display = 'none';
      }, 300); // Correspond à la durée de la transition CSS
    } else {
      searchContainer.style.display = 'flex';
      setTimeout(() => {
        searchContainer.classList.add('show');
      }, 10); // Petit délai pour permettre le changement de display avant l'ajout de la classe
    }
    
    if (blurBackground.classList.contains('show')) {
      blurBackground.classList.remove('show');
      setTimeout(() => {
        blurBackground.style.display = 'none';
      }, 300); // Correspond à la durée de la transition CSS
    } else {
      blurBackground.style.display = 'block';
      setTimeout(() => {
        blurBackground.classList.add('show');
      }, 10); // Petit délai pour permettre le changement de display avant l'ajout de la classe
    }
  });

  blurBackground.addEventListener('click', function() {
    searchContainer.classList.remove('show');
    blurBackground.classList.remove('show');
    setTimeout(() => {
      searchContainer.style.display = 'none';
      blurBackground.style.display = 'none';
    }, 300); // Correspond à la durée de la transition CSS
  });

  gsap.from(".navbar", {
    duration: 2,
    y: -200,
    opacity: 0,
    ease: "power4.out"
  });

  const lenis = new Lenis()

  lenis.on('scroll', (e) => {
    // console.log(e)
  })

  function raf(time) {
    lenis.raf(time)
    requestAnimationFrame(raf)
  }

  requestAnimationFrame(raf)

});

