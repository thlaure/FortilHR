document.querySelectorAll('.alert .close').forEach((element) => {
    element.addEventListener('click', () => {
        element.parentElement.remove();
    });
});