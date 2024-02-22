CKEDITOR.plugins.add('cmsgrid', {
    lang: [ 'de', 'en', 'es', 'fr', 'it', 'ja', 'nl', 'pl', 'pt', 'ru', 'uk'],
    icons: 'cmsgrid',
    hidpi: true,
    init: function(editor) {
	    // Hidpi?
	    var iconpath;
        if (CKEDITOR.env.hidpi) {
	        this.iconpath = this.path+"icons/hidpi/"
        } else {
	        this.iconpath = this.path+"icons/";
        };
        
        // Setup lang, css, js
        var lang = editor.lang.cmsgrid;
		editor.addContentsCss(this.path + 'styles/cmsgrid.css');
		//editor.addContentsCss('/path/to/bootstrap/css/bootstrap.min.css');
		 
        // Dialog window
        editor.addCommand('cmsgridDialog', new CKEDITOR.dialogCommand('cmsgridDialog'));
        CKEDITOR.dialog.add('cmsgridDialog', this.path + 'dialogs/cmsgrid.js');
      
        // Toolbar 
        editor.ui.addButton('AddCMSGrid', {
            label: lang.btnAddGrid,
            command: 'cmsgridDialog',
            icon: this.iconpath + 'cmsgrid-add.png'
        });
        
        editor.ui.addButton('AddCMSGridRow', {
            label: lang.btnAddRow,
            command: 'addCMSGridRow',
            icon: this.iconpath + 'cmsgrid-add-row.png'
        });
        
        editor.ui.addButton('DeleteCMSGridRow', {
            label: lang.btnDeleteRow,
            command: 'deleteCMSGridRow',
            icon: this.iconpath + 'cmsgrid-delete-row.png'
        });
        
        editor.ui.addButton('ExpandCMSColLeft', {
            label: lang.btnExpandLeftCol,
            command: 'expandCMSColLeft',
            icon: this.iconpath + 'cmsgrid-expand-left.png'
        });
        
        editor.ui.addButton('ExpandCMSColRight', {
            label: lang.btnExpandRightCol,
            command: 'expandCMSColRight',
            icon: this.iconpath + 'cmsgrid-expand-right.png'
        });
        
        editor.ui.addButton('SwapCMSCols', {
            label: lang.btnSwapCols,
            command: 'swapCMSCols',
            icon: this.iconpath + 'cmsgrid-swap-cols.png'
        });
        
        // Add context menu
	   if (editor.contextMenu) {
	         editor.addMenuGroup('cmsgridGroup');
	         editor.addMenuItem('addCMSGridRow', {
	             label: lang.btnAddRow,
	             icon: this.iconpath + 'cmsgrid-add-row.png',
	             command: 'addCMSGridRow',
	             group: 'cmsgridGroup',
	             order: 1
	         });
	         
	         editor.addMenuItem('deleteCMSGridRow', {
	             label: lang.btnDeleteRow,
	             icon: this.iconpath + 'cmsgrid-delete-row.png',
	             command: 'deleteCMSGridRow',
	             group: 'cmsgridGroup',
	             order: 2
	         });
	         
	         editor.addMenuItem('expandCMSColRight', {
	             label: lang.btnExpandRightCol,
	             icon: this.iconpath + 'cmsgrid-expand-right.png',
	             command: 'expandCMSColRight',
	             group: 'cmsgridGroup',
	             order: 3
	         });
	         
	         editor.addMenuItem('expandCMSColLeft', {
	             label: lang.btnExpandLeftCol,
	             icon: this.iconpath + 'cmsgrid-expand-left.png',
	             command: 'expandCMSColLeft',
	             group: 'cmsgridGroup',
	             order: 4
	         });
	         
	         editor.addMenuItem('swapCMSCols', {
	             label: lang.btnSwapCols,
	             icon: this.iconpath + 'cmsgrid-swap-cols.png',
	             command: 'swapCMSCols',
	             group: 'cmsgridGroup',
	             order: 5
	         });
	         		         
	         editor.contextMenu.addListener(function(element) {
	             ascendant = element.getAscendant(function(element) {
	                 return !(element instanceof CKEDITOR.dom.document) &&
	                     (element.hasClass("row"));
	             });
	             if (ascendant) {
	                 return {
	                     addCMSGridRow: CKEDITOR.TRISTATE_OFF,
	                     deleteCMSGridRow: CKEDITOR.TRISTATE_OFF,
	                     expandCMSColRight: CKEDITOR.TRISTATE_OFF,
	                     expandCMSColLeft: CKEDITOR.TRISTATE_OFF,
	                     swapCMSCols: CKEDITOR.TRISTATE_OFF
	                 };
	             }
	         });
	   };
	   
   	   // Main functionality
   	    editor.addCommand("addCMSGridRow", {
	     	exec: function(editor) {
		    	var $elem = editor.getSelection().getStartElement().$.offsetParent;
		    	if ($elem != null) {
				    var $thisrow = $($elem).closest(".row");
					var $nextrow = $thisrow.clone();
					$nextrow.insertAfter($thisrow).find("div[class^='col-']").empty().html("<p><br></p>");
		    	};
	     	}  
         });
         
         editor.addCommand("deleteCMSGridRow", {
	     	exec: function(editor) {
		 		var $elem = editor.getSelection().getStartElement().$.offsetParent;
		 		if ($elem != null) {
			 		$($elem).closest(".row").remove();
			 		$(editor.document.$).find(".row").each(function(e) {
	                	if ($(this).find("div[class^='col-']").length == 0) $(this).remove();
                	});
			 	};
	     	}  
         }); 
         
         editor.addCommand("expandCMSColRight", {
	     	exec: function(editor) {
		    	var $elem = editor.getSelection().getStartElement().$.offsetParent;
		    	if ($elem != null) {
			    	//console.log($elem)
				    var $thisrow = $($elem).closest(".row");
				    if ($thisrow.find("div[class^='col-']").length == 2) { // Only two column layouts
					    if ($thisrow.find(".col-md-10:nth-child(1)").length) {
						    $thisrow.find(".col-md-10").removeClass("col-md-10").addClass("col-md-9");
							$thisrow.find(".col-md-2").removeClass("col-md-2").addClass("col-md-3");
							return;
						};
						if ($thisrow.find(".col-md-9:nth-child(1)").length) {
						    $thisrow.find(".col-md-9").removeClass("col-md-9").addClass("col-md-8");
							$thisrow.find(".col-md-3").removeClass("col-md-3").addClass("col-md-4");
							return;
						};
						 if ($thisrow.find(".col-md-8:nth-child(1)").length) {
						    $thisrow.find(".col-md-8").removeClass("col-md-8").addClass("col-md-7");
							$thisrow.find(".col-md-4").removeClass("col-md-4").addClass("col-md-5");
							return;
						};
						if ($thisrow.find(".col-md-7:nth-child(1)").length) {
						    $thisrow.find(".col-md-7").removeClass("col-md-7").addClass("col-md-6");
							$thisrow.find(".col-md-5").removeClass("col-md-5").addClass("col-md-6");
							return;
						};
						if ($thisrow.find(".col-md-6:nth-child(1)").length) {
						    $thisrow.find(".col-md-6:nth-child(1)").removeClass("col-md-6").addClass("col-md-5");
							$thisrow.find(".col-md-6:nth-child(2)").removeClass("col-md-6").addClass("col-md-7");
							return;
						};
						if ($thisrow.find(".col-md-5:nth-child(1)").length) {
						    $thisrow.find(".col-md-5").removeClass("col-md-5").addClass("col-md-4");
							$thisrow.find(".col-md-7").removeClass("col-md-7").addClass("col-md-8");
							return;
						};
						if ($thisrow.find(".col-md-4:nth-child(1)").length) {
						    $thisrow.find(".col-md-4").removeClass("col-md-4").addClass("col-md-3");
							$thisrow.find(".col-md-8").removeClass("col-md-8").addClass("col-md-9");
							return;
						};
						if ($thisrow.find(".col-md-3:nth-child(1)").length) {
						    $thisrow.find(".col-md-3").removeClass("col-md-3").addClass("col-md-2");
							$thisrow.find(".col-md-9").removeClass("col-md-9").addClass("col-md-10");
							return;
						};
				    };
				};
	     	}  
         });
         
         editor.addCommand("expandCMSColLeft", {
	     	exec: function(editor) {
		    	var $elem = editor.getSelection().getStartElement().$.offsetParent;
		    	if ($elem != null) {
			    	//console.log($elem)
				    var $thisrow = $($elem).closest(".row");
				    if ($thisrow.find("div[class^='col-']").length == 2) { // Only two column layouts
					    if ($thisrow.find(".col-md-2:nth-child(1)").length) {
						    $thisrow.find(".col-md-2").removeClass("col-md-2").addClass("col-md-3");
							$thisrow.find(".col-md-10").removeClass("col-md-10").addClass("col-md-9");
							return;
						};
						if ($thisrow.find(".col-md-3:nth-child(1)").length) {
						    $thisrow.find(".col-md-3").removeClass("col-md-3").addClass("col-md-4");
							$thisrow.find(".col-md-9").removeClass("col-md-9").addClass("col-md-8");
							return;
						};
						if ($thisrow.find(".col-md-4:nth-child(1)").length) {
						    $thisrow.find(".col-md-4").removeClass("col-md-4").addClass("col-md-5");
							$thisrow.find(".col-md-8").removeClass("col-md-8").addClass("col-md-7");
							return;
						};
						if ($thisrow.find(".col-md-5:nth-child(1)").length) {
						    $thisrow.find(".col-md-5").removeClass("col-md-5").addClass("col-md-6");
							$thisrow.find(".col-md-7").removeClass("col-md-7").addClass("col-md-6");
							return;
						};
						if ($thisrow.find(".col-md-6:nth-child(1)").length) {
						    $thisrow.find(".col-md-6:nth-child(1)").removeClass("col-md-6").addClass("col-md-7");
							$thisrow.find(".col-md-6:nth-child(2)").removeClass("col-md-6").addClass("col-md-5");
							return;
						};
						if ($thisrow.find(".col-md-7:nth-child(1)").length) {
						    $thisrow.find(".col-md-7").removeClass("col-md-7").addClass("col-md-8");
							$thisrow.find(".col-md-5").removeClass("col-md-5").addClass("col-md-4");
							return;
						};
						if ($thisrow.find(".col-md-8:nth-child(1)").length) {
						    $thisrow.find(".col-md-8").removeClass("col-md-8").addClass("col-md-9");
							$thisrow.find(".col-md-4").removeClass("col-md-4").addClass("col-md-3");
							return;
						};
						if ($thisrow.find(".col-md-9:nth-child(1)").length) {
						    $thisrow.find(".col-md-9").removeClass("col-md-9").addClass("col-md-10");
							$thisrow.find(".col-md-3").removeClass("col-md-3").addClass("col-md-2");
							return;
						};
					};
				};
	     	}  
         });
         
         editor.addCommand("swapCMSCols", {
	     	exec: function(editor) {
		    	var $elem = editor.getSelection().getStartElement().$.offsetParent;
		    	if ($elem != null) {
			    	//console.log($elem)
				    var $thisrow = $($elem).closest(".row");
				    if ($thisrow.find("div[class^='col-']").length == 2) { // Only two column layouts
					    var $first = $thisrow.find("div[class^='col-']:nth-child(1)");
					    var $second = $thisrow.find("div[class^='col-']:nth-child(2)");
					    var range = editor.getSelection().getRanges()[ 0 ];
						$first.insertAfter($second); 
						editor.focus(); // Focus the instance again
						range.select(); // Restore previous selection
					};
				};
	     	}  
         });
    }
});
