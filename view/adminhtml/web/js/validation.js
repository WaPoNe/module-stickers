/**
 * WaPoNe
 *
 * @category   WaPoNe
 * @package    WaPoNe_Stickers
 * @copyright  Copyright (c) 2017 WaPoNe (http://www.fantetti.net)
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

require(
    ['jquery'],
    function($) {
        $(function() {
            $( document ).ready(function() {
                setStickerType('discount', $("input[name='groups[stickers_page][fields][discount_sticker_type][value]']:checked").val());
                setStickerType($("input[name='groups[stickers_page][fields][discount_calculation][value]']:checked").val(), $("input[name='groups[stickers_page][fields][discount_sticker_type][value]']:checked").val());
            });
            // Automatic/Manual Area
            $("input[name='groups[stickers_page][fields][discount_calculation][value]']").on("click", function() {
                setStickerType($("input[name='groups[stickers_page][fields][discount_calculation][value]']:checked").val(), $("input[name='groups[stickers_page][fields][discount_sticker_type][value]']:checked").val());
            });
            // Discount Area
            $("input[name='groups[stickers_page][fields][discount_sticker_type][value]']").on("click", function() {
                setStickerType('discount', $("input[name='groups[stickers_page][fields][discount_sticker_type][value]']:checked").val());
            });
        });
    });
function setStickerType(labelType, stickerType) {
    // Automatic Area
    if(labelType == 'automatic') {
        jQuery("#stickers_stickers_page_discount_first_label").prop('disabled', true);
        jQuery("#stickers_stickers_page_discount_second_label").prop('disabled', true);
        jQuery("#stickers_stickers_page_discount_sticker_background").prop('disabled', false);
        jQuery("#stickers_stickers_page_discount_sticker_text").prop('disabled', false);
        jQuery("#stickers_stickers_page_discount_image").prop('disabled', true);
        jQuery("#stickers_stickers_page_discount_category").prop('disabled', true);
        jQuery("input[name='groups[stickers_page][fields][discount_sticker_type][value]']").prop('disabled', true);
        jQuery("#stickers_stickers_page_discount_sticker_typecustom").prop('checked', true);
    }
    // Manual Area
    if(labelType == 'manual') {
        if (stickerType == 'image') {
            jQuery("#stickers_stickers_page_discount_category").prop('disabled', false);
            jQuery("input[name='groups[stickers_page][fields][discount_sticker_type][value]']").prop('disabled', false);
            jQuery("#stickers_stickers_page_discount_first_label").prop('disabled', true);
            jQuery("#stickers_stickers_page_discount_second_label").prop('disabled', true);
            jQuery("#stickers_stickers_page_discount_sticker_background").prop('disabled', true);
            jQuery("#stickers_stickers_page_discount_sticker_text").prop('disabled', true);
            jQuery("#stickers_stickers_page_discount_image").prop('disabled', false);
        } else if (stickerType == 'custom') {
            jQuery("#stickers_stickers_page_discount_category").prop('disabled', false);
            jQuery("input[name='groups[stickers_page][fields][discount_sticker_type][value]']").prop('disabled', false);
            jQuery("#stickers_stickers_page_discount_first_label").prop('disabled', false);
            jQuery("#stickers_stickers_page_discount_second_label").prop('disabled', false);
            jQuery("#stickers_stickers_page_discount_sticker_background").prop('disabled', false);
            jQuery("#stickers_stickers_page_discount_sticker_text").prop('disabled', false);
            jQuery("#stickers_stickers_page_discount_image").prop('disabled', true);
        }
    }
    // Discount Area
    if(labelType == 'discount') {
        if (stickerType == 'image') {
            jQuery("#stickers_stickers_page_discount_first_label").prop('disabled', true);
            jQuery("#stickers_stickers_page_discount_second_label").prop('disabled', true);
            jQuery("#stickers_stickers_page_discount_sticker_background").prop('disabled', true);
            jQuery("#stickers_stickers_page_discount_sticker_text").prop('disabled', true);
            jQuery("#stickers_stickers_page_discount_image").prop('disabled', false);
        } else if (stickerType == 'custom') {
            jQuery("#stickers_stickers_page_discount_first_label").prop('disabled', false);
            jQuery("#stickers_stickers_page_discount_second_label").prop('disabled', false);
            jQuery("#stickers_stickers_page_discount_sticker_background").prop('disabled', false);
            jQuery("#stickers_stickers_page_discount_sticker_text").prop('disabled', false);
            jQuery("#stickers_stickers_page_discount_image").prop('disabled', true);
        }
    }
}