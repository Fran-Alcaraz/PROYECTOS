const btnNombreReal = document.getElementById("btn-nombre-real");
const btnNombreUsuario = document.getElementById("btn-nombre-usuario");
const btnFechaNac = document.getElementById("btn-fecha-nac");

btnNombreReal.addEventListener("click", function () {
    Swal.fire({
        title: "Buscar usuarios por su nombre real",
        input: "text",
        inputPlaceHolder: "Introduce el nombre que quieres buscar...",
        showCancelButton: true,
        cancelButtonText: "Cancelar",
        confirmButtonText: "Buscar",
        customClass: {
            popup: "form-buscar",
            input: "input-buscar",
            confirmButton: "btn-crear",
            cancelButton: "btn-cancelar"
        },
        preConfirm: (nombreIntroducido) => {
            if (!nombreIntroducido) {
                Swal.showValidationMessage("El campo no puede estar vacío.");
                return false;
            } else {
                console.log(nombreIntroducido);
                return nombreIntroducido;
            }
        }
    }).then((resultado) => {
        if (resultado.isConfirmed) {
            const nombreBuscar = resultado.value;
            const formulario = document.createElement("form");
            formulario.method = "POST";
            formulario.action = "buscarNombreReal.php";

            const input = document.createElement("input");
            input.type = "hidden";
            input.name = "nombreBuscar";
            input.value = nombreBuscar;
            formulario.appendChild(input);

            document.body.appendChild(formulario);
            formulario.submit();
        }
    });
});

btnNombreUsuario.addEventListener("click", function () {
    Swal.fire({
        title: "Buscar usuarios por su nombre de usuario",
        input: "text",
        inputPlaceHolder: "Introduce el nombre de usuario que quieres buscar...",
        showCancelButton: true,
        cancelButtonText: "Cancelar",
        confirmButtonText: "Buscar",
        customClass: {
            popup: "form-buscar",
            input: "input-buscar",
            confirmButton: "btn-crear",
            cancelButton: "btn-cancelar"
        },
        preConfirm: (usuarioIntroducido) => {
            if (!usuarioIntroducido) {
                Swal.showValidationMessage("El campo no puede estar vacío.");
                return false;
            } else {
                console.log(usuarioIntroducido);
                return usuarioIntroducido;
            }
        }
    }).then((resultado) => {
        if (resultado.isConfirmed) {
            const nombreUsuarioBuscar = resultado.value;
            const formulario = document.createElement("form");
            formulario.method = "POST";
            formulario.action = "buscarNombreUsuario.php";

            const input = document.createElement("input");
            input.type = "hidden";
            input.name = "nombreUsuarioBuscar";
            input.value = nombreUsuarioBuscar;
            formulario.appendChild(input);

            document.body.appendChild(formulario);
            formulario.submit();
        }
    });
});

btnFechaNac.addEventListener("click", function () {
    Swal.fire({
        title: "Buscar usuarios por rango de fechas de nacimiento",
        html: `
            <form action='buscarFechaNac.php' method='post' class='form-buscar-usuario' id='formulario-usuario-fechaNac'>
                <table style='text-align: left;'>
                    <tr>
                        <td><label for='fechaNacInicial'>Fecha inicial:</label></td>
                        <td><input type='date' name='fechaNacInicial' id='fechaInicial' placeholder='dd/mm/yyyy' required></td>
                    </tr>
                    <tr>
                        <td><label for='fechaNacFinal'>Fecha final:</label></td>
                        <td><input type='date' name='fechaNacFinal' id='fechaFinal' placeholder='dd/mm/yyyy' required></td>
                    </tr>
                </table>
            </form>
        `,
        showCancelButton: true,
        cancelButtonText: "Cancelar",
        confirmButtonText: "Buscar",
        customClass: {
            popup: "form-buscar",
            input: "input-buscar",
            confirmButton: "btn-crear",
            cancelButton: "btn-cancelar"
        },
    }).then((resultado) => {
        if (resultado.isConfirmed) {
            const form = document.getElementById("formulario-usuario-fechaNac");
            form.submit();
        }
    });
});