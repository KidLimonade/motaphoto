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
 * Ajax request photos en JavaScript
 */
document.addEventListener('DOMContentLoaded', () => {

    document.getElementById('ajax-call').addEventListener('click', () => {

        let formData = new FormData();
        formData.append('action', 'request_first_photos');
    
        fetch(motaphoto_js.ajax_url, {
            method: 'post',
            body: formData
        }).then( response => {
            if (!response.ok) {
                throw new Error('Network response error.');
            }
            return response.json();
        }).then( data => {
            data.posts.forEach( post => {
                document.getElementById('ajax-return').insertAdjacentHTML('beforeend', '<div>' + post.post_title + '</div>');
            });
        }).catch( error => {
            console.error('There was a problem with the fetch operation', error);
        });    
    });
});

/**
 * Load more logic
 */
jQuery( $ => {
    $(document).ready( () => {
        let current = 1;
        $('#load-more').on('click', () => {
            current++;
            $.ajax({
                type: 'POST',
                url: '/wp-admin/admin-ajax.php',
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
});

/**
 * Ajax request photos en JQuery
 */

jQuery( $ => {

    $(document).ready( () => {

        $('.ajax-load').submit( e => {
            e.preventDefault();
            console.log($('.ajax-load'));
            const ajaxurl = $('.ajax-load').attr('action');
            const params = {
                action: $('.ajax-load').find('input[name=action').val(),
                nonce: $('.ajax-load').find('input[name=nonce').val(),
                post_type: $('.ajax-load').find('input[name=post_type').val(),                
                format: $('.ajax-load').find('input[name=format').val()              
            }
            fetch(ajaxurl, {
                method: 'post',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                    'Cache-Control': 'no-cache'
                },
                body: new URLSearchParams(params)
            })
            .then( response => {
                if (!response.ok) {
                    throw new Error('Network response error.');
                }
                return response.json();
            })
            .then( body => {
                console.log(body);
                $('#ajax-photos').html(body.data);
                body.posts.forEach( post => {
                    document.getElementById('ajax-photos').insertAdjacentHTML('beforeend', '<div>' + post.post_title + '</div>');
                });
            })
            .catch( error => {
                console.error('There was a problem with the fetch operation', error);
            });
        });
    });
});