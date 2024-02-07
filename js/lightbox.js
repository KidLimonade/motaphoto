/**
* Affiche la photo relative à un post de la photothèque
* en plein écran, avec la possibilité de naviguer en avant
* ou en arrière parmi l'ensemble des photos du site MotaPhoto
*/

function ShowInLightbox(button) {

    // Le post photo dont l'image doit être affichée
    const postid = button.dataset.postid;
    if ( !postid ) { return; }
    
    // Paramètres de la requête
    const params = {
        action: 'request_photo_by_ID',
        post_type: 'photo',
        post_id: postid
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
    
    // Réception des data en réponse à la requête
    .then( data => {

        // Préparation de la lightbox zone image
        const photo = document.createElement('img');
        photo.src = data.url_image;
        const container_image = document.querySelector('.lightbox__container .image');

        // Vide le conteneur image de la lightbox puis ajoute l'image
        container_image.innerHTML = '';
        container_image.appendChild(photo);

        // Alimentation de la lightbox label "reference"
        document.querySelector('.lightbox__container .reference').innerHTML = data.reference;

        // Alimentation de la lightbox label "categorie"
        document.querySelector('.lightbox__container .categorie').innerHTML = data.categorie;

        // Préparation de la lightbox bouton "Précédent"
        const prev_id = data.prev_id;
        const prev_button = document.getElementById('lightbox__prev');
        if (prev_id !== null) {
            prev_button.style.display = "unset";
            prev_button.dataset.postid = prev_id;
        } else {

            // Pas de précédent... pas d'affichage du bouton
            prev_button.style.display = "none";
            delete prev_button.dataset.postid;
        }
        
        // Préparation de la lightbox bouton "Suivant" 
        const next_id = data.next_id;
        const next_button = document.getElementById('lightbox__next');
        if (next_id !== null) {
            next_button.style.display = "unset";
            next_button.dataset.postid = next_id;
        } else {

            // Pas de suivant... pas de bouton !
            next_button.style.display = "none";
            delete next_button.dataset.postid;
        }
    })
    
    // Gestion des exceptions
    .catch( error => {
        console.error('Problem fetching photo image.', error);
    });
    
    // Si la lightbox n'est pas à l'écran on la fait apparaître
    document.querySelector('.lightbox').classList.add('open-lightbox');
}

/**
* Ferme la lightbox sur une clic de la croix de fermeture
* placée en haut à droite de la fenêtre plein écran, et
* reinitialise le conteneur et divers éléments de la lightbox 
*/

document.addEventListener("DOMContentLoaded", () => {
    document.querySelector('.lightbox__close').addEventListener('click', () => {
        document.querySelector('.lightbox__container .image').innerHTML = '';
        document.querySelector('.lightbox__container .reference').innerHTML = '';
        document.querySelector('.lightbox__container .categorie').innerHTML = '';
        const prev_button = document.getElementById('lightbox__prev');
        delete prev_button.dataset.postid;
        const next_button = document.getElementById('lightbox__next');
        delete next_button.dataset.postid;
        document.querySelector('.lightbox').classList.remove('open-lightbox');
    });    
});
