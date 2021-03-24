let backendURL = '/server/'

const showAlert = function (type, title, message) {
  Swal.fire({
    title: title,
    text: message,
    icon: type,
    confirmButtonText: 'Ok'
  })
}

$('#add_question_form').on('submit', function (event) {
  event.preventDefault()

  $.ajax({
    url: backendURL + 'insert-question.php',
    method: 'POST',
    data: $(this).serialize(),
    success: function (data) {
      refreshQuestionTable()
    },
    error: function (xhr, status, error) {
      showAlert('error', 'Error', xhr.responseJSON.message)
    }
  })
})

function getHtmlForQuestions(question, rowNum)     {
  return `<tr>
    <td>` + rowNum + `</td>
     <td>` + question.name + `</td>
      <td><button style="margin-left:1em" onclick="deleteQuestion(this)" class="btn btn-light btn-sm " data-id="` + question.id + `">Delete</button></td>
       <td><a href="answer.html?id=` + question.id + ` "class="btn btn-light btn-sm" > Check</a> </td>`
}

const addQuestionInTable = function (question) {
  let rowNum = $('#questions tbody tr').length + 1
  $('#questions tbody').append(getHtmlForQuestions(question, rowNum))

}

function refreshQuestionTable () {
  let tbody = $('#questions tbody')

  tbody.html('Retrieve data..')

  $.ajax({
    url: backendURL + 'get-question.php',
    method: 'get',
    success: function (data) {
      tbody.html('')
      data.questions.forEach((question) => tbody.append(addQuestionInTable(question)))
    },
    error: function (xhr, status, error) {
      showAlert('error', 'Error', xhr.responseJSON.message)
    }
  })
}

const deleteQuestion = function (button) {
  let id = $(button).data('id')

  $.ajax({
    url: backendURL + 'delete-question.php',
    method: 'post',
    data: {
      id: id
    },
    success: function () {
      console.log(id)
      refreshQuestionTable()
    },
    error: function (xhr, status, error) {
      showAlert('error', 'Error', xhr.responseJSON.message)
    }
  })
}


$(document).ready(function (event) {
  refreshQuestionTable()
})