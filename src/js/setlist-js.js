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

  $(".song-requests").on('click', '.vote-up', function() {
    voteUp(this);
  });

  $(".song-requests").on('click', '.vote-down', function() {
    voteDown(this);
  });
}


// get the song-requests from the server
function getRequests() {
  var data = {
    id: SETLIST_ID,
    function: 'get-setlist-requests',
  };

  $.get(API, data, function(response) {
    displayRequests(JSON.parse(response));
    console.log(JSON.parse(response));
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
  html += '<i class="bx bxs-up-arrow vote-up"></i>';
  html += '</div>';
  html += '<div class="votes-count">';
  html += '<span class="votes-count-display">' + request.votes + '</span>';
  html += '</div>';
  html += '<div class="votes-down">';
  html += '<i class="bx bxs-down-arrow vote-down"></i>';
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

// vote up button was clicked
function voteUp(selector) {
  if ($(selector).hasClass('voted')) 
    removeVoteUp(selector);
  else 
    postVoteUp(selector);
}

// adds 1 to the vote count
function postVoteUp(selector) {
  var request = $(selector).closest(".card-request");
  var requestID = $(request).attr('data-request-id');

  var data = {
    function: 'vote-up',
    requestID: requestID,
  };

  $.post(API, data, function(response) {
    if (response == 'success') {
      if ($(request).find('.vote-down').hasClass('voted')) {
        incrementVoteCount($(request).find(".votes-count-display"));
        $(request).find('.vote-down').removeClass('voted')
      }
      $(selector).addClass('voted'); 
      incrementVoteCount($(request).find(".votes-count-display"));
    }
  });
}

// user previously voted up on a request
// remove that vote up and decrement the vote count
function removeVoteUp(selector) {
  var request = $(selector).closest(".card-request");
  var requestID = $(request).attr('data-request-id');

  var data = {
    function: 'vote-down',
    requestID: requestID,
  };

  $.post(API, data, function(response) {
    $(selector).removeClass('voted');
    decrementVoteCount($(request).find(".votes-count-display"));
  });
}

// user has clicked the vote down button
function voteDown(selector) {
  if ($(selector).hasClass('voted'))
    removeVoteDown(selector);
  else
    postVoteDown(selector);
}

// decrement the vote count by 1
function postVoteDown(selector) {
  var request = $(selector).closest(".card-request");
  var requestID = $(request).attr('data-request-id');

  var data = {
    function: 'vote-down',
    requestID: requestID,
  };

  $.post(API, data, function(response) {
    if (response == 'success') {
      if ($(request).find('.vote-up').hasClass('voted')) {
        decrementVoteCount($(request).find(".votes-count-display"));
        $(request).find('.vote-up').removeClass('voted')
      }
      
      $(selector).addClass('voted'); 
      decrementVoteCount($(request).find(".votes-count-display"));
    }
  });
}

// user has previously voted down
// remove add 1 to the votes and remove the voted class from the button
function removeVoteDown(selector) {
  var request = $(selector).closest(".card-request");
  var requestID = $(request).attr('data-request-id');

  var data = {
    function: 'vote-up',
    requestID: requestID,
  };

  $.post(API, data, function(response) {
    $(selector).removeClass('voted');
    incrementVoteCount($(request).find(".votes-count-display"));
  });
}


function incrementVoteCount(element) {
  var count = parseInt($(element).html());
  count += 1;
  $(element).html(count);
}

function decrementVoteCount(element) {
  var count = parseInt($(element).html());
  count += -1;
  $(element).html(count);
}