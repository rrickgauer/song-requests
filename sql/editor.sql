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
union
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


(select Djs.id as id, Djs.username, null as name, null as status
from Djs 
order by Djs.username asc
limit 10)

union 

(select null, null, null, null)

union 

(select Setlists.id, Djs.username, Setlists.name, Setlists.status
from Setlists
left join Djs on Setlists.dj_id = Djs.id 
group by Setlists.id 
order by Setlists.name asc
limit 10)


