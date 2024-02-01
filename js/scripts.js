/**
* Ouverture / fermeture de la popup madale de contact
* Utilisation du plugin Contact Form 7 (wpcf7)
*/
document.addEventListener('DOMContentLoaded', () => {
    
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
    document.addEventListener("wpcf7submit", event => {
        if (event.detail.status === 'mail_sent') {
            document.getElementById('popup-contact').classList.remove('open-modal');
        }
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

        current_page = 1;
        
        // Récupération des paramètres depuis le formulaire
        const params = {
            
            // Paramètres WordPress / Ajax
            action: $('#filtre-tri-form').find('input[name=action').val(),
            nonce: $('#filtre-tri-form').find('input[name=nonce').val(),
            post_type: $('#filtre-tri-form').find('input[name=post_type').val(),
            
            // Paramètres utilisateur
            categorie: $('#filtre-categorie').val(),
            format: $('#filtre-format').val(),
            ordre_tri: $('#ordre-tri').val(),

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
            $('#filtre-tri-result').empty().append(data.html);
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
        
        current_page++;
        
        $.ajax({
            type: 'POST',
            url: motaphoto_js.ajax_url,
            dataType: 'json',

            data: {

                // Paramètres depuis le formulaire
                action: $('#filtre-tri-form').find('input[name=action').val(),
                nonce: $('#filtre-tri-form').find('input[name=nonce').val(),
                post_type: $('#filtre-tri-form').find('input[name=post_type').val(),
                categorie: $('#filtre-categorie').val(),
                format: $('#filtre-format').val(),
                ordre_tri: $('#ordre-tri').val(),

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
                $('#filtre-tri-result').append(data.html);
            },
        });    
    });
});
