/**
 * Script for plugin_jquotes
 *
 * Fetches a new quotation
 *
 * @author Andreas Gohr <andi@splitbrain.org>
 */

jQuery(function () {
    jQuery('figure.plugin_jquotes').each(function () {
        var $self = jQuery(this);
        if(!$self.data('time')) return;
        if(!$self.data('cookie')) return;

        window.setInterval(function () {
            jQuery.post(
                DOKU_BASE + 'lib/exe/ajax.php',
                {
                    call: 'plugin_jquotes',
                    cookie: $self.data('cookie')
                },
                function (data) {
					$full = data.split('|');
					$quote = $full[0];
					$cite = $full[1];
					$self.on('click', copy_quote),
					$self.children('blockquote').children('p').html($quote),
					$self.children('figcaption').html($cite)
                }
            )
        }, $self.data('time') * 1000);
    });
});
function copy_quote() {
        jQuery('figure.plugin_jquotes').fadeOut(50).fadeIn(50);
        var $quote = jQuery('figure.plugin_jquotes > blockquote > p').text();
        var $author = jQuery('figure.plugin_jquotes > blockquote > figcaption').text();
        var $full = $quote + '\n\u2014' + $author;
        var $txt = jQuery( '<textarea />' );
        $txt.val($full).css({ width: "1px", height: "1px" }).appendTo('body');
        $txt.select();
        document.execCommand('copy');
        $txt.remove();
};
