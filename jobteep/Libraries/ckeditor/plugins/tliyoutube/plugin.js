/**
 * @license Modifica e usa come vuoi
 *
 * Creato da TurboLab.it - 01/01/2014 (buon anno!)
 */
CKEDITOR.plugins.add( 'tliyoutube', {
    icons: 'tliyoutube',
    init: function( editor ) {
        editor.addCommand( 'tliyoutubeDialog', new CKEDITOR.dialogCommand( 'tliyoutubeDialog' ) );
        editor.ui.addButton( 'tliyoutube', {
            label: 'Inserisci filmato YouTube',
            command: 'tliyoutubeDialog',
            toolbar: 'paragraph'
        });

        CKEDITOR.dialog.add( 'tliyoutubeDialog', this.path + 'dialogs/tliyoutube.js' );
        if(a.labelLayout=='vertical')new CKEDITOR.ui.dialog.vbox(b,e,d,h);else new CKEDITOR.ui.dialog.hbox(b,e,d,h);
    }
});