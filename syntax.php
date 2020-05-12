<?php
/**
 * Display quotations
 *
 * @license    GPL 2 (http://www.gnu.org/licenses/gpl.html)
 * @author     Andreas Gohr <andi@splitbrain.org>
 * @author     Trailjeep <trailjeep@gmil.com>
 */


class syntax_plugin_jquotes extends DokuWiki_Syntax_Plugin {

    /**
     * What kind of syntax are we?
     */
    function getType() {
        return 'substition';
    }

    /**
     * What about paragraphs?
     */
    function getPType() {
        return 'block';
    }

    /**
     * Where to sort in?
     */
    function getSort() {
        return 302;
    }

    /**
     * Connect pattern to lexer
     */
    function connectTo($mode) {
        $this->Lexer->addSpecialPattern('\{\{jquotes>[^}]*\}\}', $mode, 'plugin_jquotes');
    }

    /**
     * Handle the match
     */
    function handle($match, $state, $pos, Doku_Handler $handler) {
        $match = substr($match, 11, -2); //strip markup from start and end

        $data = array();

        //handle params
        list($cookie, $params) = explode('?', $match, 2);

        // quotes file
        $data['cookie'] = cleanID($cookie);

        //time interval for changing cookies
        $data['time'] = 30;
        if(preg_match('/\b(\d+)\b/i', $params, $match)) {
            $data['time'] = (int) $match[1];
        }

        //no hammering please!
        if($data['time'] < 5) $data['time'] = 5;

        return $data;
    }

    /**
     * Create output
     */
    function render($mode, Doku_Renderer $renderer, $data) {
        if($mode != 'xhtml') return false;

        $attr = array(
            'class' => 'plugin_jquotes',
            'data-time' => $data['time'],
            'data-cookie' => $data['cookie']
        );

        $full = explode('|', helper_plugin_jquotes::getCookieHTML($data['cookie']));
        $quote = $full[0];
        $cite = $full[1];

        $renderer->doc .= '<figure '.buildAttributes($attr).' onClick="copy_quote()">';
        $renderer->doc .= "<blockquote><p>$quote</p></blockquote>";
        $renderer->doc .= "<figcaption>$cite</figcaption>";
        $renderer->doc .= '</figure>';

        return true;
    }

}

//Setup VIM: ex: et ts=4 enc=utf-8 :
