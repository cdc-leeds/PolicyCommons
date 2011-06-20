/********************************************************************************
 *                                                                              *
 *  (c) Copyright 2009 The Open University UK                                   *
 *                                                                              *
 *  This software is freely distributed in accordance with                      *
 *  the GNU Lesser General Public (LGPL) license, version 3 or later            *
 *  as published by the Free Software Foundation.                               *
 *  For details see LGPL: http://www.fsf.org/licensing/licenses/lgpl.html       *
 *               and GPL: http://www.fsf.org/licensing/licenses/gpl-3.0.html    *
 *                                                                              *
 *  This software is provided by the copyright holders and contributors "as is" *
 *  and any express or implied warranties, including, but not limited to, the   *
 *  implied warranties of merchantability and fitness for a particular purpose  *
 *  are disclaimed. In no event shall the copyright owner or contributors be    *
 *  liable for any direct, indirect, incidental, special, exemplary, or         *
 *  consequential damages (including, but not limited to, procurement of        *
 *  substitute goods or services; loss of use, data, or profits; or business    *
 *  interruption) however caused and on any theory of liability, whether in     *
 *  contract, strict liability, or tort (including negligence or otherwise)     *
 *  arising in any way out of the use of this software, even if advised of the  *
 *  possibility of such damage.                                                 *
 *                                                                              *
 ********************************************************************************/
-- dummy users, nodes, groups data for testing the security and select queries with

-- create the users and groups (note that the password for each user is testuser)
INSERT INTO Users 
(UserID, CreationDate, ModificationDate, Email, Name, Description, Password, LastLogin, IsAdministrator, CurrentStatus, Website, Photo, Private, AuthType, OpenIDURL) 
VALUES 
('group1', 1205506269, 1205506269, 'group1@alex.com', 'Group1', '', '$1$6r3.Vt..$kpZY3HgJzZ4QLrs45eeoP1', 1205506269, 'N', 0, 'profile.png', NULL, 'N', 'cohere', NULL),
('group2', 1205506291, 1205506291, 'group2@alex.com', 'Group2', '', '$1$ro/.Y84.$jEW1zFVyUX0rd3SFrP1gw/', 1205506291, 'N', 0, 'profile.png', NULL, 'N', 'cohere', NULL),
('usera', 1205506090, 1205506090, 'usera@alex.com', 'UserA', '', '$1$Nl5.S.2.$H9TzEqcDASZa39AIwHziH1', 1205506090, 'N', 0, 'profile.png', NULL, 'N', 'cohere', NULL),
('userb', 1205506144, 1205506144, 'userb@alex.com', 'UserB', '', '$1$DA3.Qy/.$AB4jWJIwryZxTa7i5hP240', 1205506144, 'N', 0, 'profile.png', NULL, 'N', 'cohere', NULL),
('userc', 1205506166, 1205506166, 'userc@alex.com', 'UserC', '', '$1$WH1.n//.$MM0IvjZLTUtwQA6SzH06G.', 1205506166, 'N', 0, 'profile.png', NULL, 'N', 'cohere', NULL),
('userd', 1205506186, 1205506186, 'userd@alex.com', 'UserD', '', '$1$bV/.IM5.$9xqN.YdXYnLZ/avHFl4qt/', 1205506186, 'N', 0, 'profile.png', NULL, 'N', 'cohere', NULL),
('usere', 1205506207, 1205506207, 'usere@alex.com', 'UserE', '', '$1$aN2.bq1.$8cj/zkEDkeIr6CopM/Yot0', 1205506207, 'N', 0, 'profile.png', NULL, 'N', 'cohere', NULL),
('userf', 1205506229, 1205506229, 'userf@alex.com', 'UserF', '', '$1$Nu..SJ..$ByZ3gXC5wffI8hCoCwRgZ1', 1205506229, 'N', 0, 'profile.png', NULL, 'N', 'cohere', NULL);

-- create user group relationships
INSERT INTO UserGroup
(GroupID,UserID,CreationDate,IsAdmin)
VALUES
('group1','usera',0,'Y'),
('group1','userb',0,'N'),
('group2','userc',0,'N'),
('group2','userd',0,'N'),
('group1','usere',0,'N'),
('group2','usere',0,'Y');


-- create Nodes
INSERT INTO Tag
(TagID,UserID,Name,Private)
VALUES
('NodeT1','usera','Node T1 name','Y'),
('NodeT2','usera','Node T2 name','N'),
('NodeT3','usera','Node T3 name','Y'),
('NodeT4','usera','Node T4 name','N'),
('NodeT5','usere','Node T5 name','Y'),
('NodeT6','usere','Node T6 name','N'),
('NodeT7','usere','Node T7 name','Y'),
('NodeT8','usere','Node T8 name','N'),
('NodeT9','usere','Node T9 name','Y'),
('NodeT10','usere','Node T10 name','N'),
('NodeT11','usere','Node T11 name','Y'),
('NodeT12','usere','Node T12 name','N'),
('NodeT13','userf','Node T13 name','Y'),
('NodeT14','userf','Node T14 name','N'),
('NodeT1a','usera','Node T1a name','Y'),
('NodeT2a','usera','Node T2a name','N'),
('NodeT3a','usera','Node T3a name','Y'),
('NodeT4a','usera','Node T4a name','N'),
('NodeT5a','usere','Node T5a name','Y'),
('NodeT6a','usere','Node T6a name','N'),
('NodeT7a','usere','Node T7a name','Y'),
('NodeT8a','usere','Node T8a name','N'),
('NodeT9a','usere','Node T9a name','Y'),
('NodeT10a','usere','Node T10a name','N'),
('NodeT11a','usere','Node T11a name','Y'),
('NodeT12a','usere','Node T12a name','N'),
('NodeT13a','userf','Node T13a name','Y'),
('NodeT14a','userf','Node T14a name','N');

-- make up some create and modify dates and descriptions for some nodes
UPDATE Tag Set CreationDate = FLOOR(RAND() * unix_timestamp());
UPDATE Tag Set ModificationDate = FLOOR(CreationDate + RAND() * (unix_timestamp() - CreationDate));
UPDATE Tag SET Description = CONCAT('Description of ',Name) WHERE CreationDate mod 2 = 1;

-- create node-group relationships
INSERT INTO TagGroup
(TagID,GroupID,CreationDate)
VALUES
('NodeT3','group1',0),
('NodeT4','group1',0),
('NodeT5','group1',0),
('NodeT6','group1',0),
('NodeT7','group2',0),
('NodeT8','group2',0),
('NodeT9','group1',0),
('NodeT9','group2',0),
('NodeT10','group1',0),
('NodeT10','group2',0),
('NodeT3a','group1',0),
('NodeT4a','group1',0),
('NodeT5a','group1',0),
('NodeT6a','group1',0),
('NodeT7a','group2',0),
('NodeT8a','group2',0),
('NodeT9a','group1',0),
('NodeT9a','group2',0),
('NodeT10a','group1',0),
('NodeT10a','group2',0);


-- Connections
INSERT INTO Triple
(TripleID,LinkTypeID,FromID,ToID, Label,FromContextTypeID,ToContextTypeID,UserID,FromLabel,ToLabel,Private)
VALUES
('ConnC1','presetlinktype19','NodeT1','NodeT1a','ConnC1','presetrole01','presetrole01','usera','Node T1 name','Node T1a name','Y'),
('ConnC2','presetlinktype19','NodeT1','NodeT1a','ConnC2','presetrole01','presetrole01','usera','Node T1 name','Node T1a name','N'),
('ConnC3','presetlinktype19','NodeT3','NodeT3a','ConnC3','presetrole01','presetrole01','usera','Node T3 name','Node T3a name','Y'),
('ConnC4','presetlinktype19','NodeT3','NodeT3a','ConnC4','presetrole01','presetrole01','usera','Node T3 name','Node T3a name','N'),
('ConnC5','presetlinktype19','NodeT5','NodeT5a','ConnC5','presetrole01','presetrole01','usere','Node T5 name','Node T5a name','Y'),
('ConnC6','presetlinktype19','NodeT5','NodeT5a','ConnC6','presetrole01','presetrole01','usere','Node T5 name','Node T5a name','N'),
('ConnC7','presetlinktype19','NodeT7','NodeT7a','ConnC7','presetrole01','presetrole01','usere','Node T7 name','Node T7a name','Y'),
('ConnC8','presetlinktype19','NodeT7','NodeT7a','ConnC8','presetrole01','presetrole01','usere','Node T7 name','Node T7a name','N'),
('ConnC9','presetlinktype19','NodeT9','NodeT9a','ConnC9','presetrole01','presetrole01','usere','Node T9 name','Node T9a name','Y'),
('ConnC10','presetlinktype19','NodeT9','NodeT9a','ConnC10','presetrole01','presetrole01','usere','Node T9 name','Node T9a name','N'),
('ConnC11','presetlinktype19','NodeT7','NodeT7a','ConnC11','presetrole01','presetrole01','usere','Node T7 name','Node T7a name','Y'),
('ConnC12','presetlinktype19','NodeT7','NodeT7a','ConnC12','presetrole01','presetrole01','usere','Node T7 name','Node T7a name','N'),
('ConnC13','presetlinktype19','NodeT13','NodeT13a','ConnC13','presetrole01','presetrole01','userf','Node T13 name','Node T13a name','Y'),
('ConnC14','presetlinktype19','NodeT13','NodeT13a','ConnC14','presetrole01','presetrole01','userf','Node T13 name','Node T13a name','N'),
('ConnC15','presetlinktype19','NodeT1','NodeT2','ConnC15','presetrole01','presetrole01','usera','Node T1 name','Node T2 name','Y'),
('ConnC16','presetlinktype19','NodeT1','NodeT2','ConnC16','presetrole01','presetrole01','usera','Node T1 name','Node T2 name','N'),
('ConnC17','presetlinktype19','NodeT3','NodeT4','ConnC17','presetrole01','presetrole01','usera','Node T3 name','Node T4 name','Y'),
('ConnC18','presetlinktype19','NodeT3','NodeT4','ConnC18','presetrole01','presetrole01','usera','Node T3 name','Node T4 name','N'),
('ConnC19','presetlinktype19','NodeT5','NodeT6','ConnC19','presetrole01','presetrole01','usere','Node T5 name','Node T6 name','Y'),
('ConnC20','presetlinktype19','NodeT5','NodeT6','ConnC20','presetrole01','presetrole01','usere','Node T5 name','Node T6 name','N'),
('ConnC21','presetlinktype19','NodeT7','NodeT8','ConnC21','presetrole01','presetrole01','usere','Node T7 name','Node T8 name','Y'),
('ConnC22','presetlinktype19','NodeT7','NodeT8','ConnC22','presetrole01','presetrole01','usere','Node T7 name','Node T8 name','N'),
('ConnC23','presetlinktype19','NodeT9','NodeT10','ConnC23','presetrole01','presetrole01','usere','Node T9 name','Node T10 name','Y'),
('ConnC24','presetlinktype19','NodeT9','NodeT10','ConnC24','presetrole01','presetrole01','usere','Node T9 name','Node T10 name','N'),
('ConnC25','presetlinktype19','NodeT7','NodeT8','ConnC25','presetrole01','presetrole01','usere','Node T7 name','Node T8 name','Y'),
('ConnC26','presetlinktype19','NodeT7','NodeT8','ConnC26','presetrole01','presetrole01','usere','Node T7 name','Node T8 name','N'),
('ConnC27','presetlinktype19','NodeT13','NodeT14','ConnC27','presetrole01','presetrole01','userf','Node T13 name','Node T14 name','Y'),
('ConnC28','presetlinktype19','NodeT13','NodeT14','ConnC28','presetrole01','presetrole01','userf','Node T13 name','Node T14 name','N');


-- create connection-group relationships
INSERT INTO TripleGroup
(TripleID,GroupID,CreationDate)
VALUES
('ConnC3','group1',0),
('ConnC4','group1',0),
('ConnC5','group1',0),
('ConnC6','group1',0),
('ConnC7','group2',0),
('ConnC8','group2',0),
('ConnC9','group1',0),
('ConnC9','group2',0),
('ConnC10','group1',0),
('ConnC10','group2',0),
('ConnC17','group1',0),
('ConnC18','group1',0),
('ConnC19','group1',0),
('ConnC20','group1',0),
('ConnC21','group2',0),
('ConnC22','group2',0),
('ConnC23','group1',0),
('ConnC23','group2',0),
('ConnC24','group1',0),
('ConnC24','group2',0);

-- some urls
INSERT INTO URL
(URLID,UserID,CreationDate,URL,Title)
VALUES
('url1','usera',0,'http://google.com','Google'),
('url2','usera',0,'http://bbc.co.uk','BBC'),
('url3','usera',0,'http://www.open.ac.uk','OU'),
('url4','usera',0,'http://cohere.open.ac.uk','Cohere'),
('url5','userb',0,'http://google.com','Google'),
('url6','userb',0,'http://www.open.ac.uk','OU');

-- url - node relationships
INSERT INTO URLTag
(UserID,URLID,TagID,CreationDate)
VALUES
('usera','url1','NodeT1',0),
('usera','url2','NodeT1',0),
('usera','url3','NodeT1',0),
('usera','url4','NodeT1',0),
('usera','url1','NodeT2',0),
('usera','url2','NodeT2',0),
('usera','url3','NodeT3',0),
('usera','url4','NodeT3',0);