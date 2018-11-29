// Listener para menu central
document.addEventListener('DOMContentLoaded', function () {
    var instances = M.Collapsible.init(document.getElementById("menu-collapsible"), {});
});

// Listener para modal de "Eliminar cuenta"
document.addEventListener('DOMContentLoaded', function () {
    var instances = M.Modal.init(document.getElementById("delete-modal"), {});
});

// Listener para menu slide
document.addEventListener('DOMContentLoaded', function () {
    var instances = M.Sidenav.init(document.getElementById("slide-out"), 'left');
});