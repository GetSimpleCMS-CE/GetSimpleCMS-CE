CKEDITOR.plugins.add('fontawesome5',{
icons:'fontawesome5',
init:function(editor){
	
	
	var path = '';
	var config = {
		'path':'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css', // 5.15.4 or 6.4.0
		//'path':this.path +'../../../fontawesome/fa6/css/all.min.css', // fa5 or fa6
		'version':'5.15.4', // 5.15.4 or 6.4.2
		'edition':'free',
		'element':'i'
	};
	if(editor.config.fontawesome && typeof editor.config.fontawesome ==='object'){
		$.extend( config, editor.config.fontawesome );
	}else if(editor.config.fontawesomePath){
		config.path = editor.config.fontawesomePath;
	}	
	editor.config.fontawesome = config;
	
	editor.addCommand('fontawesome5', new CKEDITOR.dialogCommand('ckeditorFaDialog',{allowedContent:'span(!fa-*)'}));
	editor.ui.addButton('fontawesome5',{label:'Font Awesome '+config.version.split('.')[0]+(config.edition=='pro'?' Pro':'')+' icons',command:'fontawesome5',toolbar:'insert',icon:this.path + 'icons/fontawesome5.png'});
	CKEDITOR.dialog.add('ckeditorFaDialog', this.path + 'dialogs/fontawesome5.js');
	CKEDITOR.document.appendStyleSheet(this.path + 'css/fontawesome5.css');

	
	if(config.path!=''){
		CKEDITOR.document.appendStyleSheet(config.path);
		editor.addContentsCss(config.path);
	}
	
	/****
		/* code for generating icons available in font awesome version.
		/* copy paste the json in de dialogs/fontawesome5.js 
		*/
		/*
		
		json = config.path.match(/.*\//)+'/metadata/icons.json';
			$.getJSON(json, function(json) {
				var icons  = {};
				for (var key in json){
					//console.log(key);
					var icon = json[key];
					icons[key] = {'label':icon['label'],'search':icon['search'].terms,'styles':icon['styles'],'changes':icon['changes'],'free':icon['free']};
				}
				let dataStr = JSON.stringify(icons).replace("'","\'");
												   
				let dataUri = 'data:application/json;charset=utf-8,'+ encodeURIComponent(dataStr);
				let exportFileDefaultName = 'data.json';

				let linkElement = document.createElement('a');
				linkElement.setAttribute('href', dataUri);
				linkElement.setAttribute('download', exportFileDefaultName);
				linkElement.click();
			});
			*/
			
			
}
});
