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
  addEventListeners();
  $("#nav-item-home").addClass('active');
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
  $(".search-results-setlists .list-group").html(getSetlistCardsHtml(data.setlists));
  $(".search-results-djs .list-group").html(getDjCardsHtml(data.djs));
}

// generates and returns the html for the dj cards
function getDjCardsHtml(djs) {
  const size = djs.length;
  var html = '';

  for (var count = 0; count < size; count++) {
    var dj = djs[count];
    html += '<li class="list-group-item item-dj"><div>' + dj.username;
    html += '<span class="badge badge-light ml-2 mr-2">' + dj.count_setlists + ' setlists</span></div>';
    html += '<a href="dj.php?id=' + dj.id + '">Profile</a></li>';
  }

  return html;
}

// generates and returns html for all the setlist cards
function getSetlistCardsHtml(setlists) {
  const size = setlists.length;
  var html = '';

  for (var count = 0; count < size; count++) {
    var setlist = setlists[count];
    html += '<li class="list-group-item item-setlist">';
    html += '<div>' + setlist.name;
    html += '<span class="badge badge-light ml-2 mr-2">' + setlist.count_requests + ' requests</span>';
    html += '</div>';
    html += '<a href="setlist.php?id=' + setlist.id + '">View</a></li>';
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

