<?php
defined('_FRAMEWORK_') or exit('No direct script access allowed');
$identity = authPatOs()->getIdentity();
$adv = 'base';

// https://ckeditor.com/docs/ckeditor4/latest/features/toolbarconcepts.html CONFIGURAZIONE CKEDITOR


if (\System\Action::getInstance()->do_action('i_s_s_a', true)) {
    $adv = 'expert';
} else {

    // Forzatura sessione utente
    switch ($identity['editor_wishing']) {
        case 'base':
            $adv = 'base';
            break;
        case 'adv':
            $adv = 'adv';
            break;
        case 'expert':
            $adv = 'expert';
            break;
        default:
            $adv = false;
    }

    // Profilo ACL
    if (!$adv && !empty($identity['options']['editor_wishing'])) {
        switch ($identity['options']['editor_wishing']) {
            case 'base':
                $adv = 'base';
                break;
            case 'adv':
                $adv = 'adv';
                break;
            case 'expert':
                $adv = 'expert';
                break;
        }
    }
}
?>
/**
* @license Copyright (c) 2003-2022, CKSource Holding sp. z o.o. All rights reserved.
* For licensing, see https://ckeditor.com/legal/ckeditor-oss-license
*/
CKEDITOR.editorConfig = function (config) {
// Define changes to default configuration here. For example:
config.language = 'it';
config.uiColor = '#F4F4F4';

<?php if ($adv === 'expert'): /* Editor per esperti */ ?>
    config.toolbarGroups = [
    { name: 'document', groups: [ 'mode', 'document', 'doctools' ] },
    { name: 'clipboard', groups: [ 'clipboard', 'undo' ] },
    { name: 'editing', groups: [ 'find', 'selection', 'spellchecker', 'editing' ] },
    '/',
    { name: 'basicstyles', groups: [ 'basicstyles', 'cleanup' ] },
    { name: 'paragraph', groups: [ 'list', 'indent', 'blocks', 'align', 'bidi', 'paragraph' ] },
    { name: 'links', groups: [ 'links' ] },
    { name: 'insert', groups: [ 'insert' ] },
    '/',
    { name: 'styles', groups: [ 'styles' ] },
    { name: 'colors', groups: [ 'colors' ] },
    { name: 'tools', groups: [ 'tools' ] },
    { name: 'others', groups: [ 'others' ] }
    ];
<?php elseif ($adv === 'adv'): /* Editor Avanzato */ ?>
    config.toolbar = [
    { name: 'document', items: ['Preview'] },
    { name: 'clipboard', items: [ 'Cut', 'Copy', 'PasteText', '-', 'Undo', 'Redo' ] },
    { name: 'editing', groups: [ 'find', 'selection', 'spellchecker', 'editing' ], items: [ 'Scayt' ] },
    { name: 'links', items: [ 'Link', 'Unlink', 'Anchor' ] },
    { name: 'insert', items: [ 'Image', 'Table', 'HorizontalRule', 'SpecialChar','Iframe','PageBreak' ] },
    { name: 'tools', items: [ 'Maximize' ] },
    '/',
    { name: 'basicstyles', items: [ 'Bold', 'Italic', 'Strike', '-', 'RemoveFormat' ] },
    { name: 'paragraph', items: [ 'NumberedList', 'BulletedList', '-', 'Outdent', 'Indent', '-', 'Blockquote' ] },
    { name: 'styles', items: [ 'Styles', 'Format' ] }
    ];
<?php else: ?>
    config.toolbar = [
    { name: 'document', items: ['Preview'] },
    { name: 'clipboard', items: [ 'Cut', 'Copy', 'PasteText', '-', 'Undo', 'Redo','Maximize' ] },
    { name: 'basicstyles', items: [ 'Bold', 'Italic', 'Strike', '-', 'RemoveFormat' ] },
    { name: 'paragraph', items: [ 'NumberedList', 'BulletedList'] },
    { name: 'links', items: [ 'Link', 'Unlink', 'Anchor' ] },
    { name: 'editing', groups: [ 'find', 'selection', 'spellchecker', 'editing' ], items: [ 'Scayt' ] }
    ];
<?php endif; ?>

<?php \System\Action::getInstance()->do_action('p_d_i_m_e_c_k_e') ?>

// Simplify the dialog windows.
config.removeDialogTabs = 'image:advanced;link:advanced';
config.filebrowserBrowseUrl = '/admin/file-archive?f=1';
config.filebrowserUploadUrl = '/admin/sys/filemanager';
config.imageUploadUrl = '/admin/sys/filemanager';
config.height = 260;
config.width = '100%';

config.removeButtons = 'Save,NewPage,PasteFromWord,SelectAll,CopyFormatting,BidiLtr,BidiRtl,Language,Smiley';
var disablePlugins = [
'exportpdf',
'copyformatting',
'pastefromdocs',
'pastefromlibreoffice',
'scayt',
'wsc'
].join(',');
config.removePlugins = disablePlugins;
};