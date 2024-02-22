# Cmsgrid
CMSGrid is a CKEditor 4 plugin that helps users create and arrange Bootstrap 3 grid layouts. 

* Insert a variety of Bootstrap 3 layouts
* Add or remove rows
* Increase or decrease width of columns
* Insert images which resize responsively with column resizing
* Swap content of columns
* Delete rows
* All features grouped in toolbar / operable with right click

## Demo

<p>Take a look at the <a href="http://cmsgrid.filestorage.club/" target="_blank">CMSGrid demo</a> page.</p>

## Installation

* Download the plugin
* Extract the contents to your CKEditor 4 plugins directory: `/path/to/ckeditor/plugins/cmsgrid`
* Open this file `/path/to/ckeditor/config.js`, and add the code below to it.
* You'll have to edit the lines of code below which refer to Bootstrap 3 & jQuery and set the paths & versions accordingly
* Also note that the editorConfig below has been stripped down to just show the cmsgrid toolbar, you'll want to add in the standard wysiwyg features

```
 CKEDITOR.editorConfig = function( config ) {
	config.toolbar = [
	{ name: 'cmsgrid', items: ['AddCMSGrid', 'AddCMSGridRow','DeleteCMSGridRow','ExpandCMSColLeft','ExpandCMSColRight','SwapCMSCols']}
	];
 };
 
 CKEDITOR.config.allowedContent = true;
 CKEDITOR.config.extraPlugins = 'cmsgrid;
 CKEDITOR.config.bodyClass = "container";
 CKEDITOR.config.contentsCss = '/path/to/bootstrap/css/bootstrap.min.css';
  
 function loadBootstrap(event) {
    if (event.name == 'mode' && event.editor.mode == 'source')
        return;

    var jQuery = document.createElement('script');
    var bootstrapJs = document.createElement('script');
    jQuery.src = '/path/to/jquery-1.11.0.min.js';
    bootstrapJs.src = '/path/to/bootstrap/js/bootstrap.min.js';

    var editorHead = event.editor.document.$.head;

    editorHead.appendChild(jQuery);
    jQuery.onload = function() {
      editorHead.appendChild(bootstrapJs);
    };
}

```

* Lastly, embed CKEditor 4 like so in your html page

```
<textarea name="editor" id="editor"></textarea>
<script>
  CKEDITOR.replace( 'editor', {
	  on: {
		  instanceReady: loadBootstrap,
			mode: loadBootstrap
		 }
  });
</script>
```



