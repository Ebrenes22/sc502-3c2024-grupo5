document.addEventListener('DOMContentLoaded', function () {
    const registerForm = document.getElementById('registerForm'); // ID del formulario
    const registerError = document.getElementById('register-error'); // Área para mostrar errores

    // Función para mostrar mensajes
    function showMessage(type, message) {
        registerError.innerHTML = `
            <div class="alert alert-${type} fade show" role="alert">
                <strong>${type === 'danger' ? 'Error' : 'Éxito'}:</strong> ${message}
            </div>`;
    }

    // Función para validar campos vacíos
    function validateEmptyFields(fields) {
        for (const field of fields) {
            if (!field.value.trim()) {
                return `El campo ${field.name} es obligatorio.`;
            }
        }
        return null;
    }

    registerForm.addEventListener('submit', async function (e) {
        e.preventDefault();

        // Obtener valores de los campos
        const fields = [
            { name: "fullname", value: document.getElementById('fullname').value },
            { name: "email", value: document.getElementById('email').value },
            { name: "age", value: document.getElementById('age').value },
            { name: "weight", value: document.getElementById('weight').value },
            { name: "height", value: document.getElementById('height').value },
            { name: "gender", value: document.getElementById('gender').value },
            { name: "daily_calorie_goal", value: document.getElementById('daily_calorie_goal').value },
            { name: "password", value: document.getElementById('password').value },
            { name: "confirm_password", value: document.getElementById('confirm_password').value },
        ];
        

        const password = document.getElementById('password').value;
        const confirmPassword = document.getElementById('confirm_password').value;

        // Validar campos vacíos
        const emptyError = validateEmptyFields(fields);
        if (emptyError) {
            showMessage('danger', emptyError);
            return;
        }

        // Validar si las contraseñas coinciden
        if (password !== confirmPassword) {
            showMessage('danger', "Las contraseñas no coinciden.");
            return;
        }

        // Preparar datos del formulario
        const formData = new URLSearchParams();
        fields.forEach(field => {
            formData.append(field.name, field.value); // Añadir los campos al formData
        });

        try {
            // Enviar datos al servidor
            const response = await fetch('/backend/register.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                body: formData.toString(), // Enviar los datos correctamente formateados
            });

            const result = await response.json();

            if (result.message === "Registro exitoso.") {
                showMessage('success', result.message);
                setTimeout(() => {
                    registerError.innerHTML = "";
                    window.location.href = "/frontend/pages/login.php"; // Redirigir al login
                }, 4000); // Esperar 2 segundos antes de redirigir
            } else {
                showMessage('danger', result.message); // Mostrar error si no fue exitoso
            }
        } catch (error) {
            showMessage('danger', "Hubo un problema al enviar los datos. Intente nuevamente.");
        }
    });
});
