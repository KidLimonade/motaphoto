/**
* Ouverture / fermeture de la lightbox modale de
* présentation et navigation dans la phototèque
*/

// Ouverture de la lightbox sur clic bouton en haut à droite d'une vignette
document.querySelectorAll('.lightbox-btn').forEach(button => {
    button.addEventListener('click', () => {
        document.querySelector('.lightbox').classList.add('open-lightbox');
    });
});

// Fermeture de la lightbox sur clic croix en haut à droite de la lightbox
document.querySelector('.lightbox__close').addEventListener('click', () => {
    document.querySelector('.lightbox').classList.remove('open-lightbox');
    console.log('close');
});
