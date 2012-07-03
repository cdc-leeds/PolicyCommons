var AVT = AVT || {};
(function (MODULE_NAME) {

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
    }

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
            }
        })(scripts)();
    }

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
        }

        var loadCSS = function (css) {
            var url = css_root + css;
            jQuery('<link/>', {
                rel: 'stylesheet',
                type: 'text/css',
                href: url
            }).appendTo('head');
        }

        // Load all script dependencies
        scripts.forEach(loadScript);

        // Load CSS styles
        styles.forEach(loadCSS);

        return toolbox_state;
    }

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
                onclick_handlers: {
                    "Issue": onClickIssue
                }
            }
            ARGVIZ.map.draw(config);
        }

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
                var config = {
                    data: data,
                    container: container
                }
                ARGVIZ.network.draw(config);
            }

            jQuery.getJSON(req_url, req_params, drawNetwork);
        }

        jQuery.getJSON(req_url, req_params, drawMap);

        return toolbox_state;
    }


    /**
       Called when component is no longer shown in toolbox
       */
    var stop = function (toolbox_state) {
        var div_id = toolbox_state.avt.div;
        jQuery(div_id).hide();
        return toolbox_state;
    }

    /**
       Called to check whether the tool can be stopped
       @return {Boolean}
       */
    var canBeStopped = function () {
        return true;
    }

    /**
       Called when the toolbox language changes
       */
    var languageChanged = function (lang) {
        // TODO Currently no other languages
        return false;
    }

    // Expose public API for component
    MODULE_NAME.init = init;
    MODULE_NAME.start = start;
    MODULE_NAME.stop = stop;
    MODULE_NAME.canBeStopped = canBeStopped;
    MODULE_NAME.languageChanged = languageChanged;
})(AVT)
