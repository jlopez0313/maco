export const goToQR = (url) => {
        const dualScreenLeft = window.screenLeft !==  undefined ? window.screenLeft : window.screenX;
        const dualScreenTop = window.screenTop !==  undefined   ? window.screenTop  : window.screenY;

        const width = window.innerWidth ? window.innerWidth : document.documentElement.clientWidth ? document.documentElement.clientWidth : screen.width;
        const height = window.innerHeight ? window.innerHeight : document.documentElement.clientHeight ? document.documentElement.clientHeight : screen.height;

        const systemZoom = width / window.screen.availWidth;
        const left = (width - 700) / 2 / systemZoom + dualScreenLeft
        const top = (height - 500) / 2 / systemZoom + dualScreenTop

        window.open(
            url,
            "ModalPopUp",
            "toolbar=no," +
            "scrollbars=no," +
            "location=yes," +
            "statusbar=no," +
            "menubar=no," +
            "resizable=0," +
            "width=750," +
            "height=750," +
            "left=" + left + "," +
            "top=" + top + ""    
        );
}