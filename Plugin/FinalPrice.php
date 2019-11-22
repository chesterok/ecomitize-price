<?php

namespace Ecomitize\Price\Plugin;

class FinalPrice
{
    /**
     * @var \Ecomitize\Groupcat\Helper\Data
     */
    private $helper;

    /**
     * Restrict constructor.
     *
     * @param \Ecomitize\Groupcat\Helper\Data $helper
     */
    public function __construct(\Ecomitize\Groupcat\Helper\Data $helper) {
        $this->helper       = $helper;
    }

    /**
     * @param \Magento\Catalog\Model\Product\Type\Price $subject
     * @param callable                                  $proceed
     * @param int                                       $qty
     * @param \Magento\Catalog\Model\Product            $product
     *
     * @return float
     */
    public function aroundGetFinalPrice(\Magento\Catalog\Model\Product\Type\Price $subject, callable $proceed, $qty, $product)
    {
        $finalPrice = $proceed($qty, $product);

        if ($this->helper->isBranchesOrGreyhoundGroup()) {
            if ( is_null($qty) ) {
                $qty = 1;
            }
            $finalPrice = min($product->getTierPrice($qty), $product->getPrice());

            $product->setFinalPrice($finalPrice);
        }

        return $finalPrice;
    }
}