var AVT = AVT || {};
(function (MODULE_NAME) {

     // Augment Array type for older browsers
		 // https://developer.mozilla.org/en/JavaScript/Reference/Global_Objects/Array/forEach
     if ( !Array.prototype.forEach ) {
         Array.prototype.forEach = function(fn, scope) {
             for(var i = 0, len = this.length; i < len; ++i) {
                 fn.call(scope || this, this[i], i, this);
             }
         };
     }

    /**
     * Replace the normal jQuery getScript function with one that supports
     * debugging and which references the script files as external resources
     * rather than in-lining it.
     * 
     * @param url
     *            the URL of the java script resource to load
     * @param callback
     *            function called after the resource is completely loaded
     * @see: http://www.lockencreations.com/2011/07/02/cant-debug-imported-js-files-when-using-jquery-getscript/
     */
    var lazyLoadScriptResource = function (url, callback) {
        var head = document.getElementsByTagName("head")[0];

        var script = document.createElement("script");
        script.src = url;

        // Handle Script loading
        var done = false;

        // Attach handlers for all browsers
        script.onload = script.onreadystatechange = function()
        {
            if (!done && (!this.readyState || this.readyState == "loaded" || this.readyState == "complete"))
            {
                done = true;
                if (callback)
                {
                    callback();
                }

                // Handle memory leak in IE
                script.onload = script.onreadystatechange = null;
            }
        };

        head.appendChild(script);

        // We handle everything using the script element injection
        return undefined;
    };

    /**
       Function for loading scripts that depend on each other

       @param Array scripts List of script names, where 1st loads before last
       @param Function callback Function to be executed after all scripts loaded
     */
    var loadDependentScripts = function (scripts, callback) {
        var callback = callback || function () {};
        (function lds(scripts) {
            var scripts = scripts || [];
            return (!scripts.length) ? callback : function () {
                lazyLoadScriptResource(scripts[0], lds(scripts.slice(1)));
            };
        })(scripts)();
    };

    /**
       Initialise component and load dependencies (JS, CSS, etc.)
       */
    var init = function (toolbox_state) {
        var path = toolbox_state.avt.path;
        var script_root = path + '/includes/js/';
        var scripts = [
            'd3.v2.min.js',
            'textFlow.min.js',
            'spryMap.min.js',
            'tipTip.min.js',
            'ARGVIZ.map.js',
            'ARGVIZ.network.js'
        ];
        var css_root = path + '/includes/css/';
        var styles = [
            'tipTip.css',
            'ARGVIZ.map.css',
            'ARGVIZ.network.css'
        ];

        var loadScript = function (script) {
            var url = script_root + script;
            lazyLoadScriptResource(url);
        };

        var loadCSS = function (css) {
            var url = css_root + css;
            jQuery('<link/>', {
                rel: 'stylesheet',
                type: 'text/css',
                href: url
            }).appendTo('head');
        };

        // Load all script dependencies
        scripts.forEach(loadScript);

        // Load CSS styles
        styles.forEach(loadCSS);

        return toolbox_state;
    };

    /**
       Called every time the component is shown in toolbox
       */
    var start = function (toolbox_state) {
        var path = toolbox_state.avt.path;
        var div_id = toolbox_state.avt.div;
        var debate_id = toolbox_state.currentDebateId;
        var req_params = {
            method: 'getdebatecontents',
            nodeid: debate_id,
            format: 'json'
        };

        var req_url = path + '/api/service.php';

        var drawMap = function (raw_data) {
            var data = ARGVIZ.map.convertCohereData(raw_data);
            var config = {
                data: data,
                container: div_id,
                before: importArtData,
                onclick_handlers: {
                    "Issue": onClickIssue
                }
            };
            ARGVIZ.map.draw(config);
        };

        // XXX ART Import hard-coded with Bernd Groninger user
        // credentials.
        // @todo TODO Integrate with toolbox authentication
        var importArtData = function (d) {

            if (d.nodetype !== "Issue") {
                return;
            }

            var art_api = toolbox_state.art.path +
                '/php/api.php?/issues/' + d.nodeid;

            var postToCohere = function (data) {

                var req_params = {
                    method: 'artimport',
                    format: 'json',
                    data: data,
                    user: 'berndgroninger@email.com'
                };

                var processCohereOutput = function (cohere_json) {
                    var num_imported = cohere_json.connectionset &&
                        cohere_json.connectionset[0].num_imported;
                    d.num_responses = parseInt(d.num_responses, 10) +
                        parseInt(num_imported, 10);
                };

                jQuery.post(req_url, req_params, processCohereOutput, "json");
            };

            jQuery.get(art_api, {}, postToCohere, "text");
        };

        var onClickIssue = function (issue) {

            // Handler will be called with 'this' set to current DOM element
            // Use this DOM element as container
            var container = this;

            var req_params = {
                method: 'getconnectionsbyissuenode',
                nodeid: issue.nodeid,
                format: 'json'
            };

            var drawNetwork = function (raw_data) {
                var data = ARGVIZ.network.convertCohereData(raw_data);

                // Define callback for when nodes in network are
                // drawn. This callback selects those nodes for which
                // we can find the source-document where the text is
                // taken from. These nodes are made clickable so that
                // user can click to go straight to the
                // source-document. Note, source-documents are URLs in
                // the Cohere data model.
                var nodeSource = function (n) {
                    return n.urls &&
                        d3.select(this).each(function (n) {
                            n.url = n.urls[0].url.url;
                        })
                            .on("mouseover", function (n) {
                                this.style.textDecoration = "underline";
                                this.style.fontStyle = "italic";
                            })
                        .on("mouseout", function (n) {
                            this.style.textDecoration = "none";
                            this.style.fontStyle = "normal";
                        })
                        .on("click", function (n) {

                            var window_attr = 'width=800,height=600';

                            window.open(
                                n.url, 'SourceDocument', window_attr);

                        })
                        .style("cursor", "pointer");
                    };

                var config = {
                    data: data,
                    container: container,
                    node_fn: nodeSource
                };

                ARGVIZ.network.draw(config);
            };

            jQuery.getJSON(req_url, req_params, drawNetwork);
        };

        jQuery.getJSON(req_url, req_params, drawMap);

        return toolbox_state;
    };


    /**
       Called when component is no longer shown in toolbox
       */
    var stop = function (toolbox_state) {
        var div_id = toolbox_state.avt.div;
        jQuery('#'+div_id).html('');
        return toolbox_state;
    };

    /**
       Called to check whether the tool can be stopped
       @return {Boolean}
       */
    var canBeStopped = function () {
        return true;
    };

    /**
       Called when the toolbox language changes
       */
    var languageChanged = function (lang) {
        // TODO Currently no other languages
        return false;
    };

    // Expose public API for component
    MODULE_NAME.init = init;
    MODULE_NAME.start = start;
    MODULE_NAME.stop = stop;
    MODULE_NAME.canBeStopped = canBeStopped;
    MODULE_NAME.languageChanged = languageChanged;
})(AVT);
