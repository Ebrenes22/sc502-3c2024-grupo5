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
            { name: "Nombre Completo", value: document.getElementById('fullname').value },
            { name: "Correo Electrónico", value: document.getElementById('email').value },
            { name: "Edad", value: document.getElementById('age').value },
            { name: "Peso", value: document.getElementById('weight').value },
            { name: "Altura", value: document.getElementById('height').value },
            { name: "Género", value: document.getElementById('gender').value },
            { name: "Meta Calorías", value: document.getElementById('daily_calorie_goal').value },
            { name: "Contraseña", value: document.getElementById('password').value },
            { name: "Confirmar Contraseña", value: document.getElementById('confirm_password').value },
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
        fields.forEach(field => formData.append(field.name.toLowerCase().replace(/ /g, "_"), field.value));

        try {
            // Enviar datos al servidor
            const response = await fetch('/backend/register.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                body: formData.toString(),
            });

            const result = await response.json();

            if (response.ok) {
                showMessage('success', result.message);
                setTimeout(() => {
                    registerError.innerHTML = "";
                    window.location.href = "/frontend/pages/login.php";
                }, 3000);
            } else {
                showMessage('danger', result.error);
            }
        } catch (error) {
            showMessage('danger', "Hubo un problema con el registro. Intenta nuevamente más tarde.");
        }
    });
});
