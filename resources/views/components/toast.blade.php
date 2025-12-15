@if(session('toast_success') || session('toast_error'))
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
document.addEventListener("DOMContentLoaded", function () {
    @if(session('toast_success'))
        Swal.fire({
            toast: true,
            position: "top-end",
            icon: "success",
            title: "{{ session('toast_success') }}",
            showConfirmButton: false,
            timer: 3000
        });
    @endif

    @if(session('toast_error'))
        Swal.fire({
            toast: true,
            position: "top-end",
            icon: "error",
            title: "{{ session('toast_error') }}",
            showConfirmButton: false,
            timer: 3000
        });
    @endif
});
</script>
@endif
