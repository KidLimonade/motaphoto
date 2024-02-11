/**
* Ouverture / fermeture de la popup madale de contact
* Utilisation du plugin Contact Form 7 (wpcf7)
*/

// Ouverture de la popup lors d'un clic sur un nouton contact
document.querySelectorAll('.contact-btn').forEach(button => {
    button.addEventListener('click', () => {
        document.getElementById('popup-contact').classList.add('open-modal');
    });
});

// Fermeture popup lors d'un clic extérieur à la fenêtre principale
document.querySelector('.modal').addEventListener('click', event => {
    const modal = document.getElementById('popup-contact');
    if (event.target === modal) {
        modal.classList.remove('open-modal');
    }
});

// Fermeture popup contact sur clic sur le bouton d'envoi...
// ... et si le formulaire est sans erreur ou vide
document.addEventListener('wpcf7submit', event => {
    if (event.detail.status === 'mail_sent') {
        document.getElementById('popup-contact').classList.remove('open-modal');
    }
});

/**
* Gestion du menu burger sur les mobiles 
*/
document.querySelector('.mobile-button-container').addEventListener('click', () => {
    const menu = document.querySelector('nav.menu-top-menu-container');
    menu.classList.toggle('expanded');
});

document.querySelectorAll('.menu-top-menu-container li').forEach( link => {
    link.addEventListener('click', () => {
        const menu = document.querySelector('nav.menu-top-menu-container');
        menu.classList.remove('expanded');        
    });
});

/**
* Accès via Ajax à des groupes de photos avec filtrage possible
* par catégorie et format, et tri par date croissant décroissant
*/
jQuery(document).ready( $ => {
    
    // Page courante
    let current_page = 1;
    
    /*
    A chaque modification effective du formulaire de filtrage/tri
    une requette Ajax est envoyée pour générer le liste des photos
    */
    $('#filtre-tri-form').on('change', event => {

        // Comportement par défaut formulaire annulé
        event.preventDefault();
        
        // Première reqête
        current_page = 1;

        // Récupération categorie et si non définie alors toutes
        let categorie = $('#filtre-categorie input[name="categorie"].selected').val();
        if (categorie == null) { categorie = '*'; }

        // Récupération format et si non défini alors tous
        let format = $('#filtre-format input[name="format"].selected').val();
        if (format == null) { format = '*'; }
        
        // Récupération et vérification-validation ordre de tri
        let order = $('#select-order input[name="order"].selected').val();
        if (order !== 'DESC' && order !== 'ASC') {
            order = 'DESC';
        }

        console.log('-- Trace debug requête initiale --');
        console.log(categorie);
        console.log(format);
        console.log(order);

        // Récupération des paramètres depuis le formulaire
        const params = {
            
            // Paramètres WordPress / Ajax
            action: $('#filtre-tri-form').find('input[name=action').val(),
            nonce: $('#filtre-tri-form').find('input[name=nonce').val(),
            post_type: $('#filtre-tri-form').find('input[name=post_type').val(),
            
            // Paramètres utilisateur filtrage / tri
            // categorie: $('#filtre-categorie').val(),
            // format: $('#filtre-format').val(),
//            ordre_tri: $('#ordre-tri').val(),
            categorie: categorie,
            format: format,
            ordre_tri: order,
            
            // Page 1
            paged: current_page
        };
        
        // Envoi requête POST via url Ajax (wp_localize_script)
        fetch(motaphoto_js.ajax_url, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
                'Cache-Control': 'no-cache'
            },
            body: new URLSearchParams(params)
        })
        
        // Réception réponse requête
        .then( response => {
            if ( !response.ok ) {
                throw new Error('Network response error.');
            }
            return response.json();
        })
        
        // Réception retour data
        .then( data => {
            
            // Affiche ou cache le bouton "Charger plus"
            if (current_page < data.max_pages) {
                $('#load-more-btn').show();
            } else {
                $('#load-more-btn').hide();
            }
            
            // Vide puis réinjecte l'espace photos
            $('#photos-container').empty().append(data.html);
        })
        
        // Gestion des exceptions
        .catch( error => {
            console.error('Problem fetching photo images.', error);
        });
    });
    
    /*
    Ub bouton "Charger plus" se trouve au bas de la liste des photos
    quand des photos restent à présenter et permet de charger la suite
    */
    $('#load-more-btn').on('click', () => {
        
        // Requête complémentaire
        current_page++;

        // Récupération categorie et si non définie alors toutes
        let categorie = $('#filtre-categorie input[name="categorie"].selected').val();
        if (categorie == null) { categorie = '*'; }

        // Récupération format et si non défini alors tous
        let format = $('#filtre-format input[name="format"].selected').val();
        if (format == null) { format = '*'; }
        
        // Récupération et vérification-validation ordre de tri
        let order = $('#select-order input[name="order"].selected').val();
        if (order !== 'DESC' && order !== 'ASC') {
            order = 'DESC';
        }

        console.log('-- Trace debug requête complémentaire --');
        console.log(categorie);
        console.log(format);
        console.log(order);

        $.ajax({
            type: 'POST',
            url: motaphoto_js.ajax_url,
            dataType: 'json',
            
            data: {
                
                // Paramètres depuis le formulaire
                action: $('#filtre-tri-form').find('input[name=action').val(),
                nonce: $('#filtre-tri-form').find('input[name=nonce').val(),
                post_type: $('#filtre-tri-form').find('input[name=post_type').val(),
                // categorie: $('#filtre-categorie').val(),
                // format: $('#filtre-format').val(),
                // ordre_tri: $('#ordre-tri').val(),
                categorie: categorie,
                format: format,
                ordre_tri: order,    
                
                // Page courante + 1
                paged: current_page
            },
            
            // Réception retour data
            success: (data) => {
                
                // Bouton disparaît si plus de photos
                if (current_page >= data.max_pages) {
                    $('#load-more-btn').hide();
                }
                
                // Injecte les nouvelles photos
                $('#photos-container').append(data.html);
            },
        });    
    });
});

/**
 * Gestion des fenêtres dropdown de filtrage et de
 * tri des photos.
*/

// Alterne ouverture et fermeture de la dropdown
function dropdownToggle(dropdown) {

    const default_label = dropdown.querySelector('.default-label');
    const selected_label = dropdown.querySelector('.selected-label');
    const dropdown_list = dropdown.querySelector('.dropdown-list');

    dropdown.classList.toggle('open');
    
    // Dropdown liste ouverte
    if (dropdown.classList.contains('open')) {

        // Fait apparaître la dropdown liste
        dropdown_list.classList.remove('collapsed');

        // On affiche le label par défaut et on cache l'éventuel label courant
        default_label.classList.remove('hidden');
        selected_label.classList.add('hidden');
    } else {

        // Cache la dropdown liste
        dropdown_list.classList.add('collapsed');

        // On affiche le choix utilisateur ou le titre par défaut
        // &nbsp; (hexa: 0xA0) signifie "tous" ou "Toutes"
        if (selected_label.innerText !== '' && selected_label.innerText != '\xa0') {
            default_label.classList.add('hidden');
            selected_label.classList.remove('hidden');
        } else {
            default_label.classList.remove('hidden');
            selected_label.classList.add('hidden');
        }
    }
}

// Tous les dropdown boutons alternent dropdown ouverte / fermée
document.querySelectorAll('.dropdown > .dropdown-button').forEach( button => {

    button.addEventListener('click', e => {

        console.log('-------------------', e.target);
        // La dropdown est mère du bouton
        const dropdown = e.target.parentNode;
        dropdownToggle(dropdown);
    });
});

// Un clic sur une option affecte le titre du bouton
document.querySelectorAll('.dropdown').forEach(dropdown => {

    dropdown.querySelectorAll('.option').forEach(option => {

        option.addEventListener('click', e => {

            console.log('option:', option);
            console.log('option id:', option.id);

            // Marquer checked l'option sélectionnée
            dropdown.querySelectorAll('input[type="radio"]').forEach(input => {
                if (input.id === option.id) {
                    input.classList.add('selected');
                } else {
                    input.classList.remove('selected');
                }
            });
            
            // Recherche du libellé de l'option choisie dans le label
            const lab = dropdown.querySelector(`label[for="${option.id}"]`);
            console.log(lab)
            console.log(lab.innerText);

            // Mise à jour du label du bouton avec l'option choisie
            dropdown.querySelector('.selected-label').innerText = lab.innerText;

            // Fermeture de la dropdown
            dropdownToggle(dropdown);
        });
    });
});
