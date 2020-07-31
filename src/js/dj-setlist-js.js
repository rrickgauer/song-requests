const API         = 'api.song-requests.php';
const queryString = window.location.search;
const urlParams   = new URLSearchParams(queryString);
const SETLIST_ID  = urlParams.get('id');                   // id



// main 
$(document).ready(function() {
  enableTimePickers();
  getSetlistInfo();
});


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
    console.log(response);
    displaySetlistModalInfo(JSON.parse(response));
  });
}

// display the setlist data to the modal
function displaySetlistModalInfo(setlist) {\
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


