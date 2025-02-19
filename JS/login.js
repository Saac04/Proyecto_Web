document.getElementById("loginForm").addEventListener("submit", async function (e) {
    e.preventDefault();

    const nombre_usuario = document.getElementById("username").value;
    const contraseña = document.getElementById("password").value;

    const response = await fetch("API/login.php", {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify({ nombre_usuario, contraseña })
    });

    const data = await response.json();
    const messageElement = document.getElementById("message");

    if (data.success) {
        // Mostrar mensaje de éxito
        messageElement.style.color = "green";
        messageElement.textContent = data.success;
    } else {
        // Mostrar mensaje de error
        messageElement.style.color = "red";
        messageElement.textContent = data.error;
    }
});
