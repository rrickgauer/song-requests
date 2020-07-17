DROP TABLE IF EXISTS
    Djs,
    Setlists,
    Requests;

CREATE TABLE Djs (
    id INT UNSIGNED NOT NULL UNIQUE AUTO_INCREMENT,
    username CHAR(20) NOT NULL UNIQUE,
    password CHAR(20) NOT NULL,
    PRIMARY KEY (id)
) ENGINE=InnoDB;

CREATE TABLE Setlists (
    id INT UNSIGNED NOT NULL UNIQUE AUTO_INCREMENT,
    dj_id  INT UNSIGNED NOT NULL,
    name CHAR(50) NOT NULL,
    status ENUM('open', 'closed', 'paused') NOT NULL DEFAULT 'open',
    time_start DATETIME NOT NULL,
    time_end DATETIME NOT NULL,
    PRIMARY KEY (id),
    FOREIGN KEY (dj_id) REFERENCES Djs(id)
) ENGINE=InnoDB;

CREATE TABLE Requests (
    id INT UNSIGNED NOT NULL UNIQUE AUTO_INCREMENT,
    setlist_id INT UNSIGNED NOT NULL,
    song_artist VARCHAR(30),
    song_title VARCHAR(50),
    status ENUM('pending', 'approved', 'denied') NOT NULL DEFAULT 'pending',
    votes_up INT UNSIGNED NOT NULL DEFAULT 0,
    votes_down INT UNSIGNED NOT NULL DEFAULT 0,
    PRIMARY KEY (id),
    FOREIGN KEY (setlist_id) REFERENCES Setlists(id)
) ENGINE=InnoDB;