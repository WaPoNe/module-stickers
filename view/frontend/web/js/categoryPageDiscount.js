/**
 * WaPoNe
 *
 * @category   WaPoNe
 * @package    WaPoNe_Stickers
 * @copyright  Copyright (c) 2017 WaPoNe (http://www.fantetti.net)
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

define(
    [
        'jquery'
    ],
    function ($) {
        $.widget(
            'wapone.categoryPageStickers',
            {
                _create: function () {
                    var self = this;
                    $(".categoryPageDiscount").each(function () {
                        if ($(this).val() == 1) {
                            $($(this).parent().parent().find("a").find("span").find("span"))
                                .prepend(self.options.imageTag.discountImage);
                            // Only for Ultimo theme
                            $($(this).parent().parent().find("div.product-item-img").find("a.product-image"))
                                .prepend(self.options.imageTag.discountImage);
                        } else {
                            var discountAmount = $(this).val();
                            $($(this).parent().parent().find("a").find("span").find("span"))
                                .prepend(self.options.imageTag.discountArea);
                            // Only for Ultimo theme
                            $($(this).parent().parent().find("div.product-item-img").find("a.product-image"))
                                .prepend(self.options.imageTag.discountArea);

                            $(".discount-product").html(discountAmount);
                        }
                    });
                }
            }
        );
        return $.wapone.categoryPageStickers;
    }
);