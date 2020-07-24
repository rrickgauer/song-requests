const API = 'api.song-requests.php';
const searchInput = $("#home-search-input");


// main function
$(document).ready(function() {
  // code here
  addEventListeners();
});

function addEventListeners() {
  $(searchInput).on('keyup', getSearchResults);
}

function getSearchResults() {
  var query = $(searchInput).val();
  var data = {
    function: 'search-djs-setlists',
    query: query
  };

  $.get(API, data, function(response) {
    console.log(response);
  });
}