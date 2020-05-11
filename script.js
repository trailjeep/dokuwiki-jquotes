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
					$self.children('blockquote').children('p').html($quote),
					$self.children('figcaption').html($cite)
                }
            )
        }, $self.data('time') * 1000);
    });
});

