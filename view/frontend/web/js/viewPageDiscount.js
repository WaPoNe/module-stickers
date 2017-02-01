define(
    [
        'jquery'
    ],
    function ($) {
        $.widget(
            'wapone.viewPageDiscount',
            {
                _create: function () {
                    var self = this;
                    $(".product.media").append(self.options.imageTag.imagePath);
                }
            }
        );
        return $.wapone.viewPageDiscount;
    }
);