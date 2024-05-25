document.querySelectorAll('.alert #close-alert').forEach((element) => {
    element.addEventListener('click', () => {
        element.parentElement.remove();
    });
})