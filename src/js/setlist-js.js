/*******************
Constants
********************/
const queryString = window.location.search;
const urlParams = new URLSearchParams(queryString);
const SETLIST_ID = urlParams.get('id');                   // setlist id
const API = 'api.song-requests.php';


// main function

$(document).ready(function() {
  getRequests();
});


// get the song-requests from the server
function getRequests() {
  var data = {
    id: SETLIST_ID,
    function: 'get-setlist-requests',
  };

  $.get(API, data, function(response) {
    displayRequests(JSON.parse(response));
    // console.log(response);
  });
}

// display the song requests
function displayRequests(requests) {
  const size = requests.length;
  var html = '';

  console.log(requests);

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
  html += '<i class="bx bx-up-arrow"></i>';
  html += '</div>';
  html += '<div class="votes-count">';
  html += '<span>' + request.votes_count + '</span>';
  html += '</div>';
  html += '<div class="votes-down">';
  html += '<i class="bx bx-down-arrow"></i>';
  html += '</div>';
  html += '</div>';
  html += '<div class="request-info">';
  html += '<div class="request-info-song-title">' + request.song_title + '</div>';
  html += '<div class="request-info-song-artist"><i class="bx bxs-user"></i>&nbsp;' + request.song_artist + '</div>';
  html += '<div class="status">';
  html += '<span class="badge badge-primary">' + request.status + '</span>';
  html += '</div>';
  html += '</div>';
  html += '</div> ';
  html += '</div>';

  return html;


}