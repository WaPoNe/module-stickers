<?php
/**
 * WaPoNe
 *
 * @category   WaPoNe
 * @package    WaPoNe_Stickers
 * @copyright  Copyright (c) 2017 WaPoNe (http://www.fantetti.net)
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

namespace WaPoNe\Stickers\Plugin\Catalog\NewWidget;

class StickersPlugin extends \WaPoNe\Stickers\Model\Stickers
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

    public function beforeGetProductPriceHtml(
        \Magento\Catalog\Block\Product\Widget\NewWidget $list,
        \Magento\Catalog\Model\Product $product,
        $priceType = null,
        $renderZone = \Magento\Framework\Pricing\Render::ZONE_ITEM_LIST,
        array $arguments = []
    ) {
        $this->_product = $product;
    }

    public function afterGetProductPriceHtml(
        \Magento\Catalog\Block\Product\Widget\NewWidget $list, $result
    ) {
        if($this->isStickerActive(self::DISCOUNT_ACTIVATION)) {
            $result .= $this->_setDiscountStickerHTML();
        }

        return $result;
    }

}
