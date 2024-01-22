document.querySelectorAll('.contact-btn').forEach(button => {
    button.addEventListener('click', () => {
        document.getElementById('popup-contact').classList.add('open-modal');
    });
});

document.querySelector('.modal').addEventListener('click', event => {
    const modal = document.getElementById('popup-contact');
    if (event.target === modal) {
        modal.classList.remove('open-modal');
    }
});

document.addEventListener("wpcf7submit", event => {
    if (event.detail.status === 'mail_sent') {
        document.getElementById('popup-contact').classList.remove('open-modal');
    }
});