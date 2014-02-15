FCKConfig.ToolbarSets['Default'] = [
	['Cut','Copy','Paste','PasteText','PasteWord','Undo','Redo','-','SelectAll','RemoveFormat','-',
	'Source','-','Preview','-'],
	'/',
	['Bold','Italic','Underline','StrikeThrough','-','Subscript','Superscript','-','OrderedList','UnorderedList','-','Outdent','Indent','-','JustifyLeft','JustifyCenter','JustifyRight','JustifyFull','-','Link','Unlink','-','Image','Table','Rule','Smiley'],
	'/',
	['Style','FontName','FontSize','-','TextColor','BGColor']
	

] ;

FCKConfig.ToolbarSets["Basic"] = [
	['Bold','Italic','Underline','-','OrderedList','UnorderedList','-',
	'Image','Link','Unlink','-','TextColor','BGColor','-','FontSize'],['RemoveFormat','Preview']
] ;

FCKConfig.AutoDetectLanguage	= false ;
FCKConfig.DefaultLanguage		= 'fr' ;

FCKConfig.EnableXHTML		= true ;
FCKConfig.EnableSourceXHTML	= true ;

FCKConfig.FontNames		= 'Verdana;Arial;Comic Sans MS;Courier New;Tahoma;Times New Roman;Verdana' ;
FCKConfig.FontSizes		= '1/normal-;2/NORMAL;3/normal +;4/grand -;5/grand;6/grand +;7/grand ++' ;

FCKConfig.StylesXmlPath		= FCKConfig.EditorPath + 'fckstyles.xml' ;

// The following value defines which File Browser connector and Quick Upload 
// "uploader" to use. It is valid for the default implementaion and it is here
// just to make this configuration file cleaner. 
// It is not possible to change this value using an external file or even 
// inline when creating the editor instance. In that cases you must set the 
// values of LinkBrowserURL, ImageBrowserURL and so on.
// Custom implementations should just ignore it.
var _FileBrowserLanguage	= 'php' ;	// asp | aspx | cfm | lasso | perl | php | py
var _QuickUploadLanguage	= 'php' ;	// asp | aspx | cfm | lasso | php

// Don't care about the following line. It just calculates the correct connector 
// extension to use for the default File Browser (Perl uses "cgi").
var _FileBrowserExtension = _FileBrowserLanguage == 'perl' ? 'cgi' : _FileBrowserLanguage ;

FCKConfig.ImageBrowser = true ;
FCKConfig.ImageBrowserURL = FCKConfig.BasePath + 'filemanager/browser/default/browser.html?Type=Image&Connector=connectors/' + _FileBrowserLanguage + '/connector.' + _FileBrowserExtension ;
FCKConfig.ImageBrowserWindowWidth  = FCKConfig.ScreenWidth * 0.7 ;	// 70% ;
FCKConfig.ImageBrowserWindowHeight = FCKConfig.ScreenHeight * 0.7 ;	// 70% ;

FCKConfig.ImageUpload = true ;
FCKConfig.ImageUploadURL = FCKConfig.BasePath + 'filemanager/upload/' + FCKConfig.QuickUploadLanguage + '/upload.' + _QuickUploadLanguage + '?Type=Image' ;
FCKConfig.ImageUploadAllowedExtensions	= ".(jpg|gif|jpeg|png)$" ;		// empty for all
FCKConfig.ImageUploadDeniedExtensions	= "" ;							// empty for no one



