const API               = 'api.song-requests.php';
const queryString       = window.location.search;
const urlParams         = new URLSearchParams(queryString);
const DJ_ID             = urlParams.get('id');                   // dj id
const usernameForm      = $("#form-change-username");
const submitUsernameBtn = $("#form-change-username input[type='submit']");
const newUsernameInput  = $("#new-username");


// main function
$(document).ready(function() {
  // code goes here
  addEventListeners();
});

function addEventListeners() {
  $(newUsernameInput).on('keyup focusout', getRegisteredUsernames);
}

function getRegisteredUsernames() {
  var query = $(newUsernameInput).val();

  // if the input is blank disable the submit button
  if (query == '' || query.length == 0) {
    resetNewUsernameSubmission();
    return;
  }

  var data = {
    function: "does-username-exist",
    username: query,
  };

  $.get(API, data, function(response) {
    if (response == 'success') 
      enableNewUsernameSubmission();
     else 
      disableNewUsernameSubmission();
  });
}

// enables user to submit a new username change
function enableNewUsernameSubmission() {
  $(submitUsernameBtn).prop('disabled', false);
  $(newUsernameInput).removeClass('is-invalid').addClass('is-valid');
}

// disables user to update their username
function disableNewUsernameSubmission() {
  $(submitUsernameBtn).prop('disabled', true);
  $(newUsernameInput).addClass('is-invalid');
}

// disables user to update their username
function resetNewUsernameSubmission() {
  $(newUsernameInput).removeClass("green-input").removeClass("red-input");
  $(submitUsernameBtn).prop('disabled', true);
  $(newUsernameInput).removeClass('is-invalid').removeClass('is-valid');
}



