<?php
/**
 * WaPoNe
 *
 * @category   WaPoNe
 * @package    WaPoNe_Stickers
 * @copyright  Copyright (c) 2017 WaPoNe (http://www.fantetti.net)
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

namespace WaPoNe\Stickers\Plugin;

class ProductStickersPlugin extends \WaPoNe\Stickers\Model\Stickers
{
    const DISCOUNT_ACTIVATION = "stickers/stickers_page/discount_activation";

    protected $_productFactory;
    protected $_scopeConfig;

    public function __construct(
        \Magento\Catalog\Model\ProductFactory $productFactory,
        \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig
    ) {
        $this->_productFactory = $productFactory;
        $this->_scopeConfig = $scopeConfig;
    }

    public function beforeGetProductPrice(
        \Magento\Catalog\Block\Product\AbstractProduct $abstractProduct,
        \Magento\Catalog\Model\Product $product
    ) {
        $this->_product = $product;
    }

    public function afterGetProductPrice(\Magento\Catalog\Block\Product\AbstractProduct $product, $result)
    {
        if($this->isStickerActive(self::DISCOUNT_ACTIVATION)) {
            $result .= $this->_setDiscountStickerHTML();
        }

        return $result;
    }
}