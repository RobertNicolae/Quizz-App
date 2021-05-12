
const showAlert = function (type, title, message) {
  Swal.fire({
    title: title,
    text: message,
    icon: type,
    confirmButtonText: 'Ok'
  })
}
$(document).ready(function () {

  $('#login').on('submit', function (event) {
event.preventDefault();
    let formData = new FormData(this);

    $.ajax({
      url: "/Auth/server/User.php",
      method: "post",
      data: {
        email: formData.get("email"),
        password: formData.get("password")
  },
      success: function (data){

        localStorage.setItem("token", data.data[0].token);
        window.location='http://localhost/client/';

      },
      error: function(err) {
        console.log(err)
      }
    })
  });
});


