document.addEventListener('DOMContentLoaded', function () {
    const alert = document.querySelector('.alert');
    if (!alert) {
        return;
    }

    setTimeout(function () {
        alert.style.display = 'none';
    }, 2500);
});
