/****************
Constants
*****************/
const API = 'api.song-requests.php';            // back end server api string
const searchInput = $("#home-search-input");    // search input text box


/******************
Functions
*******************/

// main function
$(document).ready(function() {
  // code here
  addEventListeners();
});

function addEventListeners() {
  $(searchInput).on('keyup', getSearchResults);
  $('input[name="filter-option"]').on('change', function() {
    updateSelectedFilterOption(this);
  });
}

// get the search results from the server
function getSearchResults() {
  var query = $(searchInput).val();
  var data = {
    function: 'search-djs-setlists',
    query: query
  };

  $.get(API, data, function(response) {
    displaySearchResults(JSON.parse(response));
  });
}


// load the result data
function displaySearchResults(data) {
  $(".search-results-setlists").html(getSetlistCardsHtml(data.setlists));
  $(".search-results-djs").html(getDjCardsHtml(data.djs));
}

// generates and returns the html for the dj cards
function getDjCardsHtml(djs) {
  const size = djs.length;
  var html = '<h4 class="mb-3">DJ\'s</h4>';

  for (var count = 0; count < size; count++) {
    html += '<div class="card card-dj">';
    html += '<div class="card-body">';
    html += '<h5 class="card-title">' + djs[count].username + '</h5>';
    html += '</div>';
    html += '<div class="card-footer">';
    html += '<a class="float-right" href="#">View</a>';
    html += '</div>';
    html += '</div>';
  }

  return html;
}

// generates and returns html for all the setlist cards
function getSetlistCardsHtml(setlists) {
  const size = setlists.length;
  var html = '<h4 class="mb-3 mt-5">Setlists</h4>';

  for (var count = 0; count < size; count++) {
    html += '<div class="card card-setlist">';
    html += '<div class="card-body">';
    html += '<h5 class="card-title">' + setlists[count].name + '</h5>';
    html += '</div>';
    html += '<div class="card-footer">';
    html += '<a class="float-right" href="#">View</a>';
    html += '</div>';
    html += '</div> ';
  }

  return html;
}

// filters out the search result cards
function updateSelectedFilterOption(selectedOption) {
  var newSelectedFilterOption = $(selectedOption).val();

  switch(newSelectedFilterOption) {
    case "dj":
      $(".search-results-djs").attr('hidden', false);
      $(".search-results-setlists").attr('hidden', true);
      break;
    case "setlist":
      $(".search-results-djs").attr('hidden', true);
      $(".search-results-setlists").attr('hidden', false);
      break;
    default:
      $(".search-results-djs").attr('hidden', false);
      $(".search-results-setlists").attr('hidden', false);
      break;
  }
}

