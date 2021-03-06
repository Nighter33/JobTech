document.addEventListener('DOMContentLoaded', () => {
    const persons = document.getElementsByClassName('contact-line');

    if (persons) {
        for (let i = 0; i < persons.length; i += 1) {
            persons[i].addEventListener('click', () => {
                const { user } = persons[i].dataset;
                persons[i].innerHTML += '<span class="small">chargement ...</span>';
                const url = `/messagerie/reset/${user}`;
                fetch(url)
                    .then(response => response.json())
                    .then((json) => {
                        window.location.href = `/messagerie/admin/${user}`;
                    });
            });
        }
    }
});
