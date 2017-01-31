/*
Copyright (c) 2003-2010, CKSource - Frederico Knabben. All rights reserved.
For licensing, see LICENSE.html or http://ckeditor.com/license
*/

CKEDITOR.editorConfig = function( config )
{
	
	config.entities = false;
	config.entities_latin = false;

    config.extraPlugins = 'MediaEmbed';

// This is actually the default value.
/*
	config.smiley_images = [
    'regular_smile.gif','sad_smile.gif','wink_smile.gif','teeth_smile.gif','confused_smile.gif','tounge_smile.gif',
    'embaressed_smile.gif','omg_smile.gif','whatchutalkingabout_smile.gif','angry_smile.gif','angel_smile.gif','shades_smile.gif',
    'devil_smile.gif','cry_smile.gif','lightbulb.gif','thumbs_down.gif','thumbs_up.gif','heart.gif',
    'broken_heart.gif','kiss.gif','envelope.gif'
	];

	config.smiley_descriptions =
    [
        'smiley', 'sad', 'wink', 'laugh', 'frown', 'cheeky', 'blush', 'surprise',
        'indecision', 'angry', 'angel', 'cool', 'devil', 'crying', 'enlightened', 'no',
        'yes', 'heart', 'broken heart', 'kiss', 'mail'
    ];
	*/

	// Define changes to default configuration here. For example:
	// config.language = 'fr';
	// config.uiColor = '#AADC6E';
	config.toolbar = 'Comments';

config.toolbar_Comments =
[
    ['Templates'],
    ['Bold','Italic','Underline'],
	['Image','MediaEmbed','Smiley'],
    ['NumberedList','BulletedList'],
    ['JustifyLeft','JustifyCenter','JustifyRight','JustifyBlock'],
    ['Link','Unlink'],
    ['HorizontalRule','FontSize'],
    ['Maximize'],
   
];

config.toolbar_CommentsFull =
[
    ['Templates'],
    ['Cut','Copy','Paste','PasteText','PasteFromWord','-', 'SpellChecker', 'Scayt'],
    ['Undo','Redo','-','Find','Replace','-','SelectAll','RemoveFormat'],
  
    ['BidiLtr', 'BidiRtl'],
    '/',
    ['Bold','Italic','Underline','Strike'],
    ['NumberedList','BulletedList','-','Outdent','Indent','Blockquote'],
    ['JustifyLeft','JustifyCenter','JustifyRight','JustifyBlock'],
    ['Link','Unlink','Anchor'],
    ['Table','HorizontalRule','SpecialChar'],
    '/',
    ['Styles','Format','FontSize'],
    ['TextColor','BGColor'],
    ['Maximize'],
    ['Image','MediaEmbed' ,'Flash','Smiley'],
];

};
