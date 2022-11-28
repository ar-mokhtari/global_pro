/**
 * @license Copyright (c) 2003-2017, CKSource - Frederico Knabben. All rights reserved.
 * For licensing, see LICENSE.md or http://ckeditor.com/license
 */

CKEDITOR.editorConfig = function( config ) {
	// Define changes to default configuration here. For example:
    config.uiColor = '#1E90FF';
    config.toolbarCanCollapse = true;
    config.font_names =
        'Arial/Arial, Helvetica, sans-serif;' +
        'serif;' +
        'Verdana;B mitra;B Nazanin;B Zar';


    config.font_names = 'Arial;Verdana;B mitra;B Nazanin;B Zar';

    config.toolbarGroups = [
        { name: 'clipboard',   groups: [ 'clipboard', 'undo','image'  ] },
        { name: 'editing',     groups: [ 'find', 'selection', 'spellchecker' ] },
        { name: 'links' },
        { name: 'document',	   groups: [ 'mode', 'document', 'doctools' ] },
        { name: 'others' },
        '/',
        { name: 'basicstyles', groups: [ 'basicstyles', 'cleanup' ] },
        { name: 'paragraph',   groups: [ 'list', 'indent', 'blocks', 'align', 'bidi'] },
        { name: 'styles' },
        { name: 'colors' },
        { name: 'insert' }
    ];
	config.language = 'fa';
    // config.height='500px';
    config.width='100%';
};
