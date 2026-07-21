document.addEventListener('DOMContentLoaded', function () {


    const body = document.body;


    const successMessage = body.dataset.success;
    const errorMessage = body.dataset.error;
    const validationMessage = body.dataset.validation;



    if(successMessage){

        Swal.fire({

            icon:'success',
            title:'Berhasil',
            text:successMessage,
            showConfirmButton:false,
            timer:2000

        });

    }



    if(errorMessage){

        Swal.fire({

            icon:'error',
            title:'Gagal',
            text:errorMessage

        });

    }



    if(validationMessage){

        Swal.fire({

            icon:'warning',
            title:'Periksa kembali data',
            text:validationMessage

        });

    }


});