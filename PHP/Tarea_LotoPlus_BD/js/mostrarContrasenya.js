//Añado un listener al botón con el icono de mostrar contraseña para que haga una función cuando reciba click
document.getElementById("mostrarContrasenya").addEventListener("click", function(){
    //Guardo el input de la contraseña y el icono en constantes
    const inputContrasenya = document.getElementById("passwd");
    const icono = document.getElementById("iconoContrasenya");
    
    /*Si el tipo de input de la contraseña es texto este se cambia a contraseña además de ajustar su ancho y cambiar
    el icono*/
    if(inputContrasenya.type === "text"){
        inputContrasenya.type = "password";
        inputContrasenya.style.width = "190px";
        icono.src = "images/mostrarContrasenya.png"; 
    }else{
        //Si ocurre al contrario el tipo se cambia a texto y se cambia el icono al otro icono guardado
        inputContrasenya.type = "text";
        inputContrasenya.style.width = "190px";
        icono.src = "images/ocultarContrasenya.png"; 
    }
})