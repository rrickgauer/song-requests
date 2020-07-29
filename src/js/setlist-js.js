/*******************
Constants
********************/
const queryString = window.location.search;
const urlParams = new URLSearchParams(queryString);
const SETLIST_ID = urlParams.get('id');                   // setlist id
const API = 'api.song-requests.php';


// main function
$(document).ready(function() {
  addEventListeners();
  getRequests();
});


// add event listeners
function addEventListeners() {
  $("#modal-new-request").on('hidden.bs.modal', clearNewRequestModalInputs);
}


// get the song-requests from the server
function getRequests() {
  var data = {
    id: SETLIST_ID,
    function: 'get-setlist-requests',
  };

  $.get(API, data, function(response) {
    displayRequests(JSON.parse(response));
  });
}

// display the song requests
function displayRequests(requests) {
  const size = requests.length;
  var html = '';

  for (var count = 0; count < size; count++) {
    html += getRequestCardHtml(requests[count]);
  }

  $(".song-requests").html(html);
}


function getRequestCardHtml(request) {
  var html = '';
  html += '<div class="card card-request" data-request-id="' + request.id + '">';
  html += '<div class="card-body">';
  html += '<div class="votes">';
  html += '<div class="votes-up">';
  html += '<i class="bx bx-up-arrow vote-up"></i>';
  html += '</div>';
  html += '<div class="votes-count">';
  html += '<span class="votes-count-display>' + request.votes_count + '</span>';
  html += '</div>';
  html += '<div class="votes-down">';
  html += '<i class="bx bx-down-arrow vote-down"></i>';
  html += '</div>';
  html += '</div>';
  html += '<div class="request-info">';
  html += '<div class="request-info-song-title">' + request.song_title + '</div>';
  html += '<div class="request-info-song-artist"><i class="bx bxs-user"></i>&nbsp;' + request.song_artist + '</div>';
  html += '<div class="status">';

  if (request.status == 'approved')
    html += '<span class="badge badge-success">' + request.status + '</span>';
  else if (request.status == 'denied')
    html += '<span class="badge badge-danger">' + request.status + '</span>';
  else
    html += '<span class="badge badge-secondary">' + request.status + '</span>';

  html += '</div>';
  html += '</div>';
  html += '</div> ';
  html += '</div>';

  return html;
}

// clears the new request modal form inputs
function clearNewRequestModalInputs() {
  $("#modal-new-request input").val('');
}