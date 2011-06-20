INSERT INTO URL (URLID,UserID,CreationDate,URL,Title) 
SELECT concat(CreationDate,UserID), UserID, UNIX_TIMESTAMP(), Image, Image FROM URL
WHERE Image IS NOT NULL AND Image NOT IN('http://', '') AND UserID != '';

INSERT INTO URLNode (URLID,UserID,CreationDate,NodeID) 
SELECT concat(t1.CreationDate,t1.UserID), t1.UserID, UNIX_TIMESTAMP(), t2.NodeID NodeID FROM URL as t1, URLNode t2
WHERE t1.URLID = t2.URLID AND t1.Image IS NOT NULL AND t1.Image NOT IN('http://', '') AND t1.UserID != '';