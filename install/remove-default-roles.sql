
/*
Script to move all the default roles from the default user to be members of the actual users profile
Will update all the existing references to the node types in the db.
*/

-- WARNING - this may take some time to run!!

-- firstly recreate the default roles for each user 
-- (where they don't already exist for that user)

INSERT INTO NodeType (NodeTypeID,UserID,Name,CreationDate)
SELECT concat(left(nt.Name,5),u.UserID), u.UserID, nt.Name, UNIX_TIMESTAMP() FROM NodeType nt, Users u
WHERE nt.UserID='137108251921185179268'
AND concat(nt.Name,u.UserID) NOT IN (SELECT concat(nt2.Name,nt2.UserID) FROM NodeType nt2)

-- add in all the node type groupings
INSERT INTO  NodeTypeGrouping (NodeTypeGroupID, NodeTypeID,UserID,CreationDate)
SELECT '13710825192129', NodeTypeID, UserID, UNIX_TIMESTAMP() FROM NodeType
WHERE NodeType.NodeTypeID NOT IN (SELECT NodeTypeID FROM NodeTypeGrouping)

-- now update the Triple FromContextNodeTypeID
UPDATE Triple,
(SELECT t2.TripleID, nt2.NodeTypeID FROM NodeType nt2,
(SELECT TripleID,t.UserID, nt.Name FROM Triple t
INNER JOIN NodeType nt ON nt.NodeTypeID = t.FromContextTypeID) t2
WHERE t2.Name = nt2.Name
AND nt2.UserID = t2.UserID ) newID
SET Triple.FromContextTypeID = newID.NodeTypeID
WHERE Triple.TripleID = newID.TripleID


-- now update the Triple ToContextNodeTypeID
UPDATE Triple,
(SELECT t2.TripleID, nt2.NodeTypeID FROM NodeType nt2,
(SELECT TripleID,t.UserID, nt.Name FROM Triple t
INNER JOIN NodeType nt ON nt.NodeTypeID = t.ToContextTypeID) t2
WHERE t2.Name = nt2.Name
AND nt2.UserID = t2.UserID ) newID
SET Triple.ToContextTypeID = newID.NodeTypeID
WHERE Triple.TripleID = newID.TripleID


