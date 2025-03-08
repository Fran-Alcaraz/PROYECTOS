document.addEventListener("DOMContentLoaded", function () {
    const anyadir = document.getElementById("btn-anyadir");
    const icono = document.getElementById("iconoAnyadir");
    
    anyadir.addEventListener("mouseenter", function () {
        if (icono.src.includes("anyadir.png")) {
            icono.src = "images/anyadirHover.png";
        }
    });

    anyadir.addEventListener("mouseleave", function () {
        if (icono.src.includes("anyadirHover.png")) {
            icono.src = "images/anyadir.png";
        }
    });
});
