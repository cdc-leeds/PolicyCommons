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

function loadMap(){

		// Load the Map data
	
		var args = Object.clone(NET_ARGS);
		args["start"] = 0;

		//get all (not just the normal 20 max)
		args["max"] = -1;
	
		//request to get the current connections  
	  var reqUrl = SERVICE_ROOT + "&method=getdebatecontents&" + Object.toQueryString(args);

		d3.json(reqUrl, function(cohereJson) {
				var d3Json = convertCohereNodesetJsonToD3(cohereJson);

				//set the count in tab header
      	$('map-elements-count').innerHTML = "";
      	$('map-elements-count').insert(cohereJson.nodeset[0].totalno);

				drawDebateMap(d3Json);
		});

}

function convertCohereNodesetJsonToD3 (cohereJson) {
		var d3Json = {
				children: []
		};

		var nodes = cohereJson.nodeset[0].nodes;

		for (var i=0, len=nodes.length; i<len; i++) {
				var newNode = Object.clone(nodes[i].cnode);
				d3Json.children.push(newNode);
		}

		return d3Json;
}

function drawDebateMap(data) {
	
		// Set width & height for SVG
		var debatemapDiv = new Element("div", {"id":"debatemap-div"});
		$("tab-content-debatemap").update(debatemapDiv);

		var w = $('tab-content-debatemap').offsetWidth - 30;
		var h = getWindowHeight();
		var color = d3.scale.category20();

		var vis = d3.select("#debatemap-div")
				.append("div")
				.style("position", "relative")
				.style("width", w + "px")
				.style("height", h + "px")
				.style("top", "10px")
				.style("left", "5px");

		vis.style("opacity", 1e-6)
				.transition()
				.duration(1000)
				.style("opacity", 1);

var treemap = d3.layout.treemap()
    .size([w, h])
    .sticky(true)
				.value(function(d) { return parseInt(d.connectedness); })
		// Sort so largest cell in treemap is at the top-left rather than
		// bottom right
				.sort(function(a, b) { return a.value - b.value});

  vis.data([data]).selectAll("div")
      .data(treemap.nodes)
    .enter().append("div")
      .call(cell);

function cell() {
  this
      .style("left", function(d) { return d.x + "px"; })
      .style("top", function(d) { return d.y + "px"; })
      .style("width", function(d) { return d.dx - 1 + "px"; })
      .style("height", function(d) { return d.dy - 1 + "px"; })
				.style("background", function(d) {
						var args = Object.clone(NET_ARGS);
						if (d.nodeid != undefined)
								// Sub-Debates (i.e. sections within a Debate) should
								// have a unique background colour in the treemap. But
								// Issues in a treemap should have the same background
								// colour as the Sub-Debate or section they are
								// contained in.
								return (d.role[0].role.name == "Issue") ?
												 color(args["nodeid"]) : color(d.nodeid); })
				.html(function(d) {
						return d.children ? null : ((d.role[0].role.name == "Debate") ?
								 "<a href='"+createDebateURL(d.nodeid)+"'>"+d.name+"</a>" :
								 "<a href='"+createNodeURL(d.nodeid)+"'>"+d.name+"</a>"); })

		//Move the following to CSS -- create class called "treemap-cell"
				.style("border", "solid 1px white")
				.style("font", "12px sans-serif")
				.style("line-height", "12px")
				.style("overflow", "hidden")
				.style("position", "absolute")
				.style("text-indent", "2px");
      //.attr("class", "treemap-cell");
}
}

loadMap();