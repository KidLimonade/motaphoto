/**
* Ouverture de la lightbox modale de présentation
* d'une photo unique, et navigation dans la phototèque
* vers l'arriàre ou vers l'avant
*/

function bip(button) {
    console.log('Clic sur bouton lightbox');
    console.log(button);
    const postid = button.dataset.postid;
    console.log(postid);

    const params = {
            
        // Paramètres WordPress / Ajax
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
    
    // Réception retour data
    .then( data => {
        console.log(data.url_image);
        console.log(data.reference);
        console.log(data.categorie);
        const photo = document.createElement('img');
        photo.src = data.url_image;
        photo.alt = data.titre;
        const container = document.querySelector('.lightbox__container');
        container.innerHTML = "";
        container.appendChild(photo);
    })
    
    // Gestion des exceptions
    .catch( error => {
        console.error('Problem fetching photo images.', error);
    });

    document.querySelector('.lightbox').classList.add('open-lightbox');
}

// Ouverture de la lightbox sur clic bouton en haut à droite d'une vignette
// document.querySelectorAll('.lightbox-btn').forEach(button => {
//     button.addEventListener('click', (event) => {

//         const params = {
            
//             // Paramètres WordPress / Ajax
//             action: 'request_photo_by_ID',
//             post_type: 'photo',
//             post_id: event.target.id
//         };
        
//         // Envoi requête POST via url Ajax (wp_localize_script)
//         fetch(motaphoto_js.ajax_url, {
//             method: 'POST',
//             headers: {
//                 'Content-Type': 'application/x-www-form-urlencoded',
//                 'Cache-Control': 'no-cache'
//             },
//             body: new URLSearchParams(params)
//         })
        
//         // Réception réponse requête
//         .then( response => {
//             if ( !response.ok ) {
//                 throw new Error('Network response error.');
//             }
//             return response.json();
//         })
        
//         // Réception retour data
//         .then( data => {
//             console.log(data.url_image);
//             console.log(data.reference);
//             console.log(data.categorie);
//         })
        
//         // Gestion des exceptions
//         .catch( error => {
//             console.error('Problem fetching photo images.', error);
//         });

//         document.querySelector('.lightbox').classList.add('open-lightbox');
//     });
// });
