const API         = 'api.song-requests.php';
const queryString = window.location.search;
const urlParams   = new URLSearchParams(queryString);
const SETLIST_ID  = urlParams.get('id');                   // id



// main 
$(document).ready(function() {
  enableTimePickers();
  getRequests();
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

// get the request data from server
function getRequests() {
  var data = {
    function: "get-setlist-requests",
    id: SETLIST_ID,
  };

  $.get(API, data, function(response) {
    displayRequests(JSON.parse(response));
  });
}


// display the requests table data
function displayRequests(requests) {
  const size = requests.length;
  var html = '';

  // generate the table html
  for (var count = 0; count < size; count++) 
    html += getRequestTableRowHtml(requests[count]);
  
  // display the html
  $(".table-requests tbody").html(html);
  new Tablesort(document.getElementById('table-requests'));
}

// generate and return for a request table row
function getRequestTableRowHtml(request) {
  var html = '<tr data-request-id="' + request.id + '" data-status="' + request.status + '">';
  html += '<td>' + request.song_title + '</td>';
  html += '<td>' + request.song_artist + '</td>';
  html += '<td>' + request.votes + '</td>';
  html += '<td data-sort="' + request.date_submitted_unix + '">' + request.date_submitted_display_date + '</td>';
  html += '<td data-sort="' + request.date_submitted_unix + '">' + request.date_submitted_display_time + '</td>';

  html += '<td>';
  if (request.status == 'approved')
    html += '<span class="badge badge-success">' + request.status + '</span>';
  else if (request.status == 'denied')
    html += '<span class="badge badge-danger">' + request.status + '</span>';
  else
    html += '<span class="badge badge-secondary">' + request.status + '</span>';

  html += '</td>';
  html += '<td><i class="bx bx-cog"></i></td>';
  html += '</tr>';

  return html;
}
