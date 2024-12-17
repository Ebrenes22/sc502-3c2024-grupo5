document.querySelector("form").addEventListener("submit", function(event) {
    event.preventDefault(); // Prevenir envío del formulario

    const formData = new FormData(this);

    fetch('register.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.error) {
            alert("Error: " + data.error);
        } else if (data.message) {
            alert(data.message);
        }
    })
    .catch(error => {
        alert("Hubo un problema con la solicitud.");
    });
});
