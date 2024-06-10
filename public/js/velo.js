$(function() {
        $("#start_date, #end_date").datepicker({ dateFormat: 'yy-mm-dd' });
    });
    document.addEventListener('DOMContentLoaded', function() {
      const checkAvailabilityButton = document.getElementById('checkAvailabilityButton');
      const addToBucketButton = document.getElementById('addToBucketButton');

    

        checkAvailabilityButton.addEventListener('click', function() {
            event.preventDefault();
            const startDate = document.getElementById('start_date').value;
            const startTime = document.getElementById('start_time').value + ":00";
            const endDate = document.getElementById('end_date').value;
            const endTime = document.getElementById('end_time').value + ":00";

            // Validation for time range
            if (!isTimeInRange(startTime) || !isTimeInRange(endTime)) {
                Swal.fire('Erreur', 'Les réservations doivent être entre 08:00 et 17:00.', 'error');
                return;
            }

            const startDateTime = `${startDate} ${startTime}`;
            const endDateTime = `${endDate} ${endTime}`;

            $.ajax({
                url: '/resaweb/check_availability',
                method: 'GET',
                data: {
                    velo_id: addToBucketButton.getAttribute('data-id'),
                    start: startDateTime,
                    end: endDateTime
                },
                success: function(response) {
                    if (response.available) {
                        Swal.fire('Disponible', 'Le vélo est disponible.', 'success');
                        addToBucketButton.removeAttribute('disabled'); // Activer le bouton
                        addToBucketButton.style.display = 'block'; // Rendre le bouton visible
                        addToBucketButton.style.cursor = 'pointer'; // Changer le curseur
                        addToBucketButton.classList.remove('tooltip');

                        const tooltipText = addToBucketButton.querySelector('.tooltiptext');
                        if (tooltipText) {
                            tooltipText.remove(); // Enlever le span de tooltip
                        }
                    } else {
                        Swal.fire({
                            title: 'Indisponible',
                            text: 'Le vélo n\'est pas disponible.',
                            icon: 'error',
                            textColor: '#fff',
                            background: '#242A28',
                            iconColor: '#ff0000',
                            confirmButtonColor: '#22E49F', // Couleur du bouton de confirmation
                            confirmButtonText: 'OK', // Texte du bouton de confirmation
                            showCancelButton: false, // Ne pas afficher le bouton d'annulation
                            allowOutsideClick: false, // Empêcher de fermer l'alerte en cliquant à l'extérieur
                            timer: 3000
                        });
                        addToBucketButton.style.display = 'none'; // Cacher le bouton si le vélo n'est pas disponible
                    }
                }
            });

        });

        if (addToBucketButton) {
            addToBucketButton.addEventListener('click', function() {
                event.preventDefault();
                const veloId = this.getAttribute('data-id');
                const startDate = document.getElementById('start_date').value;
                const startTime = document.getElementById('start_time').value;
                const endDate = document.getElementById('end_date').value;
                const endTime = document.getElementById('end_time').value;

                const veloDetails = {
                    id: veloId,
                    modele: veloDetailsBis.modele,
                    prix: veloDetailsBis.prix_par_jour,
                    description: veloDetailsBis.description_velo,
                    img: veloDetailsBis.URL,
                    quantity: 1,
                    start_date: startDate,
                    start_time: startTime,
                    end_date: endDate,
                    end_time: endTime
                };

                let bucket = JSON.parse(localStorage.getItem('bucket')) || [];
                const existingItemIndex = bucket.findIndex(item => item.id === veloId && item.start_date === startDate && item.end_date === endDate);
                if (existingItemIndex > -1) {
                    bucket[existingItemIndex].quantity += 1;
                } else {
                    bucket.push(veloDetails);
                }

                localStorage.setItem('bucket', JSON.stringify(bucket));
                updateBucketCount();

                Swal.fire('Ajouté', 'Le vélo a été ajouté au panier.', 'success');
            });
        }
        // Check if time is between 08:00 and 17:00
        function isTimeInRange(time) {
            const timeParts = time.split(':');
            const hour = parseInt(timeParts[0], 10);
            const minute = parseInt(timeParts[1], 10);
            if (hour < 8 || (hour >= 17 && minute > 0)) {
                return false;
            }
            return true;
        }
        $(document).ready(function() {
        // Désactiver l'initialisation du datepicker
        $("#start_date, #end_date").datepicker("destroy");
        });


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