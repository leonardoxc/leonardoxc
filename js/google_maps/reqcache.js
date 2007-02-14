// arch-tag: e811a872-33f7-463a-b023-0d2d5e4cbc4f
//
// Copyright (c) 2005 Mike Kenney
// released under GPL

// Implement a proper conditional-GET for XMLHttpRequest as this feature
// appears to be broken in both major browsers. Mozilla always re-fetches
// the document and IE always gets the document from the cache.
//
// To use, simply instantiate an object, the constructor needs to be passed
// a factory function for an XMLHttpRequest object:
//
//    var cache = new ReqCache(function() { return GXmlHttp.create(); });
//
// The only method you really need after that is cache.fetch():
//
//    cache.fetch(url, function(proc_contents) { ...}, 
//                     function(req) { ...},
//                     function(contents) {...});
//
// The first argument is the URL string, the second argument is a function
// which is passed the (possibly processed) contents of the request. The third 
// argument is an error-callback, this function is called if the server returns 
// a status code other than 200 or 304 and is passed the XMLHttpRequest object. 
// The fourth argument is a processing function and is passed the "contents" of
// the request. The output of this function (if present) is what is actually
// stored in the cache and passed to the first callback.
//
// Note that the "contents" is normally an XML DOM Document but may be a string 
// (if the mime-type of the response was not text/xml). .
//
function ReqCache(reqfactory) {

    // Mozilla throws an exeception for non-existent headers...
    function get_header(req, name) {
        try {
            return req.getResponseHeader(name);
        } catch(e) {
            return "";
        }
    }

    this.reqfactory = reqfactory;
    this.entries = new Array();
    this.access = 0;
    this.hits = 0;

    this.addEntry = function(props, key) {
        var obj = new Array();
        for(var pkey in props) {
            obj[pkey] = props[pkey];
        }
        this.entries[key] = obj;
    };

    this.getEntry = function(key) {
        return this.entries[key];
    };

    this.flush = function(oldest) {
        if(!oldest) {
	    this.entries = new Array();
            return;
        }

        for(var key in this.entries) {
            if((this.entries[key].ctime - oldest) < 0)
                delete this.entries[key];
        }
    };

    this.stats = function() {
        return [this.access, this.hits, this.entries.length];
    }

    this.fetch = function(url, cback, err, f_proc) {
        var req = this.reqfactory();
        var e = this.getEntry(url);
        var cache = this;

        if(!f_proc)
	    f_proc = function(x) { return x; };

        req.open("GET", url, true);
        if(e) {
            if(e.modtime)
                req.setRequestHeader("If-Modified-Since", e.modtime);
            if(e.etag)
                req.setRequestHeader("If-None-Match", e.etag);
        }
        req.onreadystatechange = function() {
            if(req.readyState == 4) {
                cache.access++;
                if(req.status == 304) {
                    cache.hits++;
                    cback(e.content);
                } else if(req.status == 200) {
                    var content;
                    if(req.responseXML && req.responseXML.documentElement)
                        content = f_proc(req.responseXML);
                    else
                        content = f_proc(req.responseText);
                    var ctl = get_header(req, "Cache-Control");
                    if(ctl != "no-cache") {
                        cache.addEntry({"modtime" : get_header(req, "Last-Modified"),
                                        "etag" : get_header(req, "ETag"),
                                        "ctime" : new Date(),
                                        "content" : content}, url);
                    }
                    cback(content);
                } else {
                    if(err)
                        err(req);
                    else
                        alert("GET " + url + " returns: " + req.statusText);
                }
            }
        };

        req.send(null); 
    };
}
