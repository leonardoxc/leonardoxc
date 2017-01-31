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
		'100zakladok': {display: 'Сто Закладок', icon: 201, lang: 'en', category: 'bookmark',
			url: 'http://www.100zakladok.ru/save/?bmurl={u}&amp;bmtitle={t}'},
		'2linkme': {display: '2linkme', icon: 287, lang: 'it', category: 'bookmark',
			url: 'http://www.2linkme.com/?collegamento={u}'},
		'7live7': {display: '7live7', icon: 288, lang: 'en', category: 'bookmark',
			url: 'http://www.7live7.com/Bookmarks/Add.aspx?r=ad&amp;Url={u}&amp;Title={t}'},
		'a1webmarks': {display: 'A1 webmarks', icon: 179, lang: 'en', category: 'bookmark',
			url: 'http://www.a1-webmarks.com/bm_edit.html?u={u}&amp;t={t}'},
		'addio': {display: 'add.io', icon: 289, lang: 'en', category: 'bookmark',
			url: 'http://add.io/add?url={u}&amp;title={t}'},
		'adifni': {display: 'أضفني', icon: 202, lang: 'en', category: 'bookmark',
			url: 'http://www.adifni.com/account/bookmark/?bookmark_url={u}'},
		'aero': {display: 'aero', icon: 290, lang: 'en', category: 'social',
			url: 'http://www.aerosocial.com/user_share.php?url={u}&amp;title={t}&amp;desc={d}'},
		'allmyfaves': {display: 'All My Faves', icon: 291, lang: 'en', category: 'bookmark',
			url: 'http://www.allmyfaves.com/bmlet.php?url={u}&amp;title={t}'},
	    'alltagz': {display: 'alltagz', icon: 69, lang: 'de', category: 'bookmark',
			url: 'http://www.alltagz.de/bookmarks/?action=add&amp;address={u}&amp;title={t}'},
		'allvoices': {display: 'Allvoices', icon: 75, lang: 'en', category: 'social',
			url: 'http://www.allvoices.com/post_event?url={u}&amp;title={t}'},
		'amenme': {display: 'AmenMe', icon: 127, lang: 'en', category: 'social',
			url: 'http://www.amenme.com/AmenMe/Amens/AmenToThis.aspx?url={u}&amp;title={t}'},
		'aol': {display: 'myAOL', icon: 2, lang: 'en', category: 'bookmark',
			url: 'http://favorites.my.aol.com/ffclient/AddBookmark?url={u}&amp;title={t}'},
		'arto': {display: 'Arto', icon: 76, lang: 'en', category: 'social',
			url: 'http://www.arto.com/section/linkshare/?lu={u}&amp;ln={t}'},
		'ask': {display: 'Ask', icon: 3, lang: 'en', category: 'tools',
			url: 'http://myjeeves.ask.com/mysearch/BookmarkIt?v=1.2&amp;t=webpages&amp;url={u}&amp;title={t}'},
		'aviary': {display: 'Aviary', icon: 203, lang: 'en', category: 'tools',
			url: 'http://aviary.com/capture?url={u}'},
		'baang': {display: 'بانگ', icon: 204, lang: 'fa', category: 'news',
			url: 'http://www.baang.ir/submit.php?url={u}'},
		'backflip': {display: 'Backflip', icon: 62, lang: 'en', category: 'social',
			url: 'http://www.backflip.com/add_page_pop.ihtml?url={u}&amp;title={t}'},
		'baidu': {display: 'Baidu', icon: 128, lang: 'zh', category: 'social',
			url: 'http://cang.baidu.com/do/add?iu={u}&amp;it={t}&amp;fr=ien&amp;dc='},
		'ballhype': {display: 'BallHype', icon: 63, lang: 'en', category: 'social',
			url: 'http://ballhype.com/post/url/?url={u}&amp;title={t}'},
		'bebo': {display: 'Bebo', icon: 64, lang: 'en', category: 'social',
			url: 'http://bebo.com/c/share?Url={u}&amp;Title={t}'},
		'bentio': {display: 'bentio', icon: 292, lang: 'en', category: 'blog',
			url: 'http://bentio.com/?action=share&amp;status_textarea={t}%20{u}'},
		'bibsonomy': {display: 'BibSonomy', icon: 77, lang: 'en', category: 'bookmark',
			url: 'http://www.bibsonomy.org/BibtexHandler?requTask=upload&amp;url={u}&amp;description={t}'},
		'biggerpockets': {display: 'BiggerPockets', icon: 293, lang: 'en', category: 'social',
			url: 'http://www.biggerpockets.com/links/details?link={u}'},
		'bitly': {display: 'bit.ly', icon: 129, lang: 'en', category: 'tools',
			url: 'http://bit.ly/?url={u}'},
		'bizsugar': {display: 'bizSugar', icon: 130, lang: 'en', category: 'news',
			url: 'http://www.bizsugar.com/bizsugarthis.php?url={u}'},
		'bleetbox': {display: 'bleetbox', icon: 180, lang: 'en', category: 'blog',
			url: 'http://bleetbox.com/bar?url={u}'},
		'blinklist': {display: 'BlinkList', icon: 4, lang: 'en', category: 'bookmark',
			url: 'http://www.blinklist.com/index.php?Action=Blink/addblink.php&amp;Url={u}&amp;Title={t}'},
		'blip': {display: 'blip', icon: 205, lang: 'en', category: 'blog',
			url: 'http://blip.pl/dashboard?body={t}:+{u}'},
		'bloggy': {display: 'Bloggy', icon: 131, lang: 'sv', category: 'blog',
			url: 'http://bloggy.se/home?status={t}+{u}'},
		'blogmarks': {display: 'Blogmarks', icon: 5, lang: 'en', category: 'bookmark',
			url: 'http://blogmarks.net/my/new.php?mini=1&amp;simple=1&amp;url={u}&amp;title={t}'},
		'blogtrottr': {display: 'Blogtrottr', icon: 294, lang: 'en', category: 'tools',
			url: 'http://blogtrottr.com/?subscribe={u}'},
		'blurpalicious': {display: 'blurpalicious', icon: 206, lang: 'en', category: 'bookmark',
			url: 'http://www.blurpalicious.com/submit/?url={u}&amp;title={t}&amp;desc={d}'},
		'boardlite': {display: 'boardlite', icon: 295, lang: 'en', category: 'other',
			url: 'http://www.boardlite.com/topic/new/?url={u}&amp;title={t}'},
		'bobrdobr': {display: 'БобрДобр', icon: 132, lang: 'ru', category: 'bookmark',
			url: 'http://bobrdobr.ru/addext.html?url={u}&amp;title={t}&amp;desc={d}'},
		'bonzobox': {display: 'BonzoBox', icon: 207, lang: 'en', category: 'bookmark',
			url: 'http://bonzobox.com/toolbar/add?u={u}&amp;t={t}&amp;desc={d}'},
		'bookmarked': {display: 'Bookmarked By us', icon: 296, lang: 'en', category: 'shopping',
			url: 'http://www.bookmarkedby.us/submit.php?url={u}'},
		'bookmarkit': {display: 'bookmark.it', icon: 71, lang: 'it', category: 'bookmark',
			url: 'http://www.bookmark.it/bookmark.php?url={u}'},
		'bookmarky': {display: 'bookmarky', icon: 208, lang: 'en', category: 'bookmark',
			url: 'http://www.bookmarky.cz/a.php?cmd=add&amp;url={u}&amp;title={t}'},
		'bookmarksfr': {display: 'bookmarks.fr', icon: 78, lang: 'fr', category: 'bookmark',
			url: 'http://www.bookmarks.fr/favoris/AjoutFavori?action=add&amp;address={u}&amp;title={t}'},
		'bookmerken': {display: 'Bookmerken', icon: 297, lang: 'de', category: 'bookmark',
			url: 'http://www.bookmerken.de/?url={u}&amp;title={t}'},
		'bordom': {display: 'Bordom', icon: 181, lang: 'en', category: 'news',
			url: 'http://www.bordom.net/submit/?url={u}&amp;title={t}'},
		'boxnet': {display: 'Box.net', icon: 209, lang: 'en', category: 'tools',
			url: 'https://www.box.net/api/1.0/import?import_as=link&amp;url={u}&amp;name={t}&amp;description={d}'},
		'brainify': {display: 'Brainify', icon: 133, lang: 'en', category: 'bookmark',
			url: 'http://www.brainify.com/Bookmark.aspx?url={u}&amp;title={t}'},
		'bryderi': {display: 'Bryderi', icon: 134, lang: 'sv', category: 'shopping',
			url: 'http://bryderi.se/add.html?u={u}'},
		'buddymarks': {display: 'BuddyMarks', icon: 79, lang: 'en', category: 'bookmark',
			url: 'http://buddymarks.com/add_bookmark.php?bookmark_url={u}&amp;bookmark_title={t}'},
		'bukmark': {display: 'Bukmark', icon: 182, lang: 'en', category: 'shopping',
			url: 'http://www.buk-mark.com/submit.php?url={u}'},
		'buzzzy': {display: 'Buzzzy', icon: 298, lang: 'en', category: 'social',
			url: 'http://buzzzy.com/api/share.addthis?url={u}'},
		'bx': {display: 'Business Exchange', icon: 73, lang: 'en', category: 'news',
			url: 'http://bx.businessweek.com/api/add-article-to-bx.tn?url={u}'},
		'bzzster': {display: 'Bzzster', icon: 80, lang: 'en', category: 'news',
			url: 'http://bzzster.com/share?v=5;link={u}&amp;subject={t}'},
		'camyoo': {display: 'camyoo', icon: 210, lang: 'en', category: 'social',
			url: 'http://www.camyoo.com/note.html?url={u}'},
		'care2': {display: 'Care2', icon: 6, lang: 'en', category: 'social',
			url: 'http://www.care2.com/news/news_post.html?url={u}&amp;title={t}'},
		'chiq': {display: 'Chiq', icon: 299, lang: 'en', category: 'shopping',
			url: 'http://chiq.com/create/affiliate?url={u}&amp;title={t}&amp;description={d}&amp;c=1'},
		'cirip': {display: 'Cirip', icon: 211, lang: 'en', category: 'blog',
			url: 'http://www.cirip.ro/post/?url={u}&amp;bookmark={t}'},
		'citeulike': {display: 'citeulike', icon: 81, lang: 'en', category: 'bookmark',
			url: 'http://www.citeulike.org/posturl?url={u}&amp;title={t}'},
		'classicalplace': {display: 'Classical Place', icon: 212, lang: 'en', category: 'social',
			url: 'http://www.classicalplace.com/?u={u}&amp;t={t}&amp;c={d}'},
		'clickazoo': {display: 'Clickazoo', icon: 213, lang: 'en', category: 'bookmark',
			url: 'http://www.clickazoo.com/?page=add&amp;location={u}&amp;title={t}'},
		'cndig': {display: '中国顶客', icon: 214, lang: 'en', category: 'social',
			url: 'http://www.cndig.org/submit/?url={u}&amp;title={t}'},
		'colivia': {display: 'Colivia', icon: 215, lang: 'en', category: 'news',
			url: 'http://www.colivia.de/submit.php?url={u}'},
		'connotea': {display: 'Connotea', icon: 82, lang: 'en', category: 'bookmark',
			url: 'http://www.connotea.org/add?uri={u}&amp;title={t}'},
		'cosmiq': {display: 'COSMiQ', icon: 216, lang: 'en', category: 'bookmark',
			url: 'http://www.cosmiq.de/lili/my/add?url={u}'},
		'current': {display: 'Current', icon: 49, lang: 'en', category: 'news',
			url: 'http://current.com/clipper.htm?url={u}&amp;title={t}'},
		'dealsplus': {display: 'deals plus', icon: 74, lang: 'en', category: 'shopping',
			url: 'http://dealspl.us/add.php?ibm=1&amp;url={u}'},
		'delicious': {display: 'del.icio.us', icon: 7, lang: 'en', category: 'bookmark',
			url: 'http://del.icio.us/post?url={u}&amp;title={t}'},
		'designbump': {display: 'designbump', icon: 217, lang: 'en', category: 'bookmark',
			url: 'http://designbump.com/submit/?url={u}&amp;title={t}&amp;body={d}'},
		'designfloat': {display: 'Design Float', icon: 50, lang: 'en', category: 'bookmark',
			url: 'http://www.designfloat.com/submit.php?url={u}&amp;title={t}'},
		'designmoo': {display: 'DesignMoo', icon: 135, lang: 'en', category: 'news',
			url: 'http://designmoo.com/submit?url={u}&amp;title={t}&amp;body={d}'},
		'digg': {display: 'Digg', icon: 8, lang: 'en', category: 'news',
			url: 'http://digg.com/submit?phase=2&amp;url={u}&amp;title={t}'},
		'diggita': {display: 'diggita', icon: 218, lang: 'it', category: 'news',
			url: 'http://www.diggita.it/submit.php?url={u}&amp;title={t}'},
		'diglog': {display: 'Diglog', icon: 136, lang: 'zh', category: 'bookmark',
			url: 'http://www.diglog.com/submit.aspx?url={u}&amp;title={t}&amp;description={d}'},
		'diigo': {display: 'Diigo', icon: 9, lang: 'en', category: 'social',
			url: 'http://www.diigo.com/post?url={u}&amp;title={t}'},
		'dipdive': {display: 'Dipdive', icon: 219, lang: 'en', category: 'social',
			url: 'http://dipdive.com/popup/share/?url={u}&amp;title={t}&amp;text={d}'},
		'domelhor': {display: 'Do Melhor', icon: 183, lang: 'pt', category: 'news',
			url: 'http://domelhor.net/submit.php?url={u}&title={t}'},
		'dosti': {display: 'Dosti', icon: 138, lang: 'en', category: 'social',
			url: 'http://dosti.webdunia.com/Api/Share.aspx?st=b&url={u}&amp;title={t}'},
		'dotnetkicks': {display: 'DotNetKicks', icon: 139, lang: 'en', category: 'news',
			url: 'http://www.dotnetkicks.com/kick/?url={u}&amp;title={t}'},
		'dotnetshoutout': {display: '.net Shoutout', icon: 220, lang: 'en', category: 'news',
			url: 'http://dotnetshoutout.com/Submit?url={u}&title={t}'},
		'douban': {display: 'douban', icon: 300, lang: 'zh', category: 'social',
			url: 'http://www.douban.com/recommend/?url={u}&amp;title={t}'},
		'drimio': {display: 'drimio', icon: 221, lang: 'pt', category: 'social',
			url: 'http://www.drimio.com/drimthis/index?url={u}&amp;title={t}'},
		'dropjack': {display: 'Dropjack', icon: 222, lang: 'en', category: 'news',
			url: 'http://www.dropjack.com/submit.php?url={u}'},
		'dwellicious': {display: 'Dwellicious', icon: 301, lang: 'en', category: 'bookmark',
			url: 'http://dwellicious.com/addbookmark?popup=true&amp;uri={u}&amp;desc={t}'},
		'dzone': {display: 'DZone', icon: 10, lang: 'en', category: 'bookmark',
			url: 'http://www.dzone.com/links/add.html?url={u}&amp;title={t}'},
		'edelight': {display: 'edelight', icon: 140, lang: 'de', category: 'shopping',
			url: 'http://www.edelight.de/geschenk/neu?purl={u}'},
		'ekudos': {display: 'eKudos', icon: 141, lang: 'nl', category: 'news',
			url: 'http://www.ekudos.nl/artikel/nieuw?url={u}&amp;title={t}&amp;desc={d}'},
		'elefanta': {display: 'elefanta', icon: 223, lang: 'pl', category: 'bookmark',
			url: 'http://elefanta.pl/member/bookmarkNewPage.action?url={u}&amp;title={t}&amp;bookmarkVO.notes={d}'},
		'elertgadget': {display: 'eLert Gadget', icon: 224, lang: 'en', category: 'bookmark',
			url: 'http://www.elertgadget.com/share.php?u={u}&amp;t={t}'},
		'embarkons': {display: 'Embarkons', icon: 184, lang: 'en', category: 'social',
			url: 'http://www.embarkons.com/sharer.php?u={u}&t={t}'},
		'eucliquei': {display: 'euCliquei', icon: 142, lang: 'pt', category: 'bookmark',
			url: 'http://www.eucliquei.com.br/index.asp?a=clicar_novo&amp;url={u}&amp;titulo={t}&amp;trecho='},
		'evernote': {display: 'Evernote', icon: 83, lang: 'en', category: 'other',
			url: 'http://www.evernote.com/clip.action?url={u}&amp;title={t}'},
		'extraplay': {display: 'extraplay', icon: 225, lang: 'en', category: 'social',
			url: 'http://www.extraplay.com/members/share.php?url={u}&amp;title={t}&amp;desc={d}'},
		'ezyspot': {display: 'EzySpot', icon: 226, lang: 'en', category: 'bookmark',
			url: 'http://www.ezyspot.com/submit?url={u}&amp;title={t}'},
		'fabulously40': {display: 'Fabulously40', icon: 143, lang: 'en', category: 'social',
			url: 'http://fabulously40.com/writeblog?body={u}&amp;subject={t}'},
		'facebook': {display: 'Facebook', icon: 11, lang: 'en', category: 'social',
			url: 'http://www.facebook.com/sharer.php?u={u}&amp;t={t}'},
		'fark': {display: 'Fark', icon: 12, lang: 'en', category: 'news',
			url: 'http://cgi.fark.com/cgi/fark/submit.pl?new_url={u}&amp;new_comment={t}'},
		'farkinda': {display: 'Farkinda', icon: 227, lang: 'tr', category: 'news',
			url: 'http://www.farkinda.com/submit?url={u}'},
		'favable': {display: 'FAVable', icon: 302, lang: 'en', category: 'bookmark',
			url: 'http://www.favable.com/oexchange?url={u}&amp;title={t}&amp;desc={d}'},
		'faves': {display: 'Faves', icon: 13, lang: 'en', category: 'bookmark',
			url: 'http://faves.com/Authoring.aspx?u={u}&amp;t={t}'},
		'favlog': {display: 'favlog', icon: 228, lang: 'de', category: 'bookmark',
			url: 'http://www.favlog.de/submit.php?url={u}'},
		'favoritus': {display: 'FavoritUs', icon: 144, lang: 'en', category: 'bookmark',
			url: 'http://www.favoritus.com/post.php?getlink={u}&amp;gettitle={t}'},
		'flaker': {display: 'Flaker', icon: 229, lang: 'pl', category: 'social',
			url: 'http://flaker.pl/add2flaker.php?url={u}&amp;title={t}'},
		'flosspro': {display: 'FLOSS.pro', icon: 230, lang: 'en', category: 'blog',
			url: 'http://floss.pro/index.php?action=newnotice&amp;status_textarea={t}: {u}'},
		'fnews': {display: 'fnews', icon: 185, lang: 'az', category: 'news',
			url: 'http://fnews.az/node/add/drigg?url={u}&amp;title={t}&amp;body={d}'},
		'folkd': {display: 'Folkd', icon: 85, lang: 'en', category: 'bookmark',
			url: 'http://www.folkd.com/submit/{u}'},
		'followtags': {display: 'Followtags', icon: 303, lang: 'en', category: 'news',
			url: 'http://www.followtags.com/submit?url={u}'},
		'fooxweb': {display: 'fooxweb', icon: 231, lang: 'en', category: 'bookmark',
			url: 'http://www.fooxweb.com/?urls={u}&amp;title={t}'},
		'forceindya': {display: 'Force Indya', icon: 232, lang: 'en', category: 'bookmark',
			url: 'http://www.forceindya.com/submit?url={u}&amp;title={t}'},
		'forgetfoo': {display: 'forgetfoo', icon: 145, lang: 'en', category: 'bookmark',
			url: 'http://www.forgetfoo.com/?inc=share&amp;url={u}&amp;title={t}&amp;desc={d}'},
		'fresqui': {display: 'Fresqui', icon: 51, lang: 'es', category: 'news',
			url: 'http://ocio.fresqui.com/post?url={u}&amp;title={t}'},
		'friendfeed': {display: 'FriendFeed', icon: 52, lang: 'en', category: 'social',
			url: 'http://friendfeed.com/share?url={u}&amp;title={t}'},
		'friendster': {display: 'Friendster', icon: 233, lang: 'en', category: 'social',
			url: 'http://www.friendster.com/sharer.php?u={u}&amp;t={t}'},
		'funp': {display: 'funP', icon: 53, lang: 'zh', category: 'bookmark',
			url: 'http://funp.com/pages/submit/add.php?url={u}&amp;title={t}'},
		'fwisp': {display: 'fwisp', icon: 234, lang: 'en', category: 'bookmark',
			url: 'http://fwisp.com/submit.php?url={u}'},
		'gabbr': {display: 'Gabbr', icon: 87, lang: 'en', category: 'news',
			url: 'http://www.gabbr.com/submit/?bookurl={u}'},
		'gacetilla': {display: 'Gacetilla', icon: 146, lang: 'it', category: 'news',
			url: 'http://www.gacetilla.org/publish-form?url={u}&amp;title={t}'},
		'gamekicker': {display: 'gamekicker', icon: 235, lang: 'en', category: 'news',
			url: 'http://www.gamekicker.com/node/add/drigg?url={u}&amp;title={t}&amp;body={d}'},
		'gamesnetworks': {display: 'gamesnetworks', icon: 236, lang: 'it', category: 'news',
			url: 'http://www.gamesnetworks.it/submit.php?url={u}'},
		'givealink': {display: 'givealink', icon: 237, lang: 'en', category: 'bookmark',
			url: 'http://givealink.org/bookmark/add?url={u}&amp;title={t}'},
		'globalgrind': {display: 'Global Grind', icon: 88, lang: 'en', category: 'social',
			url: 'http://globalgrind.com/submission/submit.aspx?url={u}&amp;type=Article&amp;title={t}'},
		'gluvsnap': {display: 'GluvSnap', icon: 186, lang: 'en', category: 'news',
			url: 'http://www.gluvsnap.com/news/pin/submit.php?url={u}'},
		'google': {display: 'Google', icon: 16, lang: 'en', category: 'bookmark',
			url: 'http://www.google.com/bookmarks/mark?op=edit&amp;bkmk={u}&amp;title={t}'},
		'googlereader': {display: 'Google Reader', icon: 238, lang: 'en', category: 'tools',
			url: 'http://www.google.com/reader/link?url={u}&amp;title={t}&amp;srcTitle={u}'},
		'gravee': {display: 'Gravee', icon: 89, lang: 'en', category: 'bookmark',
			url: 'http://www.gravee.com/account/bookmarkpop?u={u}&amp;t={t}'},
		'greaterdebater': {display: 'GreaterDebater', icon: 239, lang: 'en', category: 'news',
			url: 'http://greaterdebater.com/submit/?url={u}&amp;title={t}'},
		'grono': {display: 'Grono', icon: 240, lang: 'pl', category: 'social',
			url: 'http://grono.net/pub/page/link/urlfetch/?url={u}&amp;title={t}'},
		'grumper': {display: 'Grumper', icon: 147, lang: 'en', category: 'other',
			url: 'http://www.grumper.org/add.php?desc={u}&amp;title={t}'},
		'habergentr': {display: 'haber.gen.tr', icon: 148, lang: 'tr', category: 'news',
			url: 'http://www.haber.gen.tr/edit?url={u}&amp;title={t}&amp;description={d}'},
		'hackernews': {display: 'HackerNews', icon: 187, lang: 'en', category: 'news',
			url: 'http://news.ycombinator.com/submitlink?u={u}&amp;t={t}'},
		'hadashhot': {display: 'Hadash Hot', icon: 149, lang: 'he', category: 'news',
			url: 'http://www.hadash-hot.co.il/submit.php?url={u}&amp;phase=1'},
		'hatena': {display: 'はてな', icon: 304, lang: 'ja', category: 'bookmark',
			url: 'http://b.hatena.ne.jp/bookmarklet?url={u}&amp;btitle={t}'},
		'hazarkor': {display: 'Hazarkor', icon: 241, lang: 'he', category: 'news',
			url: 'http://www.hazarkor.co.il/add_story.php?story_url={u}&amp;story_title={t}&amp;story_desc={d}'},
		'healthranker': {display: 'HealthRanker', icon: 90, lang: 'en', category: 'news',
			url: 'http://www.healthranker.com/submit.php?url={u}&amp;title={t}'},
		'hedgehogs': {display: 'Hedgehogs', icon: 242, lang: 'en', category: 'social',
			url: 'http://www.hedgehogs.net/mod/bookmarks/add.php?address={u}&amp;title={t}'},
		'hellotxt': {display: 'hellotxt', icon: 150, lang: 'en', category: 'blog',
			url: 'http://hellotxt.com/?status={u}'},
		'hemidemi': {display: 'HEMiDEMi', icon: 91, lang: 'zh', category: 'bookmark',
			url: 'http://www.hemidemi.com/user_bookmark/new?url={u}&amp;title={t}'},
		'hipstr': {display: 'hipstr', icon: 151, lang: 'en', category: 'news',
			url: 'http://www.hipstr.com/submit.php?burl={u}'},
		'hitmarks': {display: 'hitmarks', icon: 188, lang: 'en', category: 'bookmark',
			url: 'http://www.hitmarks.com/submit.php?url={u}&amp;t={t}'},
		'hotbookmark': {display: 'Hot Bookmark', icon: 243, lang: 'en', category: 'bookmark',
			url: 'http://hotbmark.com/submit.php?url={u}'},
		'hotklix': {display: 'hotklix', icon: 152, lang: 'en', category: 'news',
			url: 'http://www.hotklix.com/?ref=share_this&amp;addurl={u}'},
		'hotmail': {display: 'Hotmail', icon: 244, lang: 'en', category: 'mail',
			url: 'http://www.hotmail.msn.com/secure/start?action=compose&amp;to=&amp;body={u}&amp;subject={t}'},
		'hotweb': {display: 'HOTWeb.lt', icon: 245, lang: 'lt', category: 'other',
			url: 'http://hotweb.lt/submit?url={u}&amp;title={t}&amp;body={d}'},
		'hugg': {display: 'Hugg', icon: 17, lang: 'en', category: 'social',
			url: 'http://www.hugg.com/submit?url={u}'},
		'hyves': {display: 'Hyves', icon: 153, lang: 'en', category: 'social',
			url: 'http://www.hyves.net/profilemanage/add/tips/?text={u}&amp;name={t}&amp;type=12'},
		'idearef': {display: 'ideaREF!', icon: 305, lang: 'en', category: 'bookmark',
			url: 'http://www.idearef.com/?url={u}&amp;title={t}'},
		'identica': {display: 'identi.ca', icon: 92, lang: 'en', category: 'blog',
			url: 'http://identi.ca/notice/new?status_textarea={t}%20{u}'},
		'ihavegot': {display: 'ihavegot', icon: 246, lang: 'en', category: 'social',
			url: 'http://www.ihavegot.com/share/?url={u}&amp;title={t}&amp;desc={d}'},
		'imera': {display: 'Imera', icon: 93, lang: 'pt', category: 'other',
			url: 'http://www.imera.com.br/post_d.html?linkUrl={u}&amp;linkName={t}'},
		'informazione': {display: 'informazione', icon: 247, lang: 'it', category: 'news',
			url: 'http://fai.informazione.it/submit.aspx?url={u}&amp;title={t}&amp;desc={d}'},
		'instapaper': {display: 'Instapaper', icon: 94, lang: 'en', category: 'tools',
			url: 'http://www.instapaper.com/b?u={u}&amp;t={y}'},
		'investorlinks': {display: 'InvestorLinks', icon: 154, lang: 'en', category: 'news',
			url: 'http://www.investorlinks.com/zingiling/add/?url={u}&amp;title={t}'},
		'isociety': {display: 'iSociety', icon: 248, lang: 'en', category: 'social',
			url: 'http://isociety.be/share/?url={u}&amp;title={t}&amp;desc={d}'},
		'iwiw': {display: 'iwiw', icon: 249, lang: 'hu', category: 'social',
			url: 'http://iwiw.hu/pages/share/share.jsp?v=1&amp;u={u}&amp;t={t}'},
		'jamespot': {display: 'Jamespot', icon: 95, lang: 'en', category: 'bookmark',
			url: 'http://www.jamespot.com/?action=spotit&amp;url={u}&amp;t={t}'},
		'jisko': {display: 'Jisko', icon: 250, lang: 'en', category: 'social',
			url: 'http://jisko.net/notes?note={t}%20{u}'},
		'jumptags': {display: 'Jumptags', icon: 96, lang: 'en', category: 'bookmark',
			url: 'http://www.jumptags.com/add/?url={u}&amp;title={t}'},
		'kaboodle': {display: 'Kaboodle', icon: 65, lang: 'en', category: 'shopping',
			url: 'http://www.kaboodle.com/grab/addItemWithUrl?url={u}&amp;pidOrRid=pid=&amp;redirectToKPage=true'},
		'kaevur': {display: 'Kaevur', icon: 189, lang: 'et', category: 'bookmark',
			url: 'http://www.kaevur.com/submit.php?url={u}'},
		'khabbr': {display: 'Khabbr', icon: 97, lang: 'ar', category: 'news',
			url: 'http://www.khabbr.com/submit.php?out=yes&amp;url={u}'},
		'kipup': {display: 'Kipup', icon: 306, lang: 'en', category: 'social',
			url: 'http://kipup.com/publisher/?url={u}&amp;title={t}'},
		'kirtsy': {display: 'Kirtsy', icon: 54, lang: 'en', category: 'shopping',
			url: 'http://www.kirtsy.com/submit.php?url={u}'},
		'kledy': {display: 'Kledy', icon: 98, lang: 'de', category: 'bookmark',
			url: 'http://www.kledy.de/submit.php?url={u}'},
		'kommenting': {display: 'KOMMENTing', icon: 307, lang: 'en', category: 'news',
			url: 'http://www.kommenting.com/comment?url={u}'},
		'kool': {display: 'Koolontheweb', icon: 43, lang: 'en', category: 'social',
			url: 'http://www.koolontheweb.com/post?url={u}&amp;title={t}'},
		'koornk': {display: 'koornk', icon: 251, lang: 'en', category: 'blog',
			url: 'http://koornk.com/home/?status={t}%3A%20{u}'},
		'kudos': {display: 'kudos', icon: 252, lang: 'no', category: 'bookmark',
			url: 'http://www.kudos.no/giKudos.php?url={u}&amp;tittel={t}&amp;beskrivelse={d}'},
		'kwoff': {display: 'Kwoff', icon: 155, lang: 'en', category: 'other',
			url: 'http://www.kwoff.com/submit.php?url={u}'},
		'laaikit': {display: 'laaik.it', icon: 190, lang: 'en', category: 'news',
			url: 'http://laaik.it/NewStoryCompact.aspx?uri={u}&amp;headline={t}&amp;description={d}'},
		'ladenzeile': {display: 'ladenzeile', icon: 253, lang: 'de', category: 'shopping',
			url: 'http://www.ladenzeile.de/bookmark/submission?url={u}&amp;t={t}'},
		'librerio': {display: 'Librerio', icon: 191, lang: 'en', category: 'bookmark',
			url: 'http://www.librerio.com/inbox?u={u}&amp;t={t}'},
		'lifestream': {display: 'Lifestream', icon: 308, lang: 'en', category: 'blog',
			url: 'http://lifestream.aol.com/share/?url={u}&amp;title={t}&amp;description={d}'},
	    'linkarena': {display: 'Linkarena', icon: 70, lang: 'de', category: 'bookmark',
			url: 'http://linkarena.com/bookmarks/addlink/?url={u}&amp;title={t}&amp;desc={d}&amp;tags='},
		'linkagogo': {display: 'LinkaGoGo', icon: 18, lang: 'en', category: 'bookmark',
			url: 'http://www.linkagogo.com/go/AddNoPopup?url={u}&amp;title={t}'},
		'linkedin': {display: 'LinkedIn', icon: 66, lang: 'en', category: 'social',
			url: 'http://www.linkedin.com/shareArticle?mini=true&amp;url={u}&amp;title={t}&amp;ro=false&amp;summary={d}&amp;source='},
		'linkninja': {display: 'LinkNinja', icon: 156, lang: 'pt', category: 'bookmark',
			url: 'http://linkninja.com.br/enviar_link.php?story_url={u}'},
		'linkshares': {display: 'LinkShares', icon: 254, lang: 'en', category: 'bookmark',
			url: 'http://www.linkshares.net/share?url={u}&amp;title={t}'},
		'linkuj': {display: 'Linkuj', icon: 255, lang: 'cz', category: 'news',
			url: 'http://linkuj.cz/?id=linkuj&amp;url={u}&amp;title={t}&amp;description={d}'},
		'livefavoris': {display: 'Livefavoris', icon: 256, lang: 'fr', category: 'bookmark',
			url: 'http://www.mediapratique.com/home/bookmark.php?lien={u}&amp;titre={t}'},
		'livejournal': {display: 'LiveJournal', icon: 19, lang: 'en', category: 'blog',
			url: 'http://www.livejournal.com/update.bml?subject={u}'},
		'lockerblogger': {display: 'LockerBlogger', icon: 309, lang: 'en', category: 'social',
			url: 'http://www.lockerblogger.com/share.php?url={u}&amp;title={t}&amp;desc={d}'},
		'lunch': {display: 'Lunch', icon: 157, lang: 'en', category: 'bookmark',
			url: 'http://www.lunch.com/Bookmarklet/LunchThis.html?url={u}'},
		'lynki': {display: 'Lynki', icon: 158, lang: 'en', category: 'bookmark',
			url: 'http://www.lynki.com/submit.php?url={u}'},
		'maple': {display: 'Maple', icon: 99, lang: 'en', category: 'bookmark',
			url: 'http://www.maple.nu/bookmarks/bookmarklet?bookmark[url]={u}&amp;bookmark[description]={t}'},
		'mashbord': {display: 'mashbord', icon: 310, lang: 'en', category: 'bookmark',
			url: 'http://mashbord.com/plugin-add-bookmark?url={u}'},
		'mawindo': {display: 'Mawindo', icon: 257, lang: 'en', category: 'social',
			url: 'http://www.mawindo.com/mod/bookmarks/add.php?address={u}&amp;title={t}'},
		'meccho': {display: 'Meccho', icon: 258, lang: 'en', category: 'bookmark',
			url: 'http://www.meccho.com/bookmark?url={u}&amp;title={t}'},
		'meinvz': {display: 'MeinVZ', icon: 259, lang: 'en', category: 'social',
			url: 'http://www.meinvz.net/Suggest/Selection/?u={u}&amp;desc={t}'},
		'mekusharim': {display: 'מקושרים', icon: 311, lang: 'he', category: 'social',
			url: 'http://mekusharim.walla.co.il/share/share.aspx?url={u}&amp;title={t}'},
		'memori': {display: 'memori.ru', icon: 192, lang: 'ru', category: 'bookmark',
			url: 'http://memori.ru/link/?sm=1&amp;u_data[url]={u}'},
		'meneame': {display: 'menéame', icon: 55, lang: 'es', category: 'bookmark',
			url: 'http://meneame.net/submit.php?url={u}'},
		'mindbody': {display: 'MindBodyGreen', icon: 21, lang: 'en', category: 'bookmark',
			url: 'http://www.mindbodygreen.com/passvote.action?u={u}'},
		'misterwong': {display: 'Mister Wong', icon: 22, lang: 'en', category: 'bookmark',
			url: 'http://www.mister-wong.com/index.php?action=addurl&amp;bm_url={u}&amp;bm_description={t}'},
		'mixx': {display: 'Mixx', icon: 23, lang: 'en', category: 'news',
			url: 'http://www.mixx.com/submit/story?page_url={u}&amp;title={t}'},
		'moemesto': {display: 'МоеМесто', icon: 260, lang: 'ru', category: 'bookmark',
			url: 'http://moemesto.ru/post.php?url={u}&amp;title={t}'},
		'multiply': {display: 'Multiply', icon: 24, lang: 'en', category: 'social',
			url: 'http://multiply.com/gus/journal/compose/addthis?body=&amp;url={u}&amp;subject={t}'},
		'mylinkvault': {display: 'MyLinkVault', icon: 100, lang: 'en', category: 'bookmark',
			url: 'http://www.mylinkvault.com/link-page.php?u={u}&amp;n={t}'},
		'myspace': {display: 'MySpace', icon: 25, lang: 'en', category: 'social',
			url: 'http://www.myspace.com/Modules/PostTo/Pages/?u={u}&amp;t={t}'},
		'n4g': {display: 'N4G', icon: 56, lang: 'en', category: 'other',
			url: 'http://www.n4g.com/tips.aspx?url={u}&amp;title={t}'},
		'netlog': {display: 'NetLog', icon: 101, lang: 'en', category: 'social',
			url: 'http://www.netlog.com/go/manage/links/view=save&amp;origin=external&amp;url={u}&amp;title={t}'},
		'netvibes': {display: 'Netvibes', icon: 102, lang: 'en', category: 'news',
			url: 'http://www.netvibes.com/share?url={u}&amp;title={t}'},
		'netvouz': {display: 'Netvouz', icon: 27, lang: 'en', category: 'bookmark',
			url: 'http://netvouz.com/action/submitBookmark?url={u}&amp;title={t}&amp;popup=no'},
		'newstrust': {display: 'NewsTrust', icon: 103, lang: 'en', category: 'news',
			url: 'http://newstrust.net/submit?url={u}&amp;title={t}&amp;ref=addtoany'},
		'newsvine': {display: 'Newsvine', icon: 28, lang: 'en', category: 'news',
			url: 'http://www.newsvine.com/_wine/save?u={u}&amp;h={t}'},
		'nowpublic': {display: 'NowPublic', icon: 29, lang: 'en', category: 'news',
			url: 'http://view.nowpublic.com/?src={u}&amp;t={t}'},
		'nujij': {display: 'Nujij', icon: 159, lang: 'nl', category: 'news',
			url: 'http://nujij.nl/jij.lynkx?u={u}&amp;t={t}&amp;b={d}'},
		'oknotizie': {display: 'OKNOtizie', icon: 57, lang: 'it', category: 'news',
			url: 'http://oknotizie.alice.it/post?url={u}&amp;title={t}'},
		'oneview': {display: 'OneView', icon: 72, lang: 'de', category: 'bookmark',
			url: 'http://www.oneview.de/quickadd/neu/addBookmark.jsf?URL={u}&amp;title={t}'},
		'orkut': {display: 'Orkut', icon: 193, lang: 'en', category: 'social',
			url: 'http://promote.orkut.com/preview?nt=orkut.com&amp;du={u}&amp;tt={t}&amp;cn='},
		'osmosus': {display: 'Osmosus', icon: 194, lang: 'en', category: 'social',
			url: 'http://www.osmosus.com/share?url={u}&amp;title={t}&amp;description={d}'},
		'oyyla': {display: 'Oyyla', icon: 160, lang: 'tr', category: 'news',
			url: 'http://www.oyyla.com/gonder?phase=2&amp;url={u}'},
		'phonefavs': {display: 'PhoneFavs', icon: 161, lang: 'en', category: 'bookmark',
			url: 'http://phonefavs.com/bookmarks?action=add&amp;address={u}&amp;title={t}'},
		'pimpthisblog': {display: 'PimpThisBlog', icon: 162, lang: 'en', category: 'news',
			url: 'http://pimpthisblog.com/Submit?url={u}&amp;title={t}'},
		'ping': {display: 'Ping', icon: 104, lang: 'en', category: 'social',
			url: 'http://ping.fm/ref/?link={u}&amp;title={t}'},
		'planypus': {display: 'Planypus', icon: 163, lang: 'en', category: 'other',
			url: 'http://planyp.us/plans/new/?url={u}&amp;title={t}'},
		'plaxo': {display: 'Plaxo Pulse', icon: 105, lang: 'en', category: 'social',
			url: 'http://www.plaxo.com/pulse/?share_link={u}'},
		'plurk': {display: 'Plurk', icon: 164, lang: 'en', category: 'social',
			url: 'http://www.plurk.com/m?content={u}&amp;qualifier=shares'},
		'polladium': {display: 'Polladium', icon: 165, lang: 'en', category: 'blog',
			url: 'http://www.polladium.com/poll-this.php?u={u}&amp;t={t}'},
		'popedition': {display: 'Popedition', icon: 312, lang: 'en', category: 'news',
			url: 'http://www.popedition.com/?mode=add&amp;url={u}&amp;title={t}'},
		'posteezy': {display: 'Posteezy', icon: 261, lang: 'en', category: 'blog',
			url: 'http://posteezy.com/node/add/story?body={u}&amp;title={t}'},
		'posterus': {display: 'posterous', icon: 166, lang: 'en', category: 'blog',
			url: 'http://posterous.com/share?linkto={u}&amp;title={t}'},
		'prati': {display: 'Prati.ba', icon: 262, lang: 'bs', category: 'blog',
			url: 'http://prati.ba/?objavi={u}'},
		'propeller': {display: 'Propeller', icon: 58, lang: 'en', category: 'news',
			url: 'http://www.propeller.com/submit/?U={u}&amp;T={t}'},
		'protopage': {display: 'Protopage', icon: 106, lang: 'en', category: 'other',
			url: 'http://www.protopage.com/add-button-site?url={u}&amp;label={t}&amp;type=page'},
		'pusha': {display: 'Pusha', icon: 107, lang: 'sv', category: 'bookmark',
			url: 'http://www.pusha.se/posta?url={u}'},
		'quantcast': {display: 'quantcast', icon: 263, lang: 'en', category: 'tools',
			url: 'http://www.quantcast.com/search.jsp?domain={u}'},
		'readitlater': {display: 'Read it Later', icon: 264, lang: 'en', category: 'tools',
			url: 'https://readitlaterlist.com/save?url={u}&amp;title={t}'},
		'receeveit': {display: 'receeve.it', icon: 313, lang: 'en', category: 'bookmark',
			url: 'http://add.receeve.it/?u={u}'},
		'reddit': {display: 'reddit', icon: 30, lang: 'en', category: 'news',
			url: 'http://reddit.com/submit?url={u}&amp;title={t}'},
		'rediff': {display: 'rediff', icon: 314, lang: 'en', category: 'social',
			url: 'http://share.rediff.com/bookmark/addbookmark?bookmarkurl={u}&amp;title={t}'},
		'redkum': {display: 'RedKum', icon: 315, lang: 'ru', category: 'bookmark',
			url: 'http://www.redkum.com/add?url={u}&amp;title={t}&amp;step=1'},
		'scoopat': {display: 'Scoop.at', icon: 265, lang: 'de', category: 'news',
			url: 'http://scoop.at/submit?url={u}&amp;title={t}&amp;body={d}'},
		'scoopeo': {display: 'Scoopeo', icon: 46, lang: 'fr', category: 'news',
			url: 'http://www.scoopeo.com/scoop/new?newurl={u}&amp;title={t}'},
		'segnalo': {display: 'Segnalo', icon: 31, lang: 'it', category: 'bookmark',
			url: 'http://segnalo.alice.it/post.html.php?url={u}&amp;title={t}'},
		'sekoman': {display: 'Sekoman', icon: 266, lang: 'lv', category: 'social',
			url: 'http://sekoman.lv/home?url={u}&amp;status={t}'},
		'shaveh': {display: 'Shaveh', icon: 267, lang: 'he', category: 'news',
			url: 'http://shaveh.co.il/submit.php?url={u}&amp;title={t}'},
		'shetoldme': {display: 'She Told Me', icon: 167, lang: 'en', category: 'news',
			url: 'http://shetoldme.com/publish?url={u}&amp;title={t}&amp;body={d}'},
		'shoutwire': {display: 'ShoutWire', icon: 108, lang: 'en', category: 'news',
			url: 'http://www.shoutwire.com/?s={u}'},
		'simpy': {display: 'Simpy', icon: 32, lang: 'en', category: 'bookmark',
			url: 'http://www.simpy.com/simpy/LinkAdd.do?href={u}&amp;title={t}'},
		'sitejot': {display: 'Sitejot', icon: 109, lang: 'en', category: 'bookmark',
			url: 'http://www.sitejot.com/addform.php?iSiteAdd={u}&amp;iSiteDes={t}'},
		'slashdot': {display: 'Slashdot', icon: 33, lang: 'en', category: 'news',
			url: 'http://slashdot.org/bookmark.pl?url={u}&amp;title={t}'},
		'smaknews': {display: 'SmakNews', icon: 110, lang: 'en', category: 'news',
			url: 'http://smaknews.com/submit.php?url={u}&amp;title={t}'},
		'smi': {display: 'СМИ2', icon: 268, lang: 'ru', category: 'news',
			url: 'http://smi2.ru/add/?url={u}&amp;precaption={t}'},
		'social': {display: 'Social Bookmarking', icon: 269, lang: 'en', category: 'social',
			url: 'http://www.social-bookmarking.net/submit.php?url={u}'},
		'sodahead': {display: 'SodaHead', icon: 168, lang: 'en', category: 'other',
			url: 'http://www.sodahead.com/news/submit/?url={u}&amp;title={t}'},
		'sonico': {display: 'Sonico', icon: 169, lang: 'en', category: 'social',
			url: 'http://www.sonico.com/share.php?url={u}&amp;title={t}'},
		'speedtile': {display: 'speedtile', icon: 270, lang: 'en', category: 'bookmark',
			url: 'http://www.speedtile.net/api/add/?u={u}&amp;t={t}'},
		'sphinn': {display: 'Sphinn', icon: 44, lang: 'en', category: 'news',
			url: 'http://sphinn.com/submit.php?url={u}&amp;title={t}'},
		'spokentoyou': {display: 'spoken to you', icon: 271, lang: 'en', category: 'other',
			url: 'http://www.spokentoyou.com/app/subscribe/index.html?url={u}&amp;title={t}'},
		'sportpost': {display: 'Sportpost', icon: 272, lang: 'en', category: 'social',
			url: 'http://www.sportpost.com/debate/new?url={u}&amp;title={t}&amp;desc={d}'},
		'springpad': {display: 'springpad', icon: 316, lang: 'en', category: 'bookmark',
			url: 'http://springpadit.com/s?type=lifemanagr.Bookmark&amp;url={u}&amp;name={t}'},
		'spruzer': {display: 'Spruzer', icon: 273, lang: 'en', category: 'bookmark',
			url: 'http://www.spruzer.com/submit.php?u={u}&amp;t={t}'},
		'spurl': {display: 'Spurl', icon: 35, lang: 'en', category: 'bookmark',
			url: 'http://www.spurl.net/spurl.php?url={u}&amp;title={t}'},
		'squidoo': {display: 'Squidoo', icon: 42, lang: 'en', category: 'bookmark',
			url: 'http://www.squidoo.com/lensmaster/bookmark?{u}&amp;title={t}'},
		'startaid': {display: 'StartAid', icon: 111, lang: 'en', category: 'bookmark',
			url: 'http://www.startaid.com/index.php?st=AddBrowserLink&amp;type=Detail&amp;v=3&amp;urlname={u}&amp;urltitle={t}'},
		'startlap': {display: 'startlap', icon: 274, lang: 'hu', category: 'bookmark',
			url: 'http://www.startlap.hu/sajat_linkek/addlink.php?url={u}&amp;title={t}'},
		'storyfollower': {display: 'StoryFollower', icon: 275, lang: 'en', category: 'news',
			url: 'http://www.storyfollower.com/submit/?url={u}&amp;title={t}&amp;description={d}'},
		'strands': {display: 'Strands', icon: 112, lang: 'en', category: 'social',
			url: 'http://www.strands.com/tools/share/webpage?url={u}&amp;title={t}'},
		'studivz': {display: 'studiVZ', icon: 195, lang: 'de', category: 'social',
			url: 'http://www.studivz.net/Suggest/Selection/?u={u}&amp;desc={t}'},
		'stuffpit': {display: 'Stuffpit', icon: 276, lang: 'en', category: 'shopping',
			url: 'http://www.stuffpit.com/add.php?produrl={u}'},
		'stumbleupon': {display: 'StumbleUpon', icon: 36, lang: 'en', category: 'bookmark',
			url: 'http://www.stumbleupon.com/submit?url={u}&amp;title={t}'},
		'stumpedia': {display: 'Stumpedia', icon: 113, lang: 'en', category: 'other',
			url: 'http://www.stumpedia.com/submit?url={u}&amp;title={t}'},
		'stylehive': {display: 'Stylehive', icon: 196, lang: 'en', category: 'social',
			url: 'http://www.stylehive.com/savebookmark/index.htm?url={u}'},
		'surfpeople': {display: 'SurfPeople', icon: 277, lang: 'en', category: 'social',
			url: 'http://www.surfpeople.net/share-link.php?url={u}&amp;titless={t}'},
		'svejo': {display: 'Svejo', icon: 170, lang: 'ru', category: 'news',
			url: 'http://svejo.net/story/submit_by_url?url={u}&amp;title={t}&amp;summary={d}'},
		'tagmarks': {display: 'TagMarks', icon: 317, lang: 'de', category: 'bookmark',
			url: 'http://tagmarks.de/?go=1&amp;url={u}'},
		'tagvn': {display: 'Tagvn', icon: 278, lang: 'vi', category: 'news',
			url: 'http://www.tagvn.com/submit?url={u}'},
		'tagza': {display: 'Tagza', icon: 115, lang: 'en', category: 'bookmark',
			url: 'http://www.tagza.com/submit.php?url={u}'},
		'technorati': {display: 'Technorati', icon: 38, lang: 'en', category: 'news',
			url: 'http://www.technorati.com/faves?add={u}'},
		'technotizie': {display: 'Technotizie', icon: 117, lang: 'it', category: 'news',
			url: 'http://www.technotizie.it/posta_ok?action=f2&amp;url={u}&amp;title={t}'},
		'tellmypolitician': {display: 'TellMyPolitician', icon: 171, lang: 'en', category: 'other',
			url: 'http://tellmypolitician.com/search?u={u}&amp;title={t}'},
		'thewebblend': {display: 'The Web Blend', icon: 318, lang: 'en', category: 'bookmark',
			url: 'http://thewebblend.com/submit?url={u}&amp;title={t}'},
		'thinkfinity': {display: 'Thinkfinity', icon: 319, lang: 'en', category: 'bookmark',
			url: 'http://community.thinkfinity.org/favorite-bookmarklet.jspa?url={u}&amp;subject={t}'},
		'thisnext': {display: 'ThisNext', icon: 39, lang: 'en', category: 'shopping',
			url: 'http://www.thisnext.com/pick/new/submit/sociable/?url={u}&amp;name={t}'},
		'tipd': {display: 'Tip\'d', icon: 118, lang: 'en', category: 'news',
			url: 'http://tipd.com/submit.php?url={u}'},
		'transferr': {display: 'Transferr', icon: 197, lang: 'en', category: 'other',
			url: 'http://www.transferr.com/link.php?url={u}'},
		'tulinq': {display: 'tulinq', icon: 198, lang: 'es', category: 'news',
			url: 'http://www.tulinq.com/enviar?url={u}&amp;title={t}&amp;body={d}'},
		'tumblr': {display: 'tumblr', icon: 119, lang: 'en', category: 'blog',
			url: 'http://www.tumblr.com/share?v=3&amp;u={u}&amp;t={t}'},
		'tusul': {display: 'tusul.com', icon: 199, lang: 'tr', category: 'bookmark',
			url: 'http://www.tusul.com/submit.php?url={u}&amp;title={t}&amp;bodytext={d}'},
		'tweetmeme': {display: 'tweetmeme', icon: 279, lang: 'en', category: 'tools',
			url: 'http://api.tweetmeme.com/visit?url={u}'},
		'twitter':{display: 'twitter', icon: 200, lang: 'en', category: 'blog',
			url: 'http://twitter.com/home?status={t}%20{u}'},
		'twitthis': {display: 'TwitThis', icon: 45, lang: 'en', category: 'tools',
			url: 'http://twitthis.com/twit?url={u}'},
		'viadeo': {display: 'Viadeo', icon: 120, lang: 'en', category: 'social',
			url: 'http://www.viadeo.com/shareit/share/?url={u}&amp;title={t}'},
		'virb': {display: 'Virb', icon: 172, lang: 'en', category: 'social',
			url: 'http://virb.com/share?external&amp;v=2&amp;url={u}&amp;title={t}'},
		'visitezmonsite': {display: 'Visitez mon Site', icon: 280, lang: 'fr', category: 'bookmark',
			url: 'http://www.visitezmonsite.com/publier?url={u}&amp;title={t}&amp;body={d}'},
		'vk': {display: 'VK.com', icon: 320, lang: 'en', category: 'social',
			url: 'http://vk.com/share.php?url={u}&amp;title={t}'},
		'vodpod': {display: 'Vodpod', icon: 121, lang: 'en', category: 'bookmark',
			url: 'http://vodpod.com/account/add_video_page?p={u}'},
		'vyoom': {display: 'vyoom', icon: 281, lang: 'en', category: 'other',
			url: 'http://www.vyoom.com/mod/bookmarks/add.php?address={u}&amp;title={t}'},
		'webnews': {display: 'WebNews', icon: 122, lang: 'de', category: 'news',
			url: 'http://www.webnews.de/einstellen?url={u}&amp;title={t}'},
		'wikio': {display: 'Wikio', icon: 47, lang: 'en', category: 'social',
			url: 'http://www.wikio.com/vote?newurl={u}'},
		'windows': {display: 'Windows Live', icon: 40, lang: 'en', category: 'bookmark',
			url: 'https://favorites.live.com/quickadd.aspx?marklet=1&amp;mkt=en-us&amp;url={u}&amp;title={t}'},
		'windycitizen': {display: 'Windy Citizen', icon: 282, lang: 'en', category: 'news',
			url: 'http://www.windycitizen.com/submit?url={u}&amp;title={t}&amp;body={d}'},
		'wirefan': {display: 'WireFan', icon: 283, lang: 'en', category: 'bookmark',
			url: 'http://www.wirefan.com/grpost.php?d=&amp;u={u}&amp;h={t}&amp;d={d}'},
		'wishlist': {display: 'Amazon WishList', icon: 123, lang: 'en', category: 'shopping',
			url: 'http://www.amazon.com/wishlist/add?u={u}&amp;t={t}'},
		'wists': {display: 'Wists', icon: 124, lang: 'en', category: 'other',
			url: 'http://wists.com/r.php?r={u}&amp;title={t}'},
		'worio': {display: 'Worio', icon: 173, lang: 'en', category: 'other',
			url: 'http://www.worio.com/search/preview/?action=save&amp;wref=addthis&amp;u={u}&amp;t={t}'},
		'wovre': {display: 'Wovre', icon: 174, lang: 'en', category: 'social',
			url: 'http://www.wovre.com/share.php?link_url={u}'},
		'wykop': {display: 'Wykop', icon: 175, lang: 'pl', category: 'bookmark',
			url: 'http://www.wykop.pl/dodaj?url={u}&amp;title={t}&amp;desc={d}'},
		'xanga': {display: 'Xanga', icon: 59, lang: 'en', category: 'blog',
			url: 'http://www.xanga.com/private/editorx.aspx?u={u}&amp;t={t}'},
		'xerpi': {display: 'Xerpi', icon: 125, lang: 'en', category: 'bookmark',
			url: 'http://www.xerpi.com/block/add_link_from_extension?url={u}&amp;title={t}'},
		'yahoo': {display: 'Yahoo Bookmarks', icon: 60, lang: 'en', category: 'bookmark',
			url: 'http://bookmarks.yahoo.com/toolbar/savebm?opener=tb&amp;u={u}&amp;t={t}'},
		'yahoobuzz': {display: 'Yahoo Buzz', icon: 67, lang: 'en', category: 'bookmark',
			url: 'http://buzz.yahoo.com/submit?submitUrl={u}&amp;submitHeadline={t}'},
		'yammer': {display: 'Yammer', icon: 176, lang: 'en', category: 'blog',
			url: 'http://www.yammer.com/home?status={t} {u}'},
		'yazzem': {display: 'yazzem', icon: 284, lang: 'en', category: 'social',
			url: 'http://www.yazzem.com/welcome?status={t}%3A+{u}'},
		'yigg': {display: 'Yigg', icon: 61, lang: 'de', category: 'news',
			url: 'http://www.yigg.de/neu?exturl={u}&amp;exttitle={t}'},
		'yoolink': {display: 'yoolink', icon: 126, lang: 'en', category: 'bookmark',
			url: 'http://www.yoolink.fr/post/tag?f=aa&amp;url_value={u}&amp;title={t}'},
		'yorumcuyum': {display: 'Yorumcuyum', icon: 177, lang: 'tr', category: 'news',
			url: 'http://www.yorumcuyum.com/?link={u}&amp;baslik={t}'},
		'youbookmarks': {display: 'YouBookmarks', icon: 285, lang: 'en', category: 'bookmark',
			url: 'http://youbookmarks.com/api/quick_add.php?version=1&amp;url={u}&amp;title={t}'},
		'youmob': {display: 'YouMob', icon: 178, lang: 'en', category: 'bookmark',
			url: 'http://youmob.com/mobit.aspx?mob={u}&amp;title={t}'},
		'zakladok': {display: 'закладок', icon: 321, lang: 'ru', category: 'bookmark',
			url: 'http://zakladok.net/link/?u={u}&amp;t={t}'},
		'zanatic': {display: 'Zanatic', icon: 322, lang: 'en', category: 'news',
			url: 'http://www.zanatic.com/submit?u={u}&amp;t={t}'},
		'zooloo': {display: 'ZooLoo', icon: 286, lang: 'en', category: 'blog',
			url: 'https://www.zooloo.com/redirecter/login?domainredirect=zGraffiti/share&amp;v=1&amp;u={u}&amp;t={t}'}
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
