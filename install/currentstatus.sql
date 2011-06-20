/*
Script to move all the records marked with CurrentStatus = 1 (i.e. deleted)
*/

// need to specify the database name here as 'set' is a SQL reserved word
DELETE FROM cohere.Set WHERE CurrentStatus = 1;

DELETE FROM Node WHERE CurrentStatus = 1;

DELETE FROM Triple WHERE CurrentStatus = 1;

DELETE FROM URL WHERE CurrentStatus = 1;

DELETE FROM URLNode WHERE CurrentStatus = 1;

DELETE FROM Users WHERE CurrentStatus = 1;
