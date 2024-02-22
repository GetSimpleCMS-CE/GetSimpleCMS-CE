CKEDITOR.dialog.add('cmsgridDialog', function(editor) {
    // Setup lang
    var lang = editor.lang.cmsgrid;

    return {
        title: lang.windowTitle,
        minWidth:320,
        minHeight: 440,
        contents: [
	        {
	            id: 'tab-add',
	            label: lang.addTab,
	            elements: [{
	                id: 'addCMSGrid',
	                type: 'html',
	                validate: function() {
	                    var rowCount = $("#rows").val();
	                    var colCount = $("input[name='layout']:checked").val();
	                    if (!colCount || !rowCount || !$.isNumeric(rowCount)) {
	                        $(".grid-error").removeClass("hidden");
	                        return false;
	                    };
	                },
	                html: '<style type="text/css">' +
	                    '.sr-only{position:absolute;width:1px;height:1px;padding:0;margin:-1px;overflow:hidden;clip:rect(0,0,0,0);border:0}.sr-only-focusable:active,.sr-only-focusable:focus{position:static;width:auto;height:auto;margin:0;overflow:visible;clip:auto}' +
	                    '.hidden {display:none}' +
	                    '.alert {padding:15px;margin-bottom:20px;border:1px solid transparent;border-radius:4px}' +
	                    '.alert-danger{color:#a94442;background-color:#f2dede;border-color:#ebccd1}' +
	                    '.cmsgrid-html * {box-sizing: border-box}' +
	                    '.cmsgrid-html p {margin: 10px 0px 10px 0px;line-height: 16px; white-space:normal; clear: both;}' +
	                    '.cmsgrid-html .section {margin: 0px;font-size: 12px; font-weight: bold}' +
	                    '.cmsgrid-html label {text-align:center; margin: 0px 10px 10px 0px;float:left}' +
	                    '.cmsgrid-html label img {display:block; margin: 0px 0px 3px 0px;}' +
	                    '.cmsgrid-html .alert * {color:#a94442 !important}' +
	                    '.cmsgrid-html input[type="text"] {width: 50px;margin-top: 20px;}' +
	                    '@media (min-width: 0px) {' +
	                    '	.cmsgrid-html img {width: 80px}' +
	                    '}' +
	                    '@media (min-width: 480px) {' +
	                    '	.cmsgrid-html img { width: auto}' +
	                    '}' +
	                    '</style>' +
	                    '<div class="cmsgrid-html">' +
	                    '<div class="alert alert-danger hidden grid-error" role="alert"> ' + lang.layoutError + '</div>' +
	                    '<p class="section">' + lang.stepOneText + '</p>' +
	                    '<p>' + lang.largeRightColText + '</p>' +
	                    '<label for="layout-48">' +
	                    '	<div class="sr-only">' + lang.layout48Text + '</div>' +
	                    '   <img src="/admin/template/js/ckeditor/plugins/cmsgrid/img/48.png" alt="">' +
	                    '    <input type="radio" value="48" name="layout" id="layout-48" checked>' +
	                    '</label>' +
	                    '<label for="layout-39">' +
	                    '	<div class="sr-only">' + lang.layout39Text + '</div>' +
	                    '     <img src="/admin/template/js/ckeditor/plugins/cmsgrid/img/39.png" alt="">' +
	                    '    <input type="radio" value="39" name="layout" id="layout-39">' +
	                    '</label>' +
	                    '<label for="layout-210">' +
	                    '	<div class="sr-only">' + lang.layout210Text + '</div>' +
	                    '     <img src="/admin/template/js/ckeditor/plugins/cmsgrid/img/210.png" alt="">' +
	                    '    <input type="radio" value="210" name="layout" id="layout-210">' +
	                    '</label>' +
	                    '<p>' + lang.largeLeftColText + '</p>' +
	                    '<label for="layout-84">' +
	                    '	<div class="sr-only">' + lang.layout84Text + '</div>' +
	                    '     <img src="/admin/template/js/ckeditor/plugins/cmsgrid/img/84.png" alt="">' +
	                    '    <input type="radio" value="84" name="layout" id="layout-84">' +
	                    '</label>' +
	                    '<label for="layout-93">' +
	                    '	<div class="sr-only">' + lang.layout93Text + '</div>' +
	                    '    <img src="/admin/template/js/ckeditor/plugins/cmsgrid/img/93.png" alt="">' +
	                    '    <input type="radio" value="93" name="layout" id="layout-93">' +
	                    '</label>' +
	                    '<label for"layout-102">' +
	                    '	<div class="sr-only">' + lang.layout102Text + '</div>' +
	                    '     <img src="/admin/template/js/ckeditor/plugins/cmsgrid/img/102.png" alt="">' +
	                    '    <input type="radio" value="102" name="layout" id="layout-102">' +
	                    '</label>' +
	                    '<p>' + lang.evenColText + '</p>' +
	                    '<label for="layout-66">' +
	                    '	<div class="sr-only">' + lang.layout66Text + '</div>' +
	                    '     <img src="/admin/template/js/ckeditor/plugins/cmsgrid/img/66.png" alt="">' +
	                    '    <input type="radio" value="66" name="layout" id="layout-66">' +
	                    '</label>' +
	                    '<label for="layout-444">' +
	                    '    <div class="sr-only">' + lang.layout444Text + '</div>' +
	                    '     <img src="/admin/template/js/ckeditor/plugins/cmsgrid/img/444.png" alt="">' +
	                    '    <input type="radio" value="444" name="layout" id="layout-444">' +
	                    '</label>' +
	                    '<label for="layout-3333">' +
	                    ' 	<div class="sr-only">' + lang.layout3333Text + '</div>' +
	                    '     <img src="/admin/template/js/ckeditor/plugins/cmsgrid/img/3333.png" alt="">' +
	                    '    <input type="radio" value="3333" name="layout" id="layout-3333">' +
	                    '</label>' +
	                    '<p class="section">' + lang.stepTwoText + '</p>' +
	                    '<label for="rows">' +
	                    '<div class="sr-only">choose the number of rows</div>' +
	                    '<input type="text" value="1" class="cke_dialog_ui_input_text" id="rows">' +
	                    '</label>' +
	                    '</div>'
	            }]
	        }
        ],
        onShow: function() {
			// Reset error message
			$(".grid-error").addClass("hidden");
			// Focus
			setTimeout(function(){$("#rows").val("1").focus(),1});
        },
        onOk: function() {

            // Get values
			var rows = $("#rows").val();
			var layout = $("input[name='layout']:checked").val();  
			
			// Output grid
			var content = "";
			var createGrid = function(layout,rows) {
	            content +=  '<div class="row">';
	            switch (layout) {
	                case '66':
	                    content += '<div class="col-md-6">' +
	                        '<p><br></p>' +
	                        '</div>' +
	                        '<div class="col-md-6">' +
	                        '<p><br></p>' +
	                        '</div>';
	                    break;
	                case '444':
	                    content += '<div class="col-md-4">' +
	                        '<p><br></p>' +
	                        '</div>' +
	                        '<div class="col-md-4">' +
	                        '<p><br></p>' +
	                        '</div>' +
	                        '<div class="col-md-4">' +
	                        '<p><br></p>' +
	                        '</div>';
	                    break;
	                case '3333':
	                    content += '<div class="col-md-3">' +
	                        '<p><br></p>' +
	                        '</div>' +
	                        '<div class="col-md-3">' +
	                        '<p><br></p>' +
	                        '</div>' +
	                        '<div class="col-md-3">' +
	                        '<p><br></p>' +
	                        '</div>' +
	                        '<div class="col-md-3">' +
	                        '<p><br></p>' +
	                        '</div>';
	                    break;
	                case '210':
	                    content += '<div class="col-md-2">' +
	                        '<p><br></p>' +
	                        '</div>' +
	                        '<div class="col-md-10">' +
	                        '<p><br></p>' +
	                        '</div>';
	                    break;
	                case '39':
	                    content += '<div class="col-md-3">' +
	                        '<p><br></p>' +
	                        '</div>' +
	                        '<div class="col-md-9">' +
	                        '<p><br></p>' +
	                        '</div>';
	                    break;
	                case '48':
	                    content += '<div class="col-md-4">' +
	                        '<p><br></p>' +
	                        '</div>' +
	                        '<div class="col-md-8">' +
	                        '<p><br></p>' +
	                        '</div>';
	                    break;
	                case '102':
	                    content += '<div class="col-md-10">' +
	                        '<p><br></p>' +
	                        '</div>' +
	                        '<div class="col-md-2">' +
	                        '<p><br></p>' +
	                        '</div>';
	                    break;
	                case '93':
	                    content += '<div class="col-md-9">' +
	                        '<p><br></p>' +
	                        '</div>' +
	                        '<div class="col-md-3">' +
	                        '<p><br></p>' +
	                        '</div>';
	                    break;
	                case '84':
	                    content += '<div class="col-md-8">' +
	                        '<p><br></p>' +
	                        '</div>' +
	                        '<div class="col-md-4">' +
	                        '<p><br></p>' +
	                        '</div>';
	                    break;
	            }
	            content += '</div>';
	        }
	        for (var i = 1; i <= rows; i++) {
				createGrid(layout,rows);	
			};
			content += '<p><br></p>';
			editor.insertHtml(content);
        }
    }
});