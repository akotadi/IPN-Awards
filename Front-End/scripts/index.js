// Listener para menu slide
document.addEventListener('DOMContentLoaded', function () {
    var instances = M.Sidenav.init(document.getElementById("slide-out"), 'left');
});

// Listener para modal de "Consultar qr"
document.addEventListener('DOMContentLoaded', function () {
    var instances = M.Modal.init(document.getElementById("qr-modal"), {});
});