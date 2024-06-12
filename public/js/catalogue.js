document.addEventListener('DOMContentLoaded', function() {
  function sortVelos(order) { //2.b
      const veloList = document.getElementById('velo-list');
      const velos = Array.from(veloList.getElementsByClassName('product-card'));

      velos.sort((a, b) => {
          const priceA = parseFloat(a.getAttribute('data-price'));
          const priceB = parseFloat(b.getAttribute('data-price'));

          return order === 'asc' ? priceA - priceB : priceB - priceA;
      });

      velos.forEach(velo => veloList.appendChild(velo));
  }

  function filterVelos(categoryId) { // 2.a
      const veloList = document.getElementById('velo-list');
      const velos = Array.from(veloList.getElementsByClassName('product-card'));

      velos.forEach(velo => {
          const categoryIdAttr = velo.getAttribute('data-category');
          velo.style.display = (categoryId === 'all' || categoryIdAttr === categoryId) ? 'block' : 'none';
      });
  }

  function changeCategory() {
      const selectElement = document.getElementById('categorie-select');
      const selectedCategory = selectElement.value;
      filterVelos(selectedCategory);
  }

  const filterSortBtn = document.getElementById('filter-sort-btn');
  const sortSelect = document.getElementById('sort-select');
  const categorieSelect = document.getElementById('categorie-select');
  const dropdownContent = document.getElementById('dropdown-content');

  if (filterSortBtn && sortSelect && categorieSelect && dropdownContent) {
      filterSortBtn.addEventListener('click', function() {
          dropdownContent.style.display = dropdownContent.style.display === 'block' ? 'none' : 'block';
      });

      sortSelect.addEventListener('change', function() {
          const order = this.value;
          sortVelos(order);
      });

      categorieSelect.addEventListener('change', changeCategory);
  }
});