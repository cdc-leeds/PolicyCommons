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
    include_once("includes/header.php");
    global $CFG;
?>

<h1>Contact</h1>

<p>If you would like to report a bug or have a suggestion for improvement to Cohere,
then please visit our <a href="<?php print($CFG->supportAddress);?>">support site</a></p>
<p>Otherwise, to contact the Cohere team please email: <a href="mailto:<?php echo $CFG->EMAIL_REPLY_TO; ?>"><?php echo $CFG->EMAIL_REPLY_TO; ?></a></p>

<h2>User Groups</h2>
    <p>To discuss how Cohere can be used and make contact with other Cohere practitioners and research, please join our <a href="http://groups.google.com/group/coheregroup">Cohere group</a>.
    <ul><li>To subscribe to the Cohere group send an e-mail to: <a href="mailto:coheregroup@googlegroups.com">coheregroup@googlegroups.com</a></li>
    <li>To unsubscribe from the Cohere group send an e-mail to: <a href="mailto:coheregroup+unsubscribe@googlegroups.com">coheregroup+unsubscribe@googlegroups.com</a></li></ul></p> 

    <p>We also have a separate <a href="http://groups.google.com/group/coheredev">Cohere developer group</a> for people wishing to discuss the Cohere API.
    <ul><li>To subscribe to the Cohere developers group send an e-mail to: <a href="mailto:coheredev@googlegroups.com">coheredev@googlegroups.com</a></li>
    <li>To unsubscribe from the Cohere developers group send an e-mail to: <a href="mailto:coheredev+unsubscribe@googlegroups.com">coheredev+unsubscribe@googlegroups.com</a></li></ul></p> 
<?php
    include_once("includes/footer.php");
?>