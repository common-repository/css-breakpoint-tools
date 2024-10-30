'use strict';
(function($){
    $(function(){

        $( ".code_editor_wp" ).each(function() {

            if( $(this).length ) {
                var editorSettings = wp.codeEditor.defaultSettings ? _.clone( wp.codeEditor.defaultSettings ) : {};
                editorSettings.codemirror = _.extend(
                    {},
                    editorSettings.codemirror,
                    {
                        indentUnit: 2,
                        tabSize: 2,
                        mode: 'css',
                    }
                );
                var editor = wp.codeEditor.initialize( $(this), editorSettings );
            }

        });

    });
})(jQuery);