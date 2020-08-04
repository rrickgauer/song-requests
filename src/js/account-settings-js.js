const API                  = 'api.song-requests.php';
const queryString          = window.location.search;
const urlParams            = new URLSearchParams(queryString);
const DJ_ID                = urlParams.get('id');                   // dj id
const usernameForm         = $("#form-change-username");
const submitUsernameBtn    = $("#form-change-username input[type='submit']");
const newUsernameInput     = $("#new-username");
const updatePasswordForm   = $("#form-update-password");
const updatePasswordSubmit = $("#form-update-password input[type='submit']");
const updatePasswordOld    = $("#old-password");
const updatePasswordNew1   = $("#new-password-1");
const updatePasswordNew2   = $("#new-password-2");


// main function
$(document).ready(function() {
  // code goes here
  addEventListeners();
});

function addEventListeners() {
  $(newUsernameInput).on('keyup focusout', getRegisteredUsernames);

  $("#form-update-password input").on('keyup focusout', validatePasswordUpdate);
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
  $(submitUsernameBtn).prop('disabled', true);
  $(newUsernameInput).removeClass('is-invalid').removeClass('is-valid');
}


function validatePasswordUpdate() {
  var oldPassword = $(updatePasswordOld).val();
  var newPassword1 = $(updatePasswordNew1).val();
  var newPassword2 = $(updatePasswordNew2).val();

  if (oldPassword == '' || newPassword1 == '' || newPassword2 == '') {
    disableUpdatePassword();
    return;
  }

  else if (newPassword1 != newPassword2) {
    var errorMessage = 'Passwords must match.'
    $(updatePasswordNew2).closest('.form-group').find('.invalid-feedback').html(errorMessage);
    $(updatePasswordNew2).addClass('is-invalid');
    disableUpdatePassword();
    return;
  }


  $(updatePasswordNew2).removeClass('is-invalid');
  enableUpdatePassword();
}

function disableUpdatePassword() {
  $(updatePasswordSubmit).prop('disabled', true);
}

function enableUpdatePassword() {
  $(updatePasswordSubmit).prop('disabled', false);
}



