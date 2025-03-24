<script>
    // Create an instance of Notyf
    var notyf = new Notyf({
        duration: 5000
    });

    //date picker
    $('.datepicker').datepicker({
        format: 'yyyy-mm-dd',
    });

    // year picker
    $('.yearpicker').datepicker({
        format: 'yyyy',
        viewMode: 'years',
        minViewMode: 'years',
    });

    ClassicEditor
        .create(document.querySelector('#editor'))
        .catch(error => {
            console.error(error);
        });

    function showLoader() {
        $('.preloader_demo').removeClass('d-none');
    }

    function hideLoader() {
        $('.preloader_demo').addClass('d-none');
    }

    $("body").on('click', '.delete-item', function(e) {
        e.preventDefault();

        let url = $(this).attr('href');

        Swal.fire({
            title: "Are you sure?",
            text: "You won't be able to revert this!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Yes, delete it!"
        }).then((result) => {
            if (result.isConfirmed) {

                $.ajax({
                    method: 'DELETE',
                    url: url,
                    data: {
                        _token: "{{ csrf_token() }}"
                    },
                    success: function(response) {
                        window.location.reload();
                    },
                    error: function(xhr, status, error) {
                        console.log(xhr);
                        swal(xhr.responseJSON.message, {
                            icon: 'error',
                        });
                    }
                })
            }
        });
    });
</script>
