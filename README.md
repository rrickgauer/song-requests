# song-requests
Submit song requests to the DJ.

## Description

Song Requests is a webapp where users can submit song requests on their phones to the DJ playing music at an event.

The person in charge of setting up the set list is the DJ. DJs must create an account with a unique username and password. The system then autogenerates a unique id for the dj once the account has been created.

The DJ can then setup a setlist for users to submit a song request. A setlist has a display name that the dj creates for users to search for, and requires a start and end time for the setlist. Once the setlist is created by the DJ, the system autogenerates a unique id. The DJ can manage the setlist by logging into their profile and selecting the desired setlist. On the managage setlist page, the DJ can update the status of requested songs. These changes are reflected on the page the user sees when submitting a new song request.

Once the setlist is created, its status is set to open. This means that users are able to submit song requests to be added to the setlist.

When a user wants to add a song to the setlist, they can search for the setlist by setlist name, dj username, or enter in the setlist id. Once they are in the setlist page, they can submit a song request by entering in artist name, and/or song title. After submitting the song request, the system autogenerates and assigns a unique id for the request, saves the time it was submitted, and sets the inital status to pending. Also, the user can see what other songs are on the setlist that have been requested by other users. The page orders the songs by oldest to newest, and shows their status (pending, approved, denied).


## Ideas

* [Home search bar look](https://uidesigndaily.com/posts/sketch-search-searchbar-find-day-1026)
* [home search results](https://uidesigndaily.com/posts/figma-search-results-find-project-management-day-492)