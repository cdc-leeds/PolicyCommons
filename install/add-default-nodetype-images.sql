/*
Sets the idea type images used for the default Compendium idea types
*/

update NodeType set Image='images/nodetypes/Default/position-32x32.png' Where Name='Idea';
update NodeType set Image='images/nodetypes/Default/position-32x32.png' Where Name='Answer';
update NodeType set Image='images/nodetypes/Default/issue-32x32.png' Where Name='Question';
update NodeType set Image='images/nodetypes/Default/plus-32x32.png' Where Name='Pro';
update NodeType set Image='images/nodetypes/Default/minus-32x32.png' Where Name='Con';
update NodeType set Image='images/nodetypes/Default/argument-32x32.png' Where Name='Argument';
update NodeType set Image='images/nodetypes/Default/decision-32x32.png' Where Name='Decision';
update NodeType set Image='images/nodetypes/Default/reference-32x32.png' Where Name='Reference';
update NodeType set Image='images/nodetypes/Default/note-32x32.png' Where Name='Note';
update NodeType set Image='images/nodetypes/Default/map-32x32.png' Where Name='(Compendium Map)';
update NodeType set Image='images/nodetypes/Default/list-32x32.png' Where Name='(Compendium List)';