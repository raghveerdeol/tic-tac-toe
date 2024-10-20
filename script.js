

let gameForm = document.querySelector('form#gameForm');

gameForm.addEventListener('input', function(event) {
    event.preventDefault();

    let formData = new FormData(this);
    let playerValue = formData.get('tic');
    let tic = document.querySelector(`input[value='${playerValue}']`);

    tic.classList.add('tic');
    tic.setAttribute('disabled', true);

    fetch('index.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        console.log(data.computerMove, data.winner)
        if (data.winner) {
            let gameOver = document.querySelector('h2#gameOver');
            gameOver.innerHTML = data.winner;
        } else if (data.computerMove) {
            let toe = document.querySelector(`input[value='${data.computerMove}']`);
            toe.classList.add('toe');
            toe.setAttribute('disabled', true);
        }
    })
    .catch(error => console.error("Errore:", error));
});