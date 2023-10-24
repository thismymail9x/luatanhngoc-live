/** Ch\u1ee9c n\u0103ng ch\u1ec9 b\u1eadt 1 audio c\u00f9ng 1 th\u1eddi \u0111i\u1ec3m -> audio n\u00e0y b\u1eadt th\u00ec t\u1eaft c\u00e1c audio kh\u00e1c* https://stackoverflow.com/questions/33594647/audio-event-does-not-trigger-jquery-on-play-event
 * https://jsbin.com/vucobezoxe/1/edit?html,js,output
 */jQuery.createEventCapturing = (function () {
    var special = jQuery.event.special;
    return function (names) {
        if (!document.addEventListener) {
            return;
        }
        if (typeof names == 'string') {
            names = [names];
        }
        jQuery.each(names, function (i, name) {
            var handler = function (e) {
                e = jQuery.event.fix(e);
                return jQuery.event.dispatch.call(this, e);
            };
            special[name] = special[name] || {};
            if (special[name].setup || special[name].teardown) {
                return;
            }
            jQuery.extend(special[name], {
                setup: function () {
                    this.addEventListener(name, handler, true);
                }, teardown: function () {
                    this.removeEventListener(name, handler, true);
                }
            });
        });
    };
})();
jQuery.createEventCapturing(['play']);
jQuery(function () {
    jQuery('body').on('play', 'audio, video', function (e) {
        jQuery('audio, video').not(this).each(function (index, a) {
            a.pause();
        });
    });
    // jQuery('body').append(jQuery('.container').clone());
});