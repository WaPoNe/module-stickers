<?php
/**
 * WaPoNe
 *
 * @category   WaPoNe
 * @package    WaPoNe_Stickers
 * @copyright  Copyright (c) 2017 WaPoNe (http://www.fantetti.net)
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

namespace WaPoNe\Stickers\Block;

class Discount extends \Magento\Framework\View\Element\Template
{
    const DISCOUNT_ACTIVATION = "stickers/stickers_page/discount_activation";
    const DISCOUNT_CATEGORY = "stickers/stickers_page/discount_category";
    const DISCOUNT_IMAGE = "stickers/stickers_page/discount_image";
    const DISCOUNT_FIRST_LABEL = "stickers/stickers_page/discount_first_label";
    const DISCOUNT_SECOND_LABEL = "stickers/stickers_page/discount_second_label";
    const DISCOUNT_STICKER_BACKGROUND = "stickers/stickers_page/discount_sticker_background";
    const DISCOUNT_STICKER_TEXT = "stickers/stickers_page/discount_sticker_text";
    const DISCOUNT_STICKER_TYPE = "stickers/stickers_page/discount_sticker_type";
    const DISCOUNT_CALCULATION_TYPE = "stickers/stickers_page/discount_calculation";

    const DISCOUNT_MANUAL = 'manual';
    const DISCOUNT_AUTOMATIC = 'automatic';

    const DISCOUNT_STICKER_CUSTOM = 'custom';

    const DISCOUNT_HTML_IMAGE = 1;
    const DISCOUNT_HTML_AREA = 2;
    const DISCOUNT_HTML_CALCULATED = 3;

    protected $_product = null;

    protected $_coreRegistry;
    protected $_productFactory;
    protected $_stickers;

    /**
     * @param \Magento\Framework\View\Element\Template\Context $context
     * @param \Magento\Framework\Registry $registry
     * @param \Magento\Catalog\Model\ProductFactory $productFactory
     * @param \WaPoNe\Stickers\Model\StickersFactory $stickersFactory
     * @param array $data
     */
    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        \Magento\Framework\Registry $registry,
        \Magento\Catalog\Model\ProductFactory $productFactory,
        \WaPoNe\Stickers\Model\StickersFactory $stickersFactory,
        array $data = []
    ) {
        $this->_coreRegistry = $registry;
        $this->_productFactory = $productFactory;
        $this->_stickers = $stickersFactory->create();
        parent::__construct($context, $data);
    }

    /**
     * @return Product
     */
    protected function _getProduct()
    {
        if (!$this->_product) {
            $this->_product = $this->_coreRegistry->registry('product');
        }

        return $this->_product;
    }

    public function isDiscountActive()
    {
        return $this->_stickers->isStickerActive(self::DISCOUNT_ACTIVATION);
    }

    public function setDiscountStickerHTML()
    {
        // Saving product
        $this->_stickers->setProduct($this->_getProduct());

        // Manual
        if($this->_stickers->getConfigValue(self::DISCOUNT_CALCULATION_TYPE) == self::DISCOUNT_MANUAL) {
            // Product in discounted categories
            if($this->_stickers->isInCategory(self::DISCOUNT_CATEGORY)) {
                // Custom sticker
                if ($this->_stickers->getConfigValue(self::DISCOUNT_STICKER_TYPE) == self::DISCOUNT_STICKER_CUSTOM) {
                    $html = $this->_getHTML(self::DISCOUNT_HTML_AREA);
                }
                // Image sticker
                else {
                    $html = $this->_getHTML(self::DISCOUNT_HTML_IMAGE);
                }

                return $html;
            }
        }
        // Automatic
        else if($this->_stickers->getConfigValue(self::DISCOUNT_CALCULATION_TYPE) == self::DISCOUNT_AUTOMATIC) {
            // Product discounted
            if($this->_stickers->isDiscounted($this->_getProduct()->getData('entity_id'))) {
                return $this->_getHTML(self::DISCOUNT_HTML_CALCULATED);
            }
        }
    }

    private function _getHTML($stickerLayoutType)
    {
        switch ($stickerLayoutType) {
            case self::DISCOUNT_HTML_IMAGE:
                $html = "<div class='wapone-sticker-wrapper top-right'>";
                $html .= "<img class='productDiscountImage' src='".$this->getUrl('pub/media')."wapone/stickers/images/".$this->getStickerImage()."' />";
                $html .= "</div>";
                break;
            case self::DISCOUNT_HTML_AREA:
                $html = "<div class='wapone-sticker-wrapper top-right'>";
                $html .= "<div class='wapone-sticker discount-product' style='background-color: #".$this->getStickerBackground()."; color: #".$this->getStickerText().";'>";
                $html .= $this->_stickers->getConfigValue(self::DISCOUNT_FIRST_LABEL) . "<br />" . $this->_stickers->getConfigValue(self::DISCOUNT_SECOND_LABEL);
                $html .= "</div>";
                $html .= "</div>";
                break;
            case self::DISCOUNT_HTML_CALCULATED:
                $html = "<div class='wapone-sticker-wrapper top-right'>";
                $html .= "<div class='wapone-sticker discount-product automatic' style='background-color: #".$this->getStickerBackground()."; color: #".$this->getStickerText().";'>";
                $html .= $this->_stickers->getDiscountAmount();
                $html .= "</div>";
                $html .= "</div>";
                break;
            default:
                $html = "<div class='wapone-sticker-wrapper top-right'>";
                $html .= "<img class='productDiscountImage' src='".$this->getUrl('pub/media')."wapone/stickers/images/".$this->getStickerImage()."' />";
                $html .= "</div>";
                break;
        }

        return $html;
    }

    public function isAutomaticMode()
    {
        if($this->_stickers->getConfigValue(self::DISCOUNT_CALCULATION_TYPE) == self::DISCOUNT_AUTOMATIC)
            return true;
        else
            return false;
    }

    public function getStickerBackground()
    {
        return $this->_stickers->getConfigValue(self::DISCOUNT_STICKER_BACKGROUND);
    }

    public function getStickerText()
    {
        return $this->_stickers->getConfigValue(self::DISCOUNT_STICKER_TEXT);
    }

    public function getStickerImage()
    {
        return $this->_stickers->getConfigValue(self::DISCOUNT_IMAGE);
    }
}