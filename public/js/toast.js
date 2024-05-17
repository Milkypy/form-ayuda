//instanciar bootstrap toast
var toastElList = [].slice.call(document.querySelectorAll('.toast'));
var toastList = toastElList.map(function (toastEl) {
    return new bootstrap.Toast(toastEl);
});

//funcion para mostrar toast
function showToast(message, background = 'success') {
    var toast = toastList[0];
    if (background == 'success') {
        toastElList[0].classList.remove('bg-danger');
        toastElList[0].classList.add('bg-success');
    } else {
        toastElList[0].classList.remove('bg-success');
        toastElList[0].classList.add('bg-danger');
    }
    var toastBody = document.querySelector('.toast-body');
    toastBody.textContent = message;
    toast.show();
}