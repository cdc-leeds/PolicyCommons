<?php
/********************************************************************************
 *                                                                              *
 *  (c) Copyright 2010 The Open University UK                                   *
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
include_once("config.php");
include_once("phplib/jmathai-twitter-async-12fa620/EpiCurl.php");
include_once("phplib/jmathai-twitter-async-12fa620/EpiOAuth.php");
include_once("phplib/jmathai-twitter-async-12fa620/EpiTwitter.php");

if(!isset($USER->userid)){
	header('Location: index.php');
	return;
}

$twitterObj = new EpiTwitter($CGF->TWITTER_CONSUMER_KEY, $CFG->TWITTER_CONSUMER_SECRET);
$twitterObj->setToken($_GET['oauth_token']);
$token = $twitterObj->getAccessToken();


// Store to database instead
$USER->updateTwitterAccount($token->oauth_token, $token->oauth_token_secret);

header('Location: profile.php');
return;

?>

