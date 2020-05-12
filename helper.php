<?php
/**
 * Display quotations
 *
 * @license    GPL 2 (http://www.gnu.org/licenses/gpl.html)
 * @author     Andreas Gohr <andi@splitbrain.org>
 * @author     Trailjeep <trailjeep@gmail.com>
 */

class helper_plugin_jquotes extends DokuWiki_Plugin {

    /**
     * Get a random cookie properly escaped
     *
     * @param string $cookieID the media file id to the cookie file
     * @param int $maxlines
     * @return string
     */
    static public function getCookieHTML($cookieID) {
        $cookie = self::getCookie($cookieID);

        return nl2br(hsc($cookie));
    }

    /**
     * Get a file for the given ID
     *
     * If the ID ends with a colon a namespace is assumed and a random txt file is picked from there
     *
     * @param $cookieID
     * @return string
     * @throws Exception
     */
    static public function id2file($cookieID) {
        $file = mediaFN($cookieID);
        if(auth_quickaclcheck($cookieID) < AUTH_READ) throw new Exception("No read permissions for $cookieID");
        // we now should have a valid file
        if(!file_exists($file)) throw new Exception("No quotes file at $cookieID");

        return $file;
    }

    /**
     * Returns one quotation
     *
     * @param string $cookieID the media file id to the cookie file
     * @return string
     */
    static public function getCookie($cookieID) {
        try {
            $file = self::id2file($cookieID);
        } catch(Exception $e) {
            return 'ERROR: '.$e->getMessage();
        }

		$jsonFile = file_get_contents($file);
		//json must already be UTF8
		$jsonArray = json_decode($jsonFile, true);
		if (json_last_error() !== 0) return 'JSON error: '.json_last_error_msg();
		//$i = mt_rand(0, count($jsonArray['quotes']) -1);
		$i = array_rand($jsonArray['quotes']);
		$quote = $jsonArray['quotes'][$i]['quote'];
		$cite = $jsonArray['quotes'][$i]['author'];
        $text = $quote.'|'.$cite;

        return $text;
    }

}
