//Añado un listener al input de contraseña para cuando se modifique su contenido
document.getElementById("passwd").addEventListener("input", function(){
    //Guardo en constantes el contenido de la contraseña además del div con la barra de fortaleza y el mensaje que se muestra
    const contrasenya = this.value;
    const barraFortaleza = document.getElementById("fortaleza");
    const mensajeFortaleza = document.getElementById("mensajeFortaleza");

    let nivelFortaleza = 0;

    /*Sigo las mismas reglas que en PHP para obtener el nivel de fortaleza usando los mismos patrones pero con el método test() en este
    caso*/
    nivelFortaleza += contrasenya.length >= 4 && contrasenya.length <= 20 ? 1 : 0;
    nivelFortaleza += /[A-Z]/.test(contrasenya) ? 1 : 0;
    nivelFortaleza += /[a-z]/.test(contrasenya) ? 1: 0;
    nivelFortaleza += /[0-9]/.test(contrasenya) ? 1 : 0;
    nivelFortaleza += /[\W_]/.test(contrasenya) ? 1 : 0;

    let color;
    //Calculo el porcentaje de la fortaleza de la misma manera, multiplicando el nivel por 20 al ser 5 niveles
    let porcentaje = nivelFortaleza * 20;

    //Modifico el ancho de la barra de fortaleza con el porcentaje que acabo de calcular
    barraFortaleza.style.width = porcentaje + "%";
    
    /*Hago un switch con el nivel de fortaleza para guardar un color y un mensaje según el nivel de fortaleza obtenido. Por defecto, el 
    color es el gris y el mensaje es una cadena vacía*/
    switch(nivelFortaleza) {
        case 1:
            color = "bg-rojo";
            mensajeFortaleza.innerText = 'Muy débil';
            break;
        case 2:
            color = "bg-naranja";
            mensajeFortaleza.innerText = 'Débil';
            break;
        case 3:
            color = "bg-amarillo";
            mensajeFortaleza.innerText = 'Moderada';
            break;
        case 4:
            color = "bg-verde";
            mensajeFortaleza.innerText = 'Fuerte';
            break;
        case 5:
            color = "bg-verde-oscuro";
            mensajeFortaleza.innerText = 'Muy fuerte';
            break;
        default:
            color = "bg-gris";
            mensajeFortaleza.innerText = "";
            break;
    }

    //Finalmente añado el color obtenido como nombre de la clase de la barra de fortaleza para que se modifique según la clase en CSS
    barraFortaleza.className = color;
})