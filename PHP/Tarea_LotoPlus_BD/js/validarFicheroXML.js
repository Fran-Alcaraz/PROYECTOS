function validarXML(){
    const referenciaFichero = document.getElementById("fichero");
    const ficheroSubido = referenciaFichero.files[0];

    if(ficheroSubido){
        const extensionValida = [".xml"];
        const extensionFichero = "." + ficheroSubido.name.split('.').pop().toLowerCase();

        if(!extensionValida.includes(extensionFichero)){
            referenciaFichero.value = "";
            Swal.fire({
                title: "Error",
                text: "Solo se permiten archivos XML.",
                icon: "error",
                iconColor: "#ca0505",
                confirmButtonText: "Aceptar",
                confirmButtonColor: "#1f92a9"
            });
        }
    }
}