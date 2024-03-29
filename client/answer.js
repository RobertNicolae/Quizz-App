const backendURL = '/server/'
const urlService = new URL(window.location.href)
const idQuestion = parseInt(urlService.searchParams.get('id'))

const showAlert = function (type, title, message) {
  Swal.fire({
    title: title,
    text: message,
    icon: type,
    confirmButtonText: 'Ok'
  })
}
  $('#add_answer_form').on('submit', function (event) {
    event.preventDefault()

    const formData = new FormData(this)

    $.ajax({
      url: '/server/insert-answer.php',
      method: 'post',
      headers: {
        Authorization: localStorage.getItem("token")},
      data: {
        answer_name: formData.get('answer_name'),
        question_id: idQuestion
      },
      success: function () {
        showAlert('success', 'Answer added', 'You successfully add answer')
        refreshAnswerTable()
      },

    })
  })

  const getHtmlForAnswer = function (rowNumber, answer) {
    return `<tr>
    <td>` + rowNumber + `</td>
     <td>` + answer.name + `</td>
        <td><button style="margin-left:1em" onclick="deleteAnswer(this)" class="btn btn-light btn-sm " data-id="` + answer.id + `">Delete</button></td>
        <td>` + getButtonForAnswer(answer) + `</td>`

  }

  const addAnswerInTable = function (answer) {
    let rowNumber = $('#answers tbody tr').length + 1
    $('#answers tbody').append(getHtmlForAnswer(rowNumber, answer))
  }
  const refreshAnswerTable = function () {
    $('#answers tbody').html('Loading')
    $.ajax({
      url: '/server/get-answers.php',
      method: 'get',
      headers: {
        Authorization: localStorage.getItem("token")},
      data: {
        question_id: idQuestion
      },
      success: function (data) {
        $('#answers tbody').html('')
        console.log(data)
        data.message.answers.forEach(answer => addAnswerInTable(answer))
      },

    })
  }

  function getButtonForAnswer (answer) {

    let button = ''
    if (parseInt(answer.is_right) === 0) {
      return '<button onclick="markAsCorrect(this)" class="btn btn-light btn-sm" data-id="' + answer.id + '">Mark as correct</button></td>'
    }
    return 'Correct answer'
  }

  const deleteAnswer = function (button) {
    let id = $(button).data('id')

    $.ajax({
      url: backendURL + 'delete-answer.php',
      method: 'post',
      data: {
        id: id
      },
      success: function () {
        showAlert('success', 'Answer deleted', 'You successfully deleted an answer')
        refreshAnswerTable()
      },

    })
  }
  const markAsCorrect = function (button) {
    let idM = $(button).data('id')

    $.ajax({
      url: backendURL + 'toggle-mark.php',
      method: 'post',
      data: {
        id: idM,
        question_id: idQuestion
      },
      success: function () {
        refreshAnswerTable()
      },

    })
  }

  $(document).ready(function (event) {
    refreshAnswerTable()
  })


