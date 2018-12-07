document.addEventListener('DOMContentLoaded', function() {
    var elems = document.querySelectorAll('select');
    var instances = M.FormSelect.init(elems, {});
});
document.addEventListener('DOMContentLoaded', function () {
    var instances = M.Modal.init(document.getElementById("stats-modal"), {});
});
