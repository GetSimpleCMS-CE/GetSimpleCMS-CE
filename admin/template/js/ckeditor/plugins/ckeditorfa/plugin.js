CKEDITOR.plugins.add('ckeditorfa',{
icons:'ckeditorfa',
init:function(editor){
editor.addCommand('ckeditorfa', new CKEDITOR.dialogCommand('ckeditorFaDialog',{allowedContent:'span(!fa-*)'}));
editor.ui.addButton('ckeditorfa',{label:'FontAwesome6 icons',command:'ckeditorfa',toolbar:'insert',icon:this.path + 'icons/ckeditorfa.png'});
CKEDITOR.dialog.add('ckeditorFaDialog', this.path + 'dialogs/ckeditorfa.js');
CKEDITOR.document.appendStyleSheet(this.path + 'css/ckeditorfa.css');
}
});