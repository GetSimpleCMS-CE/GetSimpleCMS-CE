/*
 Copyright (c) 2003-2016, CKSource - Frederico Knabben. All rights reserved.
 For licensing, see LICENSE.md or http://ckeditor.com/license
*/
CKEDITOR.addTemplates("default",{imagesPath:CKEDITOR.getUrl(CKEDITOR.plugins.getPath("templates")+"templates/images/"),templates:[

{title:"Image and Title",image:"template1.gif",description:"One main image with a title and text that surround the image.",html:'<h3><img align="left" alt="" src="http://via.placeholder.com/300x200" style="margin-right: 10px" width="100" />Type the title here</h3><p>Type the text here</p>'},

{title:"Strange Template",image:"template2.gif",description:"A template that defines two columns, each one with a title, and some text.",
html:'<table border="0" cellpadding="0" cellspacing="0" style="width:100%"><tbody><tr><td style="width:50%"><h3>xTitle 1</h3></td><td>&nbsp;</td><td style="width:50%"><h3>Title 2</h3></td></tr><tr><td>Text 1</td><td>&nbsp;</td><td>Text 2</td></tr></tbody></table><p>More text goes here.</p>'},

{title:"Text and Table",image:"template3.gif",description:"A title with some text and a table.",
html:'<div style="width: 80%"><h3>Title goes here</h3><table border="1" cellpadding="0" cellspacing="0" style="width:150px;float: right"><caption style="border:solid 1px black"><strong>Table title</strong></caption><tbody><tr><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr><tr><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr><tr><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr></tbody></table><p>Type the text here</p></div>'}

]});