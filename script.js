

let gameForm = document.querySelector('form#gameForm');

gameForm.addEventListener('input', function(event) {
    event.preventDefault();

    let formData = new FormData(this);
    console.log(formData);
    let playerValue = formData.get('tic');
    let tic = document.querySelector(`input[value='${playerValue}']`);
    tic.classList.add('tic');
    tic.setAttribute('disabled', true);

    fetch('index.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.text())
    .then(data => {
        console.log(data)
        let toe = document.querySelector(`input[value='${data}']`);
        toe.classList.add('toe');
        toe.setAttribute('disabled', true);
    })
    .catch(error => console.error("Errore:", error));
});