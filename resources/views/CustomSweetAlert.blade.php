<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
document.addEventListener("DOMContentLoaded", function() {
        var status = "{{ session('status') }}";
        var message = "{{ session('message') }}";
        var errors = @json($errors->all());

        if (status === 'success') {
            Swal.fire({
                icon: 'success',
                title: 'Success',
                text: message
            }).then(function() {

            });
        } else if (status === 'error') {
            if (errors.length > 0) {
                // Construct the error message from the validation errors
                var errorMessage = 'Validation Errors:<br>';
                errors.forEach(function(error) {
                    errorMessage += error + '<br>';
                });

                // Display a SweetAlert with validation errors
                Swal.fire({
                    icon: 'error',
                    title: 'Validation Error',
                    html: errorMessage
                });
            } else {
                // Display a SweetAlert with general error message
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: message
                });
            }
        }
    });
</script>
