
FCKConfig.Plugins.Add('EmbedMovies') ;
FCKConfig.Plugins.Add( 'insertHtmlCode' ) ;
// FCKLang[InsertHtmlCode]="Insert HTML Code";

FCKConfig.ToolbarSets["Leonardo"] = [
['Source','DocProps','-','Save','NewPage','Preview','-','Templates'],
['Cut','Copy','Paste','PasteText','PasteWord','-','Print','SpellCheck'],
['Undo','Redo','-','Find','Replace','-','SelectAll','RemoveFormat'],
['About'] ,
['Bold','Italic','Underline','TextColor','BGColor','-','Subscript','Superscript'],
['OrderedList','UnorderedList','-','Outdent','Indent'],
['JustifyLeft','JustifyCenter','JustifyRight','JustifyFull'],
['Link','Unlink','Anchor'],
['Image','Flash','Table','Rule','SpecialChar','Smiley'],
'/',
['Style','FontFormat','FontName','FontSize']
] ;

FCKConfig.ToolbarSets["LeonardoSimple"] = [
['Bold','Italic','Underline','TextColor','-','JustifyLeft','JustifyCenter','JustifyRight','JustifyFull'],
['OrderedList','UnorderedList','Outdent','Indent'],
['Link','Unlink','Flash','EmbedMovies','insertHtmlCode','Smiley','Rule'],
['Undo','Redo','-','SelectAll','RemoveFormat','-','Cut','Copy','Paste','PasteText','PasteWord','About']
] ;

