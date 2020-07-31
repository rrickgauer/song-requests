const API         = 'api.song-requests.php';
const queryString = window.location.search;
const urlParams   = new URLSearchParams(queryString);
const SETLIST_ID  = urlParams.get('id');                   // id



// main 
$(document).ready(function() {
  enableTimePickers();
  getSetlistInfo();
  addEventListeners();
  // $("#modal-setlist-info").modal('show');
});


// add event listeners
function addEventListeners() {
  $("#modal-setlist-info").on('hidden.bs.modal', cancelEditSetlistInfoForm);
}


// enable time picker
function enableTimePickers() {
  flatpickr(".edit-setlist-time", {
    enableTime: true,
    altInput: true,
    altFormat: "h:i K o\\n F J, Y", 
  });
}

// retrieve setlist info from server
function getSetlistInfo() {
  var data = {
    function: 'get-setlist-info',
    setlistID: SETLIST_ID,
  };

  $.get(API, data, function(response) {
    displaySetlistModalInfo(JSON.parse(response));
  });
}

// display the setlist data to the modal
function displaySetlistModalInfo(setlist) {
  // set name
  $("#edit-setlist-name").val(setlist['name']);

  // set time start
  flatpickr("#edit-setlist-time-start", {
    enableTime: true,
    altInput: true,
    altFormat: "h:i K o\\n F J, Y",
    defaultDate: setlist['time_start'], 
  });

  // time end
  flatpickr("#edit-setlist-time-end", {
    enableTime: true,
    altInput: true,
    altFormat: "h:i K o\\n F J, Y",
    defaultDate: setlist['time_end'], 
  });


  // set status
  var statusOptions = $("#edit-setlist-status option");
  for (var count = 0; count < statusOptions.length; count++) {
    if ($(statusOptions[count]).val() == setlist.status)
      $(statusOptions[count]).prop('selected', true);
  }
}


// enables the user to edit the setlist info form contained in the modal
function enableEditSetlistInfoForm() {
  $(".edit-setlist").prop('disabled', false);
  $(".btn-save-edit-info").prop('hidden', false);
  $(".btn-cancel-edit-info").prop('hidden', false);
  $(".btn-edit-info").prop('hidden', true);
}


// cancel setlist edit info
function cancelEditSetlistInfoForm() {
  getSetlistInfo();
  $(".edit-setlist").prop('disabled', true);
  $(".btn-save-edit-info").prop('hidden', true);
  $(".btn-cancel-edit-info").prop('hidden', true);
  $(".btn-edit-info").prop('hidden', false);
}
