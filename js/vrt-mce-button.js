( function() {
    tinymce.PluginManager.requireLangPack( 'vrtmce' );

    tinymce.create( 'tinymce.plugins.VrtMCE', {

        init : function( editor, url ) {
            editor.addButton('vrtbtn1', {
                title: 'VRT Style',
                cmd: 'vrtbtn1cmd'
            });

            editor.addCommand( 'vrtbtn1cmd1', function () {
                var selected_text = editor.selection.getContent();
                var return_text = '<span class="vrtclass">' + selected_text + '</span>';
                editor.execCommand('mceInsertContent', 0, return_text);
            });

            editor.addCommand('vrtbtn1cmd', function () {
                editor.windowManager.open({
                    title: editor.getLang( 'vrtmce.popup_title', 'VRT Options' ),
                    body: [
                        {
                            type: 'textbox',
                            name: 'content',
                            label: 'Text',
                            value: editor.selection.getContent(),
                        },
                        {
                            type: 'checkbox',
                            name: 'wantbold',
                            label: editor.getLang( 'vrtmce.want_bold', 'Bold' ),
                            tooltip: editor.getLang( 'vrtmce.want_bold_tooltip', 'Do you like BOLD, too?' )
                        }
                    ],
                    onsubmit: function (e) {
                        var ret_text = '[reverse';

                        if( e.data.wantbold )
                            ret_text += ' bold="true"';

                        ret_text += ']' + e.data.content + '[/reverse]';

                        //insert shortcode to TinyMCE
                        editor.execCommand('mceInsertContent', 0, ret_text);
                    }
                });
            });
        },

        getInfo : function() {
            return {
                longname : 'VRT Buttons',
                author : 'nida78',
                authorurl : 'http://www.vcat.de',
                infourl : 'http://www.vcat.de/edulabs/projekte/wordpress/reverse-text/',
                version : '0.0.2'
            };
        }
    });

    tinymce.PluginManager.add( 'vrtmce', tinymce.plugins.VrtMCE );
})();
