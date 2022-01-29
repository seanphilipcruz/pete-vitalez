import Sweetalert2 from "sweetalert2"

export const toast = Sweetalert2.mixin({
    toast: true,
    position: 'bottom-end',
    timer: 2500,
    showConfirmButton: false,
    showCloseButton: true,
    timerProgressBar: true,
    didOpen: (toast) => {
        toast.addEventListener('mouseenter', Sweetalert2.stopTimer);
        toast.addEventListener('mouseleave', Sweetalert2.resumeTimer);
    }
});

export const popup = Sweetalert2.mixin({
    showConfirmButton: true,
    showCancelButton: true,
    showCloseButton: true,
    timerProgressBar: true,
});
