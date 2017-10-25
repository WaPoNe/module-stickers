<?php
/**
 * WaPoNe
 *
 * @category   WaPoNe
 * @package    WaPoNe_Stickers
 * @copyright  Copyright (c) 2017 WaPoNe (http://www.fantetti.net)
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

namespace WaPoNe\Stickers\Model;

class Stickers extends \Magento\Framework\Model\AbstractModel
{
    const DISCOUNT_CATEGORY = "stickers/stickers_page/discount_category";
    const DISCOUNT_FIRST_LABEL = "stickers/stickers_page/discount_first_label";
    const DISCOUNT_SECOND_LABEL = "stickers/stickers_page/discount_second_label";
    const DISCOUNT_STICKER_TYPE = "stickers/stickers_page/discount_sticker_type";
    const DISCOUNT_CALCULATION_TYPE = "stickers/stickers_page/discount_calculation";

    const DISCOUNT_MANUAL = 'manual';
    const DISCOUNT_AUTOMATIC = 'automatic';

    const STICKER_CUSTOM = 'custom';

    const STICKER_IMAGE = 1;
    const STICKER_AREA = 2;
    const STICKER_CALCULATED = 3;

    protected $_productFactory;
    protected $_scopeConfig;

    private $_regularPrice;
    private $_finalPrice;
    protected $_product;

    public function __construct(
        \Magento\Framework\Model\Context $context,
        \Magento\Framework\Registry $registry,
        \Magento\Catalog\Model\ProductFactory $productFactory,
        \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig
    ) {
        parent::__construct($context, $registry);

        $this->_productFactory = $productFactory;
        $this->_scopeConfig = $scopeConfig;
    }

    public function setProduct($product)
    {
        $this->_product = $product;
    }

    public function isInCategory($stickerType)
    {
        $categories = $this->_scopeConfig->getValue($stickerType, \Magento\Store\Model\ScopeInterface::SCOPE_STORE);
        if($categories && $categories != '') {
            $latestCats = explode(",", $categories);
            $cats = $this->_product->getCategoryIds();
            foreach ($latestCats as $latestCat) {
                if (in_array($latestCat, $cats))
                    return true;
            }
        }

        return false;
    }

    public function isDiscounted($prodId)
    {
        $product = $this->_productFactory->create();
        $product->load($prodId);
        $this->_finalPrice = $product->getFinalPrice();
        $this->_regularPrice = $product->getData('price');
        return $this->_regularPrice != $this->_finalPrice;
    }

    public function getDiscountAmount()
    {
        return $this->_getDiscountPercentage($this->_finalPrice, $this->_regularPrice);
    }

    private function _getDiscountPercentage($finalPrice = 0, $regularPrice = 0)
    {
        $percentage = number_format($finalPrice / $regularPrice * 100, 2);
        $discountPercentage = round(100 - $percentage);

        return __("Up to")."<br />".$discountPercentage."%";
    }

    public function isStickerActive($stickerType)
    {
        $activation = $this->_scopeConfig->getValue($stickerType, \Magento\Store\Model\ScopeInterface::SCOPE_STORE);

        if($activation && $activation==1) {
            return true;
        }

        return false;
    }

    // Get label from extension configuration
    public function getConfigValue($configKey)
    {
        return $this->_scopeConfig->getValue($configKey, \Magento\Store\Model\ScopeInterface::SCOPE_STORE);
    }

    protected function _setDiscountStickerHTML()
    {
        $class = "categoryPageDiscount";

        // Manual
        if($this->getConfigValue(self::DISCOUNT_CALCULATION_TYPE) == self::DISCOUNT_MANUAL) {
            // Product in discounted categories
            if ($this->isInCategory(self::DISCOUNT_CATEGORY)) {
                // Custom sticker
                if ($this->getConfigValue(self::DISCOUNT_STICKER_TYPE) == self::STICKER_CUSTOM) {
                    $html = $this->_getHTML(self::STICKER_AREA, $class, self::DISCOUNT_FIRST_LABEL, self::DISCOUNT_SECOND_LABEL);
                }
                // Image sticker
                else {
                    $html = $this->_getHTML(self::STICKER_IMAGE, $class);
                }

                return $html;
            }

        }
        // Automatic
        else if($this->getConfigValue(self::DISCOUNT_CALCULATION_TYPE) == self::DISCOUNT_AUTOMATIC) {
            // Product discounted
            if ($this->isDiscounted($this->_product->getData('entity_id'))) {
                return $this->_getHTML(self::STICKER_CALCULATED, $class);
            }
        }
    }

    protected function _getHTML($stickerLayoutType, $class, $firstLabel = '', $secondLabel = '') {
        switch ($stickerLayoutType) {
            case self::STICKER_IMAGE:
                $html = "<input type='hidden' class='".$class."' value='1' />";
                break;
            case self::STICKER_AREA:
                $html = "<input type='hidden' class='".$class."' value='" . $this->getConfigValue($firstLabel) . "<br />" . $this->getConfigValue($secondLabel) . "' />";
                break;
            case self::STICKER_CALCULATED:
                $html = "<input type='hidden' class='".$class."' value='" . $this->getDiscountAmount() . "' />";
                break;
            default:
                $html = "<input type='hidden' class='".$class."' value='1' />";
                break;
        }

        return $html;
    }
}