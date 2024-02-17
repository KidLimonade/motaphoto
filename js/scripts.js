/**
* Ouverture / fermeture de la popup modale de contact.
* Utilisation du plugin Contact Form 7 (wpcf7) pour le
* formulaire de saisie des informations.
*/

// Ouverture de la popup lors d'un clic sur un bouton contact
document.querySelectorAll(".contact-button").forEach( button => {
    button.addEventListener( 'click', () => {
        document.getElementById("popup-contact").classList.add("open-modal");
    });
});

// Fermeture de la popup lors d'un clic extérieur au formulaire de saisie
document.querySelector(".modal").addEventListener( 'click', event => {
    const formulaire = document.getElementById("popup-contact");
    if (event.target === formulaire) {
        formulaire.classList.remove("open-modal");
    }
});

// Fermeture de la popup si clic sur le bouton d'envoi du formulaire 
// wpcf7, et qu'il n'y a aucune erreur ou champ obligatoire vide
document.addEventListener( 'wpcf7submit', event => {
    if (event.detail.status === 'mail_sent') {
        document.getElementById("popup-contact").classList.remove("open-modal");
    }
});

/**
* Affiche ou cache le header menu de navigation sur appareil mobile
*/

// Au clic sur l'icone burger (croix) le menu de navigation apparaît (disparaît)
document.querySelector(".burger-button").addEventListener( 'click', () => {
    document.querySelector(".custom-nav-menu-container").classList.toggle("expanded");
});

// Au clic sur un item du menu de navigation le menu se referme
document.querySelectorAll(".custom-nav-menu-container li").forEach( link => {
    link.addEventListener( 'click', () => {
        document.querySelector(".custom-nav-menu-container").classList.remove("expanded");        
    });
});

/**
 * Montre une vignette de la photo précédente ou suivante de
 * la phototèque au survol d'un élément classé "detectable"
 */

// Affiche la vignette en fonction du lien détecté
document.querySelectorAll(".detectable").forEach(  detectable => {

    // Au survol affiche la vignette adéquate
    detectable.addEventListener("mouseover", direction => {

        // Détermine la vignette à afficher
        if (direction.target.parentNode.rel === 'prev') {
            document.querySelector(".photo-action-navigate .featured .previous").classList.add("displayed");
        } else if (direction.target.parentNode.rel === 'next') {
            document.querySelector(".photo-action-navigate .featured .next").classList.add("displayed");
        }
    });

    // En fin de survol efface toute vignette affichée... ou pas
    detectable.addEventListener( 'mouseout', () => {
        const featured = document.querySelector(".photo-action-navigate .featured");
        featured.querySelector(".previous").classList.remove("displayed");
        featured.querySelector(".next").classList.remove("displayed");
    });
});

/**
* Accès via Ajax à des groupes de photos avec filtrage possible
* par catégorie et format, et tri par date croissant décroissant
*/
jQuery( $ => {
    
    // Page courante
    let currentPage = 1;
    
    /*
    À chaque modification effective du formulaire de filtrage/tri une requête
    Ajax est envoyée au serveur pour générer une nouvelle liste des photos
    */
    $("#filtre-tri-form").on( 'change', event => {
        
        // Comportement par défaut du formulaire annulé
        event.preventDefault();
        
        // Requète initiale
        currentPage = 1;

        // Récupération categorie et si non définie alors toutes
        let categorie = $('#filtre-categorie input[name="categorie"].selected').val();
        if (categorie == null) { categorie = "*"; }

        // Récupération format et si non défini alors tous
        let format = $('#filtre-format input[name="format"].selected').val();
        if (format == null) { format = "*"; }
        
        // Récupération et vérification-validation ordre de tri
        let order = $('#select-order input[name="order"].selected').val();
        if (order !== "DESC" && order !== "ASC") {
            order = "DESC";
        }

        // Récupération des paramètres depuis le formulaire
        const params = {
            
            // Paramètres WordPress / Ajax
            action: $("#filtre-tri-form").find('input[name=action]').val(),
            nonce: $("#filtre-tri-form").find('input[name=nonce]').val(),
            post_type: $("#filtre-tri-form").find('input[name=post_type]').val(),
            
            // Paramètres utilisateur
            categorie: categorie,
            format: format,
            ordre_tri: order,
            
            // Page 1
            paged: currentPage
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
        
        // Réception réponse serveur
        .then( response => {
            if ( !response.ok ) {
                throw new Error('Network response error.');
            }
            return response.json();
        })
        
        // Réception data
        .then( data => {
            
            // Affiche ou cache le bouton "Charger plus"
            if (currentPage < data.max_pages) {
                $("#load-more-btn").show();
            } else {
                $("#load-more-btn").hide();
            }
            
            // Vide puis réinjecte le nouveau portfolio
            $("#portfolio").empty().append(data.html);
        })
        
        // Gestion des exceptions
        .catch( error => {
            console.error('Problem fetching photo images.', error);
        });
    });
    
    /*
    Au clic sur le bouton 'Charger plus' au bas des photos une requête Ajax est
    envoyée pour réclamer un bloc complémentaire de photos à afficher en sus
    */
    $("#load-more-btn").on( 'click', () => {
        
        // Requête complémentaire
        currentPage += 1;

        // Récupération categorie et si non définie alors toutes
        let categorie = $('#filtre-categorie input[name="categorie"].selected').val();
        if (categorie == null) { categorie = '*'; }

        // Récupération format et si non défini alors tous
        let format = $('#filtre-format input[name="format"].selected').val();
        if (format == null) { format = '*'; }
        
        // Récupération et vérification-validation ordre de tri
        let order = $('#select-order input[name="order"].selected').val();
        if (order !== "DESC" && order !== "ASC") {
            order = "DESC";
        }

        $.ajax({
            type: 'POST',
            url: motaphoto_js.ajax_url,
            dataType: 'json',
            
            data: {
                
                // Paramètres WordPress / Ajax
                action: $("#filtre-tri-form").find('input[name=action]').val(),
                nonce: $("#filtre-tri-form").find('input[name=nonce]').val(),
                post_type: $("#filtre-tri-form").find('input[name=post_type]').val(),

                // Paramètres utilisateur
                categorie: categorie,
                format: format,
                ordre_tri: order,    
                
                // Page courante + 1
                paged: currentPage
            },
            
            // Réception retour data
            success: (data) => {
                
                // Affiche ou cache le bouton "Charger plus"
                if (currentPage >= data.max_pages) {
                    $("#load-more-btn").hide();
                }
                
                // Injecte les nouvelles photos
                $("#portfolio").append(data.html);
            },
        });
    });
});
