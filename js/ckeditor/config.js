/*
Copyright (c) 2003-2010, CKSource - Frederico Knabben. All rights reserved.
For licensing, see LICENSE.html or http://ckeditor.com/license
*/

CKEDITOR.editorConfig = function( config )
{
	
	config.entities = false;
	config.entities_latin = false;

    config.extraPlugins = 'MediaEmbed';


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
