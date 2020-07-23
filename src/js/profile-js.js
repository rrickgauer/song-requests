$(document).ready(function() {
  enableFlatpickr();
});


// enable the flatpickr
function enableFlatpickr() {
  flatpickr(".new-setlist-time", {
    enableTime: true,
    altInput: true,
    altFormat: "h:i K o\\n F J, Y", 
  });
}
