export const forcePrint = (url) => {
    const iframe = document.createElement('iframe');
    iframe.style.visibility = 'hidden'; // Ocultar el iframe
    iframe.src = url; // Ruta de Laravel que devuelve el HTML
    document.body.appendChild(iframe);

    // Esperar a que el contenido se cargue y luego imprimir
    iframe.onload = function() {
        iframe.style.display = 'none'; // Ocultar el iframe
        iframe.contentWindow.print();

        setTimeout(() => {
            document.body.removeChild(iframe); // Remover el iframe después de imprimir
        }, 3000)
    };
}