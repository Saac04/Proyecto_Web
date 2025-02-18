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
    alert(data.success || data.error);
});
