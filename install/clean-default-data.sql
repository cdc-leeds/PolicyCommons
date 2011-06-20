/*
These are default idea and link type which are to be removed from the default user and therefore 
from being added to new users.
*/

DELETE FROM NodeType WHERE UserID='137108251921185179268' AND Name='Answer';
DELETE FROM NodeTypeNodeType WHERE UserID='137108251921185179268' AND Name='Framework';
DELETE FROM NodeType WHERE UserID='137108251921185179268' AND Name='Ideology';
DELETE FROM NodeType WHERE UserID='137108251921185179268' AND Name='Problem';
DELETE FROM NodeType WHERE UserID='137108251921185179268' AND Name='Solution';
DELETE FROM NodeType WHERE UserID='137108251921185179268' AND Name='Natural Phenomenon';

DELETE FROM LinkType WHERE UserID='137108251921185179268' AND Label='is part of';
DELETE FROM LinkType WHERE UserID='137108251921185179268' AND Label='is similar in spirit to';
DELETE FROM LinkType WHERE UserID='137108251921185179268' AND Label='reminds me of';
DELETE FROM LinkType WHERE UserID='137108251921185179268' AND Label='is a metaphor for';
DELETE FROM LinkType WHERE UserID='137108251921185179268' AND Label='has sub-problem';
DELETE FROM LinkType WHERE UserID='137108251921185179268' AND Label='has counterexample';
DELETE FROM LinkType WHERE UserID='137108251921185179268' AND Label='addresses the problem';
