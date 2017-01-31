/* http://keith-wood.name/bookmark.html
   Sharing bookmarks for jQuery v1.3.2.
   Written by Keith Wood (kbwood{at}iinet.com.au) March 2008.
   Dual licensed under the GPL (http://dev.jquery.com/browser/trunk/jquery/GPL-LICENSE.txt) and 
   MIT (http://dev.jquery.com/browser/trunk/jquery/MIT-LICENSE.txt) licenses. 
   Please attribute the author if you use it. */

/* Allow your page to be shared with various bookmarking sites.
   Attach the functionality with options like:
   $('div selector').bookmark({sites: ['delicious', 'digg']});
*/

(function($) { // Hide scope, no $ conflict

var PROP_NAME = 'bookmark';

/* Bookmark sharing manager. */
function Bookmark() {
	this._uuid = new Date().getTime(); // Unique identifier seed
	this._defaults = {
		url: '',  // The URL to bookmark, leave blank for the current page
		sourceTag: '', // Extra tag to add to URL to indicate source when it returns
		title: '',  // The title to bookmark, leave blank for the current one
		description: '',  // A longer description of the site
		sites: [],  // List of site IDs or language selectors (lang:xx) or
			// category selectors (category:xx) to use, empty for all
		iconsStyle: 'bookmark_icons', // CSS class for site icons
		icons: 'bookmarks.gif', // Horizontal amalgamation of all site icons
		iconSize: 16,  // The size of the individual icons
		iconCols: 16,  // The number of icons across the combined image
		target: '_blank',  // The name of the target window for the bookmarking links
		compact: true,  // True if a compact presentation should be used, false for full
		hint: 'Send to {s}',  // Popup hint for links, {s} is replaced by display name
		popup: false, // True to have it popup on demand, false to show always
		popupText: 'Bookmark this site...', // Text for the popup trigger
		addFavorite: false,  // True to add a 'add to favourites' link, false for none
		favoriteText: 'Favorite',  // Display name for the favourites link
		favoriteIcon: 0,  // Icon for the favourites link
		addEmail: false,  // True to add a 'e-mail a friend' link, false for none
		emailText: 'E-mail',  // Display name for the e-mail link
		emailIcon: 1,  // Icon for the e-mail link
		emailSubject: 'Interesting page',  // The subject for the e-mail
		emailBody: 'I thought you might find this page interesting:\n{t} ({u})', // The body of the e-mail
			// Use '{t}' for the position of the page title, '{u}' for the page URL,
			// '{d}' for the description, and '\n' for new lines
		manualBookmark: 'Please close this dialog and\npress Ctrl-D to bookmark this page.',
			// Instructions for manually bookmarking the page
		onSelect: null // Callback on selection
	};
	this._sites = {  // The definitions of the available bookmarking sites, in URL use
		// '{u}' for the page URL, '{t}' for the page title, and '{d}' for the description
		'aol': {display: 'myAOL', icon: 2, lang: 'en', category: 'bookmark',
			url: 'http://favorites.my.aol.com/ffclient/AddBookmark?url={u}&amp;title={t}'},
		'bookmarked': {display: 'Bookmarked By us', icon: 296, lang: 'en', category: 'shopping',
			url: 'http://www.bookmarkedby.us/submit.php?url={u}'},
		'bookmarkit': {display: 'bookmark.it', icon: 71, lang: 'it', category: 'bookmark',
			url: 'http://www.bookmark.it/bookmark.php?url={u}'},
		'delicious': {display: 'del.icio.us', icon: 7, lang: 'en', category: 'bookmark',
			url: 'http://del.icio.us/post?url={u}&amp;title={t}'},
		'digg': {display: 'Digg', icon: 8, lang: 'en', category: 'news',
			url: 'http://digg.com/submit?phase=2&amp;url={u}&amp;title={t}'},
		'facebook': {display: 'Facebook', icon: 11, lang: 'en', category: 'social',
			url: 'http://www.facebook.com/sharer.php?u={u}&amp;t={t}'},
		'friendfeed': {display: 'FriendFeed', icon: 52, lang: 'en', category: 'social',
			url: 'http://friendfeed.com/share?url={u}&amp;title={t}'},
		'friendster': {display: 'Friendster', icon: 233, lang: 'en', category: 'social',
			url: 'http://www.friendster.com/sharer.php?u={u}&amp;t={t}'},
		'google': {display: 'Google', icon: 16, lang: 'en', category: 'bookmark',
			url: 'http://www.google.com/bookmarks/mark?op=edit&amp;bkmk={u}&amp;title={t}'},
		'googlereader': {display: 'Google Reader', icon: 238, lang: 'en', category: 'tools',
			url: 'http://www.google.com/reader/link?url={u}&amp;title={t}&amp;srcTitle={u}'},
		'hotmail': {display: 'Hotmail', icon: 244, lang: 'en', category: 'mail',
			url: 'http://www.hotmail.msn.com/secure/start?action=compose&amp;to=&amp;body={u}&amp;subject={t}'},
		'lifestream': {display: 'Lifestream', icon: 308, lang: 'en', category: 'blog',
			url: 'http://lifestream.aol.com/share/?url={u}&amp;title={t}&amp;description={d}'},
	    'linkarena': {display: 'Linkarena', icon: 70, lang: 'de', category: 'bookmark',
			url: 'http://linkarena.com/bookmarks/addlink/?url={u}&amp;title={t}&amp;desc={d}&amp;tags='},
		'linkedin': {display: 'LinkedIn', icon: 66, lang: 'en', category: 'social',
			url: 'http://www.linkedin.com/shareArticle?mini=true&amp;url={u}&amp;title={t}&amp;ro=false&amp;summary={d}&amp;source='},
		'myspace': {display: 'MySpace', icon: 25, lang: 'en', category: 'social',
			url: 'http://www.myspace.com/Modules/PostTo/Pages/?u={u}&amp;t={t}'},
		'orkut': {display: 'Orkut', icon: 193, lang: 'en', category: 'social',
			url: 'http://promote.orkut.com/preview?nt=orkut.com&amp;du={u}&amp;tt={t}&amp;cn='},
		'reddit': {display: 'reddit', icon: 30, lang: 'en', category: 'news',
			url: 'http://reddit.com/submit?url={u}&amp;title={t}'},
		'slashdot': {display: 'Slashdot', icon: 33, lang: 'en', category: 'news',
			url: 'http://slashdot.org/bookmark.pl?url={u}&amp;title={t}'},
		'stumbleupon': {display: 'StumbleUpon', icon: 36, lang: 'en', category: 'bookmark',
			url: 'http://www.stumbleupon.com/submit?url={u}&amp;title={t}'},
		'stumpedia': {display: 'Stumpedia', icon: 113, lang: 'en', category: 'other',
			url: 'http://www.stumpedia.com/submit?url={u}&amp;title={t}'},
		'tweetmeme': {display: 'tweetmeme', icon: 279, lang: 'en', category: 'tools',
			url: 'http://api.tweetmeme.com/visit?url={u}'},
		'twitter':{display: 'twitter', icon: 200, lang: 'en', category: 'blog',
			url: 'http://twitter.com/home?status={t}%20{u}'},
		'twitthis': {display: 'TwitThis', icon: 45, lang: 'en', category: 'tools',
			url: 'http://twitthis.com/twit?url={u}'},
		'windows': {display: 'Windows Live', icon: 40, lang: 'en', category: 'bookmark',
			url: 'https://favorites.live.com/quickadd.aspx?marklet=1&amp;mkt=en-us&amp;url={u}&amp;title={t}'},
		'yahoo': {display: 'Yahoo Bookmarks', icon: 60, lang: 'en', category: 'bookmark',
			url: 'http://bookmarks.yahoo.com/toolbar/savebm?opener=tb&amp;u={u}&amp;t={t}'},
		'yahoobuzz': {display: 'Yahoo Buzz', icon: 67, lang: 'en', category: 'bookmark',
			url: 'http://buzz.yahoo.com/submit?submitUrl={u}&amp;submitHeadline={t}'}
	};
}

$.extend(Bookmark.prototype, {
	/* Class name added to elements to indicate already configured with bookmarking. */
	markerClassName: 'hasBookmark',

	/* Override the default settings for all bookmarking instances.
	   @param  settings  object - the new settings to use as defaults
	   @return void */
	setDefaults: function(settings) {
		extendRemove(this._defaults, settings || {});
		return this;
	},

	/* Add a new bookmarking site to the list.
	   @param  id  string - the ID of the new site
	   @param  display   (string) the display name for this site
	   @param  icon      (string) the location (URL) of an icon for this site (16x16), or
	                     (number) the index of the icon within the combined image
	   @param  lang      (string) the language code for this site
	   @param  category  (string) the category for this site
	   @param  url       (string) the submission URL for this site,
	                     with {u} marking where the current page's URL should be inserted,
	                     and {t} indicating the title insertion point
	   @return void */
	addSite: function(id, display, icon, lang, category, url) {
		this._sites[id] = {display: display, icon: icon, lang: lang, category: category, url: url};
		return this;
	},

	/* Return the list of defined sites.
	   @return  object[] - indexed by site id (string), each object contains
	            display (string) the display name,
	            icon    (string) the location of the icon,, or
	                    (number) the icon's index in the combined image
	            lang    (string) the language code for this site
	            url     (string) the submission URL for the site */
	getSites: function() {
		return this._sites;
	},

	/* Attach the bookmarking widget to a div. */
	_attachBookmark: function(target, settings) {
		target = $(target);
		if (target.hasClass(this.markerClassName)) {
			return;
		}
		target.addClass(this.markerClassName);
		if (!target[0].id) {
			target[0].id = 'bm' + (++this._uuid);
		}
		this._updateBookmark(target, settings);
	},

	/* Reconfigure the settings for a bookmarking div.
	   @param  target    (element) the bookmark container
	   @param  settings  (object) the new settings for this container or
	                     (string) a single setting name
	   @param  value     (any) the single setting's value */
	_changeBookmark: function(target, settings, value) {
		target = $(target);
		if (!target.hasClass(this.markerClassName)) {
			return;
		}
		if (typeof settings == 'string') {
			var name = settings;
			settings = {};
			settings[name] = value;
		}
		this._updateBookmark(target, settings);
	},

	/* Construct the requested bookmarking links. */
	_updateBookmark: function(target, settings) {
		var oldSettings = $.data(target[0], PROP_NAME) || $.extend({}, this._defaults);
		settings = extendRemove(oldSettings, settings || {});
		$.data(target[0], PROP_NAME, settings);
		var sites = settings.sites;
		var allSites = this._sites;
		if (sites.length == 0) {
			$.each(allSites, function(id) {
				sites.push(id);
			});
		}
		else {
			$.each(sites, function(index, value) {
				var lang = value.match(/lang:(.*)/); // Select by language
				if (lang) {
					var ids = [];
					$.each(allSites, function(id, site) {
						if (site.lang == lang[1]) {
							ids.push(id);
						}
					});
					sites = sites.slice(0, index).concat(ids, sites.slice(index + 1));
				}
				var category = value.match(/category:(.*)/); // Select by category
				if (category) {
					var ids = [];
					$.each(allSites, function(id, site) {
						if (site.category == category[1]) {
							ids.push(id);
						}
					});
					sites = sites.slice(0, index).concat(ids, sites.slice(index + 1));
				}
			});
		}
		var hint = settings.hint || '{s}';
		var html = (settings.popup ? '<a href="#" class="bookmark_popup_text">' +
			settings.popupText + '</a><div class="bookmark_popup">' : '') +
			'<ul class="bookmark_list' + (settings.compact ? ' bookmark_compact' : '') + '">';
		var addSite = function(display, icon, url, onclick) {
			var html = '<li><a href="' + url + '"' + (onclick ? ' onclick="' + onclick + '"' :
				(settings.target ? ' target="' + settings.target + '"' : '')) + '>';
			if (icon != null) {
				var title = hint.replace(/\{s\}/, display);
				if (typeof icon == 'number') {
					html += '<span title="' + title + '" ' +
						(settings.iconsStyle ? 'class="' + settings.iconsStyle + '" ' : '') +
						'style="' + (settings.iconsStyle ? 'background-position: ' :
						'background: transparent url(' + settings.icons + ') no-repeat ') + '-' +
						((icon % settings.iconCols) * settings.iconSize) + 'px -' +
						(Math.floor(icon / settings.iconCols) * settings.iconSize) + 'px;' +
						($.browser.mozilla && $.browser.version < '1.9' ?
						' padding-left: ' + settings.iconSize + 'px; padding-bottom: ' +
						(Math.max(0, settings.iconSize - 16)) + 'px;' : '') + '"></span>';
				}
				else {
					html += '<img src="' + icon + '" alt="' + title + '" title="' +
						title + '"' + (($.browser.mozilla && $.browser.version < '1.9') ||
						($.browser.msie && $.browser.version < '7.0') ?
						' style="vertical-align: bottom;"' :
						($.browser.msie ? ' style="vertical-align: middle;"' :
						($.browser.opera || $.browser.safari ?
						' style="vertical-align: baseline;"' : ''))) + '/>';
				}
				html +=	(settings.compact ? '' : '&#xa0;');
			}
			html +=	(settings.compact ? '' : display) + '</a></li>';
			return html;
		};
		var url = settings.url || window.location.href;
		var title = settings.title || document.title || $('h1:first').text();
		var desc = settings.description || $('meta[name=description]').attr('content') || '';
		if (settings.addFavorite) {
			html += addSite(settings.favoriteText, settings.favoriteIcon,
				'#', 'jQuery.bookmark._addFavourite(\'' + url.replace(/'/g, '\\\'') +
				'\',\'' + title.replace(/'/g, '\\\'') + '\')');
		}
		if (settings.addEmail) {
			html += addSite(settings.emailText, settings.emailIcon,
				'mailto:?subject=' + encodeURIComponent(settings.emailSubject) +
				'&amp;body=' + encodeURIComponent(settings.emailBody.
				replace(/\{u\}/, url).replace(/\{t\}/, title).replace(/\{d\}/, settings.desc)));
		}
		var sourceTag = (!settings.sourceTag ? '' :
			encodeURIComponent((url.indexOf('?') > -1 ? '&' : '?') + settings.sourceTag + '='));
		url = encodeURIComponent(url);
		title = encodeURIComponent(title);
		desc = encodeURIComponent(desc);
		var allSites = this._sites;
		$.each(sites, function(index, id) {
			var site = allSites[id];
			if (site) {
				html += addSite(site.display, site.icon, (settings.onSelect ? '#' :
					site.url.replace(/\{u\}/, url + (sourceTag ? sourceTag + id : '')).
					replace(/\{t\}/, title).replace(/\{d\}/, desc)),
					(settings.onSelect ? 'return jQuery.bookmark._selected(\'' + target[0].id +
					'\',\'' + id + '\')' : ''));
			}
		});
		html += '</ul>' + (settings.popup ? '</div>' : '');
		target.html(html);
		if (settings.popup) {
			target.find('.bookmark_popup_text').click(function() {
				var target = $(this).parent();
				var offset = target.offset();
				target.find('.bookmark_popup').css('left', offset.left).
					css('top', offset.top + target.outerHeight()).toggle();
				return false;
			});
			$(document).click(function(event) { // Close on external click
				target.find('.bookmark_popup').hide();
			});
		}
	},

	/* Remove the bookmarking widget from a div. */
	_destroyBookmark: function(target) {
		target = $(target);
		if (!target.hasClass(this.markerClassName)) {
			return;
		}
		target.removeClass(this.markerClassName).empty();
		$.removeData(target[0], PROP_NAME);
	},

	/* Callback when selected.
	   @param  id      (string) the target ID
	   @param  siteID  (string) the selected site ID */
	_selected: function(id, siteID) {
		var target = $('#' + id)[0];
		var settings = $.data(target, PROP_NAME);
		var site = $.bookmark._sites[siteID];
		var url = settings.url || window.location.href;
		var sourceTag = (!settings.sourceTag ? '' :
			encodeURIComponent((url.indexOf('?') > -1 ? '&' : '?') + settings.sourceTag + '='));
		var url = encodeURIComponent(url);
		var title = encodeURIComponent(settings.title || document.title);
		var desc = encodeURIComponent(settings.description || '');
		settings.onSelect.apply(target, [siteID, site.display,
			site.url.replace(/\{u\}/, url + (sourceTag ? sourceTag + siteID : '')).
			replace(/\{t\}/, title).replace(/\{d\}/, desc)]);
		return false;
	},

	/* Add the current page as a favourite in the browser.
	   @param  url    (string) the URL to bookmark
	   @param  title  (string) the title to bookmark */
	_addFavourite: function(url, title) {
		if ($.browser.msie) {
			window.external.addFavorite(url, title);
		}
		else {
			alert(this._defaults.manualBookmark);
		}
	}
});

/* jQuery extend now ignores nulls! */
function extendRemove(target, props) {
	$.extend(target, props);
	for (var name in props) {
		if (props[name] == null) {
			target[name] = null;
		}
	}
	return target;
}

/* Attach the bookmarking functionality to a jQuery selection.
   @param  command  string - the command to run (optional, default 'attach')
   @param  options  object - the new settings to use for these bookmarking instances
   @return  jQuery object - for chaining further calls */
$.fn.bookmark = function(options) {
	var otherArgs = Array.prototype.slice.call(arguments, 1);
	return this.each(function() {
		if (typeof options == 'string') {
			$.bookmark['_' + options + 'Bookmark'].
				apply($.bookmark, [this].concat(otherArgs));
		}
		else {
			$.bookmark._attachBookmark(this, options || {});
		}
	});
};

/* Initialise the bookmarking functionality. */
$.bookmark = new Bookmark(); // singleton instance

})(jQuery);
