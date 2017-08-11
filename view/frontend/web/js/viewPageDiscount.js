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