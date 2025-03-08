function validarFichero() {
    const referenciaFichero = document.getElementById("fotoPerfil");
    const fichero = referenciaFichero.files[0];
    const tamañoMaximo = 4096 * 1024;

    if (fichero) {
        const tiposValidos = [".jpg", ".png", ".gif"];
        const extension = "." + fichero.name.split('.').pop().toLowerCase(); // Corregido para obtener la extensión

        // Validar tipo de archivo
        if (!tiposValidos.includes(extension)) {
            referenciaFichero.value = "";
            Swal.fire({
                title: "Error",
                text: "Solo se permiten archivos JPG, PNG o GIF.",
                icon: "error",
                iconColor: "#ca0505",
                confirmButtonText: "Aceptar",
                confirmButtonColor: "#1f92a9"
            });
        }

        // Validar tamaño del archivo
        if (fichero.size > tamañoMaximo) {
            referenciaFichero.value = "";
            Swal.fire({
                title: "Error",
                text: "El tamaño máximo es de 4096KB.",
                icon: "error",
                iconColor: "#ca0505",
                confirmButtonText: "Aceptar",
                confirmButtonColor: "#1f92a9"
            });
        }
    }
}
