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
    array_push($HEADER,'<script src="'.$CFG->homeAddress.'includes/homepage.js" type="text/javascript"></script>');
    include_once("includes/header.php");
?>

<style type="text/css">
#tab-content-welcome {
    font-size: 140%; 
    font-weight:bold;   
}

#home1 {
    width: 250px;
    float: left;  
    margin: 10px; 
}
#home2 {
     width: 250px;
    float: left;  
    margin: 10px;  
}
#home3 {
     width: 250px;
    float: left;    
    margin: 10px; 
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
   color: #40B5B2;
   padding: 3px; 
   border: 1px solid #FACEE3;
}

li.option {
    color: #e80074;
    cursor:pointer;
    padding: 3px;
}
</style>
    <div id="tabber">
        <ul id="tabs" class="tab">
            <li class="tab"><a class="tab" id="tab-home" href="#home"><span class="tab">Home</span></a></li>
            <!-- li class="tab"><a class="tab" id="tab-welcome" href="#welcome"><span class="tab">Welcome</span></a></li -->
            <li class="tab"><a class="tab" id="tab-twitter" href="#twitter"><span class="tab">Twitter</span></a></li>
            <li class="tab"><a class="tab" id="tab-screencast" href="#screencast"><span class="tab">Screencasts</span></a></li>
            <li class="tab"><a class="tab" id="tab-node" href="#node"><span class="tab">Ideas</span></a></li>
            <li class="tab"><a class="tab" id="tab-conn" href="#conn"><span class="tab">Connections</span></a></li>
            <li class="tab"><a class="tab" id="tab-user" href="#user"><span class="tab">People &amp; Groups</span></a></li> 
        </ul>
        <div id="tabs-content">            
           <div id='tab-content-home' class='tabcontent'>

				<div style="float:left;">

					<div style="clear: both; float:left; margin-right: 15px;">
						<div id="tab-content-home-text" style="clear: both; float:left;">
						<strong>The Web is about IDEAS+PEOPLE.
						<br><br>Cohere is a visual tool to create, connect and share Ideas.
						<br><br>Discover who connects with your thinking!
						</strong><br><br><br>
						</div>

						<div style="clear:both; float:left;"><strong>Example Network View. Click <a href="http://cohere.open.ac.uk/group.php?connid=&userid=&nodeid=&url=&groupid=137108251480800349001234365781&q=&scope=all&focalnode=&start=0&max=-1&orderby=date&sort=DESC&netq=&netscope=&netnodeid=&direction=right#conn-net" target="_blank"> here </a>to see live version!</strong></div>
						<a style="clear:both; float:left;" href="http://cohere.open.ac.uk/group.php?connid=&userid=&nodeid=&url=&groupid=137108251480800349001234365781&q=&scope=all&focalnode=&start=0&max=-1&orderby=date&sort=DESC&netq=&netscope=&netnodeid=&direction=right#conn-net" target="_blank"><img src="images/home/homepage-network-sm.png" style="border:2px solid gray;" /></a>

					</div>
					
					<div id="tab-content-home-idea" style="float:left; width: 240px; margin-bottom: 15px;"><strong>Most Connected Idea:</strong><br></div>

					<div><strong>Top Connection Builders:</strong></div>
					<div id="tab-content-home-users" style="border: 1px solid #d3e8e8; clear: top; width: 240px; overflow: auto;"></div>
					<!-- div id="tab-content-home-users-ideas" style="clear: both; float:left; width: 260px; overflow: auto"><strong>Top 3 Idea Creators:</strong><br></div -->

					<div id="tab-content-home-conn" style="overflow: hidden; clear:both; float:left; width: 750px; margin: 0px; padding: 0px; margin-top:10px;"><strong>Most Recent Connection:</strong><br></div>

				</div>
				
				<div style="clear: top; float:left; margin: 0px; margin-top: 16px; margin-left: 5px;">
					<script src="http://widgets.twimg.com/j/2/widget.js"></script>
					<script>
					new TWTR.Widget({
					  version: 2,
					  type: 'profile',
					  rpp: 20,
					  interval: 6000,
					  width: 220,
					  height: 330,
					  theme: {
						shell: {
						  background: '#d3e8e8',
						  color: '#308d88'
						},
						tweets: {
						  background: '#ffffff',
						  color: '#308d88',
						  links: '#e80074'
						}
					  },
					  features: {
						scrollbar: true,
						loop: false,
						live: false,
						hashtags: true,
						timestamp: true,
						avatars: false,
						behavior: 'all'
					  }
					}).render().setUser('cohereweb').start();
					</script>   
				</div>
           </div>
           
           <!-- div id='tab-content-welcome' class='tabcontent'>
                <p>The Web is about IDEAS+PEOPLE.</p> 
                <p>Cohere is a visual tool to create, connect and share Ideas.</p> 
                <p>Back them up with websites. Support or challenge them. Embed them to spread virally.<br/> 
                Discover who - literally - connects with your thinking.</p> 
                <div id="steps">
                    <div id="home1"><img alt="" src="images/home/idea-blob-step1.png"/><br/>Publish <a href="index.php#node" onclick="setTabPushed('node')">ideas</a> and optionally add relevant websites</div>
                    <div id="home2"><img alt="" src="images/home/idea-blob-step2.png"/><br/>Weave webs of <a href="index.php#conn" onclick="setTabPushed('conn')">meaningful connections</a> between ideas: your own and the world's</div>
                    <div id="home3"><img alt="" src="images/home/idea-blob-step3.png"/><br/>Discover new <a href="index.php#node" onclick="setTabPushed('node')">ideas</a> and <a href="index.php#user" onclick="setTabPushed('user')">people</a></div>
                    <div style="clear:both;"></div>
                </div>
                
            </div -->
            
             <div id='tab-content-twitter' class='tabcontent'>
    
				<!-- div id="twitter">
				<ul id="twitter_update_list"></ul>
				<script type="text/javascript" src="http://twitter.com/javascripts/blogger.js"></script>
				<script type="text/javascript" src="http://twitter.com/statuses/user_timeline/coheretesting.json
				?callback=twitterCallback2&count=10"></script></div -->

				<div style="float:left; margin-right: 10px;">
					<script src="http://widgets.twimg.com/j/2/widget.js"></script>
					<script>
					new TWTR.Widget({
					  version: 2,
					  type: 'profile',
					  rpp: 40,
					  interval: 6000,
					  width: 250,
					  height: 300,
					  theme: {
						shell: {
						  background: '#307c88',
						  color: '#ffffff'
						},
						tweets: {
						  background: '#d3e8e8',
						  color: '#308d88',
						  links: '#e80074'
						}
					  },
					  features: {
						scrollbar: true,
						loop: false,
						live: false,
						hashtags: true,
						timestamp: true,
						avatars: false,
						behavior: 'all'
					  }
					}).render().setUser('cohereweb').start();
					</script>   
				</div>

				<div style="float:left; margin-right: 10px;">
					<script src="http://widgets.twimg.com/j/2/widget.js"></script>
					<script>
					new TWTR.Widget({
					  version: 2,
					  type: 'profile',
					  rpp: 40,
					  interval: 6000,
					  width: 250,
					  height: 300,
					  theme: {
						shell: {
						  background: '#307c88',
						  color: '#ffffff'
						},
						tweets: {
						  background: '#d3e8e8',
						  color: '#308d88',
						  links: '#e80074'
						}
					  },
					  features: {
						scrollbar: true,
						loop: false,
						live: false,
						hashtags: true,
						timestamp: true,
						avatars: false,
						behavior: 'all'
					  }
					}).render().setUser('coherestream').start();
					</script>  
				</div>

				<div style="float:left; margin-right: 10px;">
					<script src="http://widgets.twimg.com/j/2/widget.js"></script>
					<script>
					new TWTR.Widget({
					  version: 2,
					  type: 'search',
					  search: '#cohereweb OR @cohereweb',
					  interval: 6000,
					  title: 'Searching for #cohereweb / @cohereweb',
					  subject: 'Cohere Twitter Search',
					  width: 250,
					  height: 300,
					  theme: {
						shell: {
						  background: '#307c88',
						  color: '#ffffff'
						},
						tweets: {
						  background: '#d3e8e8',
						  color: '#308d88',
						  links: '#e80074'
						}
					  },
					  features: {
						scrollbar: true,
						loop: false,
						live: true,
						hashtags: true,
						timestamp: true,
						avatars: true,
						behavior: 'all'
					  }
					}).render().start();
					</script>								
				</div>
				
           </div>
           
            <div id='tab-content-screencast' class='tabcontent'>
                <h2>Screencasts</h2>
                
                <h3>Introduction to Cohere</h3>
                <div>
                    <div style="float:left;">
                        <object width="425" height="350"> <param name="movie" value="http://www.youtube.com/v/eBS03VoWWAA"> </param> <embed src="http://www.youtube.com/v/eBS03VoWWAA" type="application/x-shockwave-flash" width="425" height="350"> </embed> </object> 
                    </div>
                    <div style="float:left;padding:10px;">
                        <a href="<?php echo $CFG->homeAddress; ?>screencasts/intro/">View a high-resolution version (approx 67Mb)</a>
                    </div>
                    <div style="clear:both;"></div>
                </div>
                
                <h3>Other Screencasts</h3>
                
                <table class='table' cellspacing='0' cellpadding='3' border='0'>
                    <tr>
                        <td><b>How to add an Idea</b></td>
                        <td><div id="add-idea-sc"></div><span id="add-idea-sc-open" class="active">on YouTube</span><span id="add-idea-sc-close" class="active">close</span></td>
                        <td><a href="<?php echo $CFG->homeAddress; ?>screencasts/addidea/">View a high-resolution version (approx 24Mb)</a></td>
                    </tr>
                    <tr>
                        <td><b>How to add a Connection</b></td>
                        <td><div id="add-conn-sc"></div><span id="add-conn-sc-open" class="active">on YouTube</span><span id="add-conn-sc-close" class="active">close</span></td>
                        <td><a href="<?php echo $CFG->homeAddress; ?>screencasts/addconn/">View a high-resolution version (approx 26Mb)</a></td>
                    </tr>
                    <tr>
                        <td><b>How to add a Website</b></td>
                        <td><div id="add-url-sc"></div><span id="add-url-sc-open" class="active">on YouTube</span><span id="add-url-sc-close" class="active">close</span></td>
                        <td><a href="<?php echo $CFG->homeAddress; ?>screencasts/addurl/">View a high-resolution version (approx 21Mb)</a></td>
                    </tr>
                </table>
                <script type="text/javascript">
                    $('add-idea-sc-close').hide();
                    Event.observe('add-idea-sc-open','click', ytAddIdea);
                    Event.observe('add-idea-sc-close','click', ytAddIdeaC);
                    
                    $('add-conn-sc-close').hide();
                    Event.observe('add-conn-sc-open','click', ytAddConn);
                    Event.observe('add-conn-sc-close','click', ytAddConnC);
                    
                    $('add-url-sc-close').hide();
                    Event.observe('add-url-sc-open','click', ytAddURL);
                    Event.observe('add-url-sc-close','click', ytAddURLC);
                </script>
                
                
                More screencasts coming soon...
            </div>
            <div id='tab-content-node' class='tabcontent'>(Loading ideas...)</div>  
            <div id='tab-content-conn' class='tabcontent'>(Loading connections...)</div> 
            <div id='tab-content-user' class='tabcontent'>(Loading people and groups...)</div>

        </div>
    </div>        

    
<?php
    include_once("includes/footer.php");
?>