jQuery(document).ready(function(){
    jQuery(".wrc-share-site").on('click', function(e) {
        e.preventDefault();
        var wrc_site = jQuery(this).attr('data-site');
        var wrc_coupon = jQuery(this).parent().attr('data-coupon');
        var wrc_blog = jQuery(this).parent().attr('data-blog');
        var wrc_blog_url = jQuery(this).parent().attr('data-blog-url');
        if (!wrc_site) {
            wrc_site = encodeURI(window.location.href);
        }
        share_coupon(wrc_site, wrc_coupon, wrc_blog, wrc_blog_url);
    });

    function share_coupon(wrc_site, wrc_coupon, wrc_blog, wrc_blog_url) {
        if (wrc_site === 'twitter') {
            window.open('https://twitter.com/home?status=Im giving you a coupon at ' + wrc_blog + '! Use code '+ wrc_coupon +' at checkout. Visit: '+wrc_blog_url, 'newwindow', 'width=400,height=400');
        } else if (wrc_site === 'email') {
            window.location.href = "mailto:?subject=" + wrc_blog + " coupon!&body=Im giving you a coupon at " + wrc_blog + "! Use code "+ wrc_coupon +" at checkout. Visit: "+wrc_blog_url;
        } else if (wrc_site === 'whatsapp') {
            window.open('whatsapp://send?text=Im giving you a coupon at ' + wrc_blog + '! Use code '+ wrc_coupon +' at checkout. Visit: '+wrc_blog_url, 'newwindow', 'width=400,height=400');
        }else if (wrc_site === 'sms') {
            window.open('sms:&body=Im giving you a coupon at ' + wrc_blog + '! Use code '+ wrc_coupon +' at checkout. Visit: '+wrc_blog_url,  'newwindow', 'width=400,height=400');
        }
        return false;

    }
});