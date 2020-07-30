  SELECT    Setlists.id,
            Setlists.dj_id,
            Setlists.name,
            Setlists.status,
            Setlists.time_start,
            Setlists.time_end,
            DATE_FORMAT(Setlists.time_start, "%c/%d/%Y") AS time_start_display_date,
            DATE_FORMAT(Setlists.time_start, "%l:%i %p") AS time_start_display_time,
            DATE_FORMAT(Setlists.time_end, "%c/%d/%Y")   AS time_end_display_date,
            DATE_FORMAT(Setlists.time_end, "%l:%i %p")   AS time_end_display_time,
            Djs.username,
            (
                   SELECT COUNT(Requests.id)
                   FROM   Requests
                   WHERE  Requests.setlist_id=Setlists.id) AS count_status_all,
            (
                   SELECT COUNT(Requests.id)
                   FROM   Requests
                   WHERE  Requests.setlist_id=Setlists.id
                   AND    Requests.status="approved") AS count_status_approved,
            (
                   SELECT COUNT(Requests.id)
                   FROM   Requests
                   WHERE  Requests.setlist_id=Setlists.id
                   AND    Requests.status="denied") AS count_status_denied,
            (
                   SELECT COUNT(Requests.id)
                   FROM   Requests
                   WHERE  Requests.setlist_id=Setlists.id
                   AND    Requests.status="pending") AS count_status_pending
  FROM      Setlists
  LEFT JOIN Djs
  ON        Setlists.dj_id = Djs.id
  WHERE     Setlists.id = :id
  GROUP BY  Setlists.id
  LIMIT     1