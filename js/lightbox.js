/**
* Affiche la photo relative à un post de la photothèque
* en plein écran, avec la possibilité de naviguer en avant
* ou en arrière parmi l'ensemble des photos du site MotaPhoto.
*/

function ShowInLightbox(button) {

    // Le post photo dont l'image doit être affichée
    const postID = button.dataset.postid;
    if ( !postID ) { return; }
    
    // Paramètres de la requête
    const params = {
        action: 'request_photo_by_ID',
        post_type: 'photo',
        post_id: postID
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
        const containerImage = document.querySelector(".lightbox_container .image");

        // Vide le conteneur image de la lightbox puis ajoute l'image
        containerImage.innerHTML = '';
        containerImage.appendChild(photo);

        // Alimentation de la lightbox label "reference"
        document.querySelector(".lightbox_container .reference").innerHTML = data.reference;

        // Alimentation de la lightbox label "categorie"
        document.querySelector(".lightbox_container .categorie").innerHTML = data.categorie;

        // Préparation de la lightbox bouton "Précédent"
        const prevID = data.prev_id;
        const prevButton = document.getElementById("lightbox_prev");
        if (prevID !== null) {
            prevButton.style.display = "unset";
            prevButton.dataset.postid = prevID;
        } else {

            // Pas de précédent... pas d'affichage du bouton
            prevButton.style.display = "none";
            delete prevButton.dataset.postid;
        }
        
        // Préparation de la lightbox bouton "Suivant" 
        const nextID = data.next_id;
        const nextButton = document.getElementById("lightbox_next");
        if (nextID !== null) {
            nextButton.style.display = "unset";
            nextButton.dataset.postid = nextID;
        } else {

            // Pas de suivant... pas de bouton !
            nextButton.style.display = "none";
            delete nextButton.dataset.postid;
        }
    })
    
    // Gestion des exceptions
    .catch( error => {
        console.error('Problem fetching photo image.', error);
    });
    
    // Si la lightbox n'est pas à l'écran on la fait apparaître
    document.querySelector(".lightbox").classList.add("open");
}

/**
* Ferme la lightbox sur une clic de la croix de fermeture
* placée en haut à droite de la fenêtre plein écran, et
* reinitialise le conteneur et divers éléments de la lightbox 
*/
document.querySelector(".lightbox_close").addEventListener( 'click', () => {
    document.querySelector(".lightbox_container .image").innerHTML = "";
    document.querySelector(".lightbox_container .reference").innerHTML = "";
    document.querySelector(".lightbox_container .categorie").innerHTML = "";
    const prevButton = document.getElementById("lightbox_prev");
    delete prevButton.dataset.postid;
    const nextButton = document.getElementById("lightbox_next");
    delete nextButton.dataset.postid;
    document.querySelector(".lightbox").classList.remove("open");
});    
