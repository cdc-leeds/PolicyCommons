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
?>
<ul id="snippet-footer">
	<li><input type="image" alt="View in context - new window" id="displayContextButton" onclick="displayContext()" onkeypress="enterKeyPressed(event)" border="0" src="../../../images/full_screen.png" title="View in context" /></li>
	<li><input type="image" alt="Get URL - popup" id="displayURLButton" onclick="displayURL()" onkeypress="enterKeyPressed(event)" border="0" src="../../../images/link-slim.png" title="Get URL" /></li>
	<li><input type="image" alt="Get Snippet Code - popup" id="displaySnippetButton" onclick="displaySnippet()" onkeypress="enterKeyPressed(event)" border="0" src="../../../images/snippet-slim.png" title="Get Snippet Code" /></li>
    <li><a href="<?php echo $CFG->homeAddress; ?>" target="_blank"><img alt="Go to the Cohere website - new window" title="Go to the Cohere website - new window" src="../../../images/cohere-logo-snippet.png" /></a></li>
</ul>
<div style="clear:both;"></div>
</div>

<!-- Google analytics -->
<script type="text/javascript">
var gaJsHost = (("https:" == document.location.protocol) ? "https://ssl." : "http://www.");
document.write(unescape("%3Cscript src='" + gaJsHost + "google-analytics.com/ga.js' type='text/javascript'%3E%3C/script%3E"));
</script>
<script type="text/javascript">
if (typeof(_gat)=="object") {
    var pageTracker = _gat._getTracker("<?php print($CFG->GOOGLE_ANALYTICS_KEY);?>");
    pageTracker._initData();
    pageTracker._trackPageview();
}
</script>

</body>
</html>