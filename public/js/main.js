// import "../../resources/css/app.css";

// Top-End Flasher SweetAlert2
document.addEventListener('livewire:init', () => {
    Livewire.on('swal-toast', () => {
        const Toast = Swal.mixin({
            toast: true,
            position: "top-end",
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
            didOpen: (toast) => {
                toast.onmouseenter = Swal.stopTimer;
                toast.onmouseleave = Swal.resumeTimer;
            }
        });
        Toast.fire({
            icon: event.detail.icon,
            title: event.detail.title
        });
    });
});
