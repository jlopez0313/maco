export const toCurrency = (number, currency = 'COP') => {
    return new Intl.NumberFormat('es-CO', { 
        maximumFractionDigits: 0,
        style: 'currency', 
        currency 
    })
    .format( number )
}
