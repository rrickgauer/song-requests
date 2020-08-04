const API = 'api.song-requests.php';

var newSetlistModal = $("#modal-new-setlist");

$(document).ready(function() {
  addEventListeners();
  enableFlatpickr();
  getSetlists();
  $("#nav-item-profile").addClass('active');

});

function addEventListeners() {
  $(newSetlistModal).on('hidden.bs.modal', clearNewSetlistInputs);
}


// enable the flatpickr
function enableFlatpickr() {
  flatpickr(".new-setlist-time", {
    enableTime: true,
    altInput: true,
    altFormat: "h:i K o\\n F J, Y", 
  });
}


// get all dj setlists from the db
function getSetlists() {
  var data = {
    function: "get-dj-setlists"
  };

  $.get(API, data, function(response) {
    displaySetlists(JSON.parse(response));
  });
}

// display the setlists list
function displaySetlists(setlists) {
  var html = '';
  for (var count = 0; count < setlists.length; count++) 
    html += getSetlistCardHtml(setlists[count]);
  
  // display new html
  document.getElementById("setlists-list").innerHTML = html;
}

// get a setlist card html
function getSetlistCardHtml(setlist) {
  var html = '';
  html += '<div class="card card-setlist" data-setlist-id="' + setlist.id + '">';
  html += '<div class="card-body">';
  html += '<h4 class="card-title">' + setlist.name + '</h4>';

  // start time
  html += '<p class="card-text">Starts: ';
  html += setlist.time_start_display_date + ' at ';
  html += setlist.time_start_display_time + '</p>';

  //end time
  html += '<p class="card-text">Ends: ';
  html += setlist.time_end_display_date + ' at ';
  html += setlist.time_end_display_time + '</p>';

  html += '</div>';
  html += '<div class="card-footer">';

  // status
  if (setlist.status == 'open')
    html += '<span class="badge badge-success">' + setlist.status + '</span>';
  else if (setlist.status == 'closed')
    html += '<span class="badge badge-danger">' + setlist.status + '</span>';
  else
    html += '<span class="badge badge-warning">' + setlist.status + '</span>';

  // link to setlist page
  html += '<a href="dj-setlist.php?id=' + setlist.id + '" class="float-right">Details</a>';

  html += '</div>';
  html += '</div> ';

  return html;
}

// clear the text from the new setlist modal inputs
function clearNewSetlistInputs() {
  $("input.new-setlist").val('');
}







