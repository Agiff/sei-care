import Swal from 'sweetalert2';

export const successAlert = (title) => {
  Swal.fire({
    icon: 'success',
    title: title,
    showConfirmButton: false,
    timer: 1500
  })
}

export const failureAlert = (code, message) => {
  Swal.fire({
    icon: 'error',
    title: `Error ${code ? code : ''}`,
    text: message ? message : 'Something went wrong'
  })
}