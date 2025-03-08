document.addEventListener("DOMContentLoaded", function () {
    const anyadir = document.getElementById("btn-anyadir-usuario");
    const icono = document.getElementById("iconoAnyadir");
    
    anyadir.addEventListener("mouseenter", function () {
        if (icono.src.includes("anyadirUsuario.png")) {
            icono.src = "images/anyadirUsuarioHover.png";
        }
    });

    anyadir.addEventListener("mouseleave", function () {
        if (icono.src.includes("anyadirUsuarioHover.png")) {
            icono.src = "images/anyadirUsuario.png";
        }
    });
});
