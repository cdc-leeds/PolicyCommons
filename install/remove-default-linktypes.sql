
--
ALTER TABLE LinkType MODIFY COLUMN LinkTypeID VARCHAR(60) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL;
ALTER TABLE LinkTypeGrouping MODIFY COLUMN LinkTypeID VARCHAR(60) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL DEFAULT 0;
ALTER TABLE Triple MODIFY COLUMN LinkTypeID VARCHAR(60) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL;


-- create all the link types for users
INSERT INTO LinkType (LinkTypeID,UserID,Label,CreationDate)
SELECT concat(left(replace(lt.Label,' ',''),9),u.UserID), u.UserID, lt.Label, UNIX_TIMESTAMP() FROM LinkType lt, Users u
WHERE lt.UserID='137108251921185179268'
AND concat(lt.Label,u.UserID) NOT IN (SELECT concat(lt2.Label,lt2.UserID) FROM LinkType lt2)

UPDATE LinkType SET LinkTypeID = Replace(LinkTypeID,'+','');

-- add in all the groupings
INSERT INTO LinkTypeGrouping (LinkTypeGroupID, LinkTypeID, UserID, CreationDate)
SELECT lgrp.LinkTypeGroupID, lt.LinkTypeID, lt.UserID, UNIX_TIMESTAMP() FROM LinkType lt
INNER JOIN (SELECT ltg.LinkTypeGroupID, lt2.Label FROM LinkTypeGrouping ltg INNER JOIN LinkType lt2 ON ltg.LinkTypeID = lt2.LinkTypeID WHERE lt2.UserID='137108251921185179268') lgrp ON lgrp.Label = lt.Label
WHERE lt.LinkTypeID NOT IN (SELECT LinkTypeID FROM LinkTypeGrouping)


-- update the existing linktypes
UPDATE Triple,
(SELECT t2.TripleID, lt2.LinkTypeID FROM LinkType lt2,
(SELECT TripleID,t.UserID, lt.Label FROM Triple t
INNER JOIN LinkType lt ON lt.LinkTypeID = t.LinkTypeID) t2
WHERE t2.Label = lt2.Label
AND lt2.UserID = t2.UserID) newID
SET Triple.LinkTypeID = newID.LinkTypeID
WHERE Triple.TripleID = newID.TripleID
