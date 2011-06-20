/*
Idea type was added to the Node table. This script makes sure all the idea type fields are
set to the NodeTypeID for the 'Idea' role for each user for their nodes
*/

UPDATE Node 
SET NodeTypeID =  
(SELECT NodeTypeID FROM NodeType WHERE NodeType.UserID = Node.UserID AND NodeType.Name = 'Idea')
WHERE EXISTS
(SELECT NodeTypeID FROM NodeType WHERE NodeType.UserID = Node.UserID AND NodeType.Name = 'Idea')