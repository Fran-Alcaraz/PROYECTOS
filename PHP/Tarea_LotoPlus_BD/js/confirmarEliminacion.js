function confirmarEliminacion(event, form) {
    event.preventDefault();

    // Muestra la ventana de SweetAlert2
    return Swal.fire({
        title: '¿Estás seguro?',
        text: "No podrás deshacer esta acción.",
        icon: 'warning',
        iconColor: '#1f92a9',
        showCancelButton: true, // Mostrar el botón de cancelación
        confirmButtonColor: '#d33', // Color del botón de confirmación
        cancelButtonColor: '#3085d6', // Color del botón de cancelación
        confirmButtonText: 'Sí, eliminar',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.isConfirmed) {
            // Devuelve `true` para enviar el formulario
            form.submit();
        }
        // No envía el formulario si se cancela
        return false;
    });

    // Evita el envío inmediato del formulario
    return false;
}