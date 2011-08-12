<?php
/********************************************************************************
 *                                                                              *
 *  (c) Copyright 2011 University of Leeds, UK                                  *
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
    array_push($HEADER,'<script src="'.$CFG->homeAddress.'includes/homepage.js" type="text/javascript"></script>');
    include_once("includes/header.php");
?>

<style type="text/css">
#tab-content-welcome {
    font-size: 140%;
    font-weight:bold;
}

.hi-light {
    color: #e80074;
}

ul.home-node-head-list {
   list-style:none;
   margin: 0px 0px 0px 15px;
   padding: 3px;
}

li.home-node-head-item {
   font-weight: bold;
   display:inline;
   margin-left: 10px;
}

li.current {
   color: #85C042;
   padding: 3px;
   border: 1px solid #7F0000;
}

li.option {
    color: #7F0000;
    cursor:pointer;
    padding: 3px;
}
</style>
    <div id="tabber">
        <ul id="tabs" class="tab">
            <li class="tab"><a class="tab" id="tab-home" href="#home"><span class="tab">Home</span></a></li>
            <!-- li class="tab"><a class="tab" id="tab-welcome" href="#welcome"><span class="tab">Welcome</span></a></li -->
            <li class="tab"><a class="tab" id="tab-node" href="#node"><span class="tab">Ideas</span></a></li>
            <li class="tab"><a class="tab" id="tab-conn" href="#conn"><span class="tab">Connections</span></a></li>
            <li class="tab"><a class="tab" id="tab-user" href="#user"><span class="tab">People &amp; Groups</span></a></li>
        </ul>
        <div id="tabs-content">
           <div id='tab-content-home' class='tabcontenthome'>
			  <div style="float:left;">

				<div style="float:left; padding-left: 5px;">
<p>PolicyCommons is a tool that displays arguments about policies as
browsable debate maps. It is designed to help users make sense of the
range of publicly expressed opinions about public policies.</p>

<p>Users can browse debate maps about public policies and follow links
from the visual summaries of the arguments back to the original policy
documents. Ultimately, the aim of PolicyCommons is to support greater
	participation in the democrative process, as well as to improve the
	openness and accountability of the democratic process.</p>

				</div>


				<div id="tab-content-home-conn" style="overflow: hidden; clear:both; float:left; width: 740px; padding-right: 5px: 0px; padding: 0px; margin-top:10px; margin-left: 5px;">
					<div style="margin-bottom:10px; height: 20px; background:#F8EAF3; padding-left: 5px; padding-top: 4px; "><strong>Most Recent Connection</strong></div>
				</div>
			 </div>
           </div>


            <div id='tab-content-node' class='tabcontent'>(Loading ideas...)</div>
            <div id='tab-content-conn' class='tabcontent'>(Loading connections...)</div>
            <div id='tab-content-user' class='tabcontent'>(Loading people and groups...)</div>

        </div>
    </div>


<?php
    include_once("includes/footer.php");
?>