document.querySelectorAll('.contact-btn').forEach(button => {
    button.addEventListener('click', () => {
        document.getElementById('myModal').classList.add('open-modal');
    });
});

document.querySelector('.modal').addEventListener('click', event => {
    const modal = document.getElementById('myModal');
    if (event.target === modal) {
        modal.classList.remove('open-modal');
    }
});

document.addEventListener("wpcf7submit", event => {
    if (event.detail.status === 'mail_sent') {
        document.getElementById('myModal').classList.remove('open-modal');
    }
});