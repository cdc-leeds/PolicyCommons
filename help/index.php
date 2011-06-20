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
    include_once("../config.php");
    include_once("../includes/header.php");
?>

    <h1>Help</h1>

    <p>For help getting started with Cohere, then please have a look at <a href="<?php print($CFG->homeAddress)?>index.php#screencast">our screencasts</a>.</p>

    <p>For details of how to use our RESTful API, please visit the <a href="code-doc/Cohere-API/apilib.html">API documentation</a>. </p>

    <p>For help with using RDF with Cohere, please visit out <a href="rdf.php">RDF how-to</a>.</p>

    <p>If you would like to report a bug or have suggestions for improvements to Cohere, then please visit our <a href="<?php print($CFG->supportAddress)?>">support site</a>.</p>

    <p>If your query isn't answered by any of the above, then please <a href="mailto:<?php print($CFG->EMAIL_REPLY_TO)?>">contact us</a>.</p>

<?php
    include_once("../includes/footer.php");
?>