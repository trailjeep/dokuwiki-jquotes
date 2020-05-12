<?php
/**
 * Display quotations
 *
 * @license    GPL 2 (http://www.gnu.org/licenses/gpl.html)
 * @author     Andreas Gohr <andi@splitbrain.org>
 * @author     Trailjeep <trailjeep@gmail.com>
 */

class action_plugin_jquotes extends DokuWiki_Action_Plugin {

    /** @inheritdoc */
    function register(Doku_Event_Handler $controller) {
        $controller->register_hook('AJAX_CALL_UNKNOWN', 'BEFORE', $this, 'handle_ajax_call_unknown');
    }

    /**
     * Handle the ajax call
     *
     * @param Doku_Event $event
     * @param $param
     */
    function handle_ajax_call_unknown(Doku_Event $event, $param) {
        if($event->data != 'plugin_jquotes') return;
        $event->preventDefault();
        $event->stopPropagation();
        global $INPUT;
        echo helper_plugin_jquotes::getCookieHTML($INPUT->str('cookie'));
    }

}
