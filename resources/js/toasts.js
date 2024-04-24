document.addEventListener('DOMContentLoaded', function () {
    var successToast = document.getElementById('successToast');
    var errorToast = document.getElementById('errorToast');

    if (successToast) {
        var bsSuccessToast = new bootstrap.Toast(successToast);
    bsSuccessToast.show();
    }
    if (errorToast) {
        var bsErrorToast = new bootstrap.Toast(errorToast);
    bsErrorToast.show();
    }
});

