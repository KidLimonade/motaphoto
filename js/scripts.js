/**
 * Open-Close the modal popup contact form
 */

// Open popup contact form on click on all contact buttons
document.querySelectorAll('.contact-btn').forEach(button => {
    button.addEventListener('click', () => {
        document.getElementById('popup-contact').classList.add('open-modal');
    });
});

// Close popup contact form on click outside the form
document.querySelector('.modal').addEventListener('click', event => {
    const modal = document.getElementById('popup-contact');
    if (event.target === modal) {
        modal.classList.remove('open-modal');
    }
});

// Close popup contact form on click on form submit button if no error
document.addEventListener("wpcf7submit", event => {
    if (event.detail.status === 'mail_sent') {
        document.getElementById('popup-contact').classList.remove('open-modal');
    }
});

/**
 * Request all photos
 */
document.addEventListener('DOMContentLoaded', (event) => {

    console.log(event);
    
    let formData = new FormData();
    formData.append('action', 'request_photos');

    fetch(motaphoto_js.ajax_url, {
        method: 'POST',
        body: formData
    }).then( response => {
        if (!response.ok) {
            throw new Error('Network response error.');
        }
        return response.json();
    }).then( data => {
        data.posts.forEach( post => {
            console.log(post.post_title);
        });
    }).catch( error => {
        console.error('There was a problem with the fetch operation', error)
    });
});