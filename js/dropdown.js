/**
 * Gestion des dropdown menus
*/

// Alterne l'état ouvert vs fermé d'un dropdown
function dropdownToggle(dropdown) {

    dropdown.classList.toggle('open');
    
    if (dropdown.classList.contains('open')) {

        /**
         * Le dropdown s'ouvre
         */

        dropdown.querySelector('.dropdown-list').classList.remove('collapsed');

        // Le titre du bouton prend sa valeur par défaut
        dropdown.querySelector('.default-label').classList.remove('hidden');

        // Le choix courant éventuel est caché
        dropdown.querySelector('.selected-label').classList.add('hidden');
    } else {

        /**
         * Le dropdown se referme
         */

        dropdown.querySelector('.dropdown-list').classList.add('collapsed');

        // Récupération du nouveau choix courant
        const selected_label = dropdown.querySelector('.selected-label');

        if (selected_label.innerText !== '' && selected_label.innerText !== '\xa0') {

            // Remplace le titre du bouton par le label associé au choix
            dropdown.querySelector('.default-label').classList.add('hidden');
            selected_label.classList.remove('hidden');
        } else {

            // Le titre du bouton prend sa valeur par défaut
            dropdown.querySelector('.default-label').classList.remove('hidden');
            selected_label.classList.add('hidden');
        }
    }
}

// Au clic sur un dropdown boutons on alterne l'état ouvert vs fermé du dropdown
document.querySelectorAll('.dropdown > .dropdown-button').forEach( button => {
    button.addEventListener('click', () => {

        // Le dropdown est père du bouton
        dropdownToggle(event.target.parentNode);
    });
});

// Au clic sur un item d'un dropdown on gère le dropdown en fonction du choix utilisateur
document.querySelectorAll('.dropdown').forEach(dropdown => {
    dropdown.querySelectorAll('.option').forEach(option => {
        option.addEventListener('click', () => {

            // Marque 'selected' l'option choisie
            dropdown.querySelectorAll('input[type="radio"]').forEach(input => {
                if (input.id === option.id) {
                    input.classList.add('selected');
                } else {
                    input.classList.remove('selected');
                }
            });
            
            // Recherche du libellé de l'option choisie dans le label correspondant
            const label_option = dropdown.querySelector(`label[for="${option.id}"]`);

            // Mise à jour du label sélectionné avec le label de l'option choisie
            dropdown.querySelector('.selected-label').innerText = label_option.innerText;

            // Fermeture de la dropdown
            dropdownToggle(dropdown);
        });
    });
});
