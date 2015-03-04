/**
 * @license Copyright (c) 2003-2013, CKSource - Frederico Knabben. All rights reserved.
 * For licensing, see LICENSE.html or http://ckeditor.com/license
 */

CKEDITOR.editorConfig = function( config ) {
	
	// %REMOVE_START%
	// The configuration options below are needed when running CKEditor from source files.
	config.plugins =
	'dialogui,dialog,dialogadvtab,basicstyles,bidi,blockquote,clipboard,htmlwriter,button,panelbutton,panel,floatpanel,colorbutton,colordialog,templates,menu,contextmenu,div,resize,toolbar,elementspath,enterkey,entities,popup,find,fakeobjects,floatingspace,listblock,richcombo,font,format,horizontalrule,iframe,wysiwygarea,indent,indentblock,indentlist,justify,menubutton,link,list,liststyle,magicline,maximize,pagebreak,pastetext,pastefromword,preview,print,removeformat,showblocks,showborders,sourcearea,specialchar,scayt,stylescombo,tab,table,undo,wsc';
	/*about,forms,smiley,save,selectall,newpage,language,a11yhelp,image,flash,htmlwriter,filebrowser*/
	config.skin = 'moono';
	// %REMOVE_END%

	// Define changes to default configuration here. For example:
	// config.language = 'fr';
	// config.uiColor = '#AADC6E';
};
