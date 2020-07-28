/*******************
Constants
********************/
const queryString = window.location.search;
const urlParams = new URLSearchParams(queryString);
const DJ_ID = urlParams.get('id');                   // dj id
const API = 'api.song-requests.php';

// main function
$(document).ready(function() {
  loadSetlists();
});



// get the dj's setlists from the db
function loadSetlists() {
  var data = {
    id: DJ_ID,
    function: 'get-dj-setlists-for-user'
  }

  $.get(API, data, function(response) {
    displaySetlists(JSON.parse(response));
  });
}

// display the setlist cards
function displaySetlists(setlists) {
  const size = setlists.length;
  var html = '';
  for (var count = 0; count < size; count++) {
    html += getSetlistCardHtml(setlists[count]);
  }

  $(".dj-setlists").html(html);
}

// return the html for a setlist card
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
  html += '<a href="setlist.php?id=' + setlist.id + '" class="float-right">Details</a>';

  html += '</div>';
  html += '</div> ';

  return html;
}