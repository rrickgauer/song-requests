(SELECT Djs.id AS id,
        Djs.username,
        NULL   AS name,
        NULL   AS status
 FROM   Djs
 LIMIT  5)
UNION

(select NULL,
        null,
        null,
        null)
(SELECT Setlists.id,
        Djs.username,
        Setlists.name,
        Setlists.status
 FROM   Setlists
        LEFT JOIN Djs
               ON Setlists.dj_id = Djs.id
 GROUP  BY Setlists.id
 ORDER  BY Setlists.time_end
 LIMIT  5) 