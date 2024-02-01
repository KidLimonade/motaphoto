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
    
    // A chaque modification effective du formulaire de filtrage / tri
    $('#filtre-tri-form').on('change', event => {
        
        // Comportement par défaut formulaire annulé
        event.preventDefault();
        
        // Récupération des paramètres depuis le formulaire
        const params = {
            
            // Paramètres WordPress / Ajax
            action: $('#filtre-tri-form').find('input[name=action').val(),
            nonce: $('#filtre-tri-form').find('input[name=nonce').val(),
            post_type: $('#filtre-tri-form').find('input[name=post_type').val(),
            
            // Paramètres utilisateur
            categorie: $('#filtre-categorie').val(),
            format: $('#filtre-format').val(),
            sort_order: $('#ordre-tri').val()
        };
        
        // Envoi requête POST
        fetch(motaphoto_js.ajax_url, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
                'Cache-Control': 'no-cache'
            },
            body: new URLSearchParams(params)
        })
        
        // Réception réponse serveur
        .then( response => {
            if (!response.ok) {
                throw new Error('Network response error.');
            }
            return response.json();
        })
        
        // Réception retour requête
        .then( data => {
            
            console.log(data);
            
            $('#zone-more').append(data.html);
            
            // body.posts.forEach( post => {
            //     document.getElementById('filtre-tri-result').insertAdjacentHTML('beforeend',
            //     '<div>' + post.post_title + '</div>');
            // });
        })
        
        .catch( error => {
            console.error('Problem with the fetch operation.', error);
        });
    });
});


/**
* Load more logic
*/
jQuery(document).ready( $ => {
    
    let current = 1;
    $('#load-more').on('click', () => {
        current++;
        $.ajax({
            type: 'POST',
            url: motaphoto_js.ajax_url,
            dataType: 'json',
            data: {
                action: 'request_more_photos',
                paged: current
            },
            success: (data) => {
                if (current >= data.max) {
                    $('#load-more').hide();
                }
                $('#zone-more').append(data.html);
            }
        });    
    });
});
