

let playerChoice = document.querySelector('form#gameForm');

playerChoice.addEventListener('input', function(event) {
    event.preventDefault();

    let formData = new FormData(this);
    console.log(formData);
    let playerValue = formData.get('tic');
    document.querySelector(`input[value='${playerValue}']`).setAttribute('disabled', true);

    fetch('index.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.text())
    .then(data => {
        console.log(data)
        document.querySelector(`input[value='${data}']`).setAttribute('disabled', true);
    })
    .catch(error => console.error("Errore:", error));
});