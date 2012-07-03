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

global $USER;
$urlid = required_param("urlid",PARAM_TEXT);

// default parameters
$start = optional_param("start",0,PARAM_INT);
$max = optional_param("max",20,PARAM_INT);
$orderby = optional_param("orderby","date",PARAM_ALPHA);
$sort = optional_param("sort","DESC",PARAM_ALPHA);

// filter parameters
$direction = optional_param("direction","right",PARAM_ALPHA);
$filtergroup = optional_param("filtergroup","",PARAM_TEXT);
$filterlist = optional_param("filterlist","",PARAM_TEXT);
$filternodetypes = optional_param("filternodetypes","",PARAM_TEXT);

// network search parameters
$netnodeid = optional_param("netnodeid","",PARAM_TEXT);
$netq = optional_param("netq","",PARAM_TEXT);
$netscope = optional_param("netscope","",PARAM_TEXT);
$netlinkgroup = optional_param("netlinkgroup","",PARAM_TEXT);
$netdepth = optional_param("netdepth",1,PARAM_INT);
$netdirection = optional_param("netdirection",'both',PARAM_TEXT);
$netlabelmatch = optional_param("netlabelmatch",'false',PARAM_TEXT);

$agentlastrun = optional_param("agentlastrun",'',PARAM_TEXT);

$url = getURL($urlid);
if ($url instanceof Error) {
    echo "<h1>URL not found</h1>";
    include_once("includes/footer.php");
    die;
}

$args = array();
$args["url"] = $url->url;

$args["start"] = $start;
$args["max"] = $max;
$args["orderby"] = $orderby;
$args["sort"] = $sort;

$args["direction"] = $direction;
$args["filtergroup"] = $filtergroup;
$args["filterlist"] = $filterlist;
$args["filternodetypes"] = $filternodetypes;

$args["netnodeid"] = $netnodeid;
$args["netq"] = $netq;
$args["netscope"] = $netscope;
$args["netlinkgroup"] = $netlinkgroup;
$args["netdepth"] = $netdepth;
$args["netdirection"] = $netdirection;
$args["netlabelmatch"] = $netlabelmatch;

$args["agentlastrun"] = $agentlastrun;

$args["title"] = $url->url;

?>

<div id="context">
  <div id="contextinfo">
    <h1><?php print $url->title; ?></h1>
    <a href="<?php print $url->url;?>" target="_blank">
      [External link]
    </a>

    <?php if ($url->description != "") { ?>
    <div id="desc_text">
       <?php echo $url->description; ?>
    </div>
    <?php } ?>
  </div>
</div>

<div style="clear:both;"></div>

<div id="tabber">
  <ul id="tabs" class="tab">
    <li class="tab">
      <a class="tab" id="tab-docview" href="#docview">
        <span class="tab">Document</span>
      </a>
    </li>
  </ul>
  <div id="tabs-content">
    <div id='tab-content-docview' class='tabcontent'>
      <div class="loading">
        <img src='<?php echo $CFG->homeAddress; ?>images/ajax-loader.gif'/>
        <br/>
        (Loading document...)
      </div>
    </div>
  </div>
</div>

<script type='text/javascript'>

  var CONTEXT = 'document';
  var NODE_ARGS = CONN_ARGS = NEIGHBOURHOOD_ARGS = NET_ARGS =
      URL_ARGS = USER_ARGS = <?php echo json_encode($args); ?>;

</script>

<script type='text/javascript'
        src='<?php echo $CFG->homeAddress?>includes/tabber.js' />

<?php include_once("includes/footer.php"); ?>