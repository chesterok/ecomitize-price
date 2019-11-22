<?php

namespace Ecomitize\Price\Observer;

use Magento\Framework\Event\ObserverInterface;
use Magento\Framework\Event\Observer;

class FinalPrice implements ObserverInterface
{
    /**
     * @var \Ecomitize\Groupcat\Helper\Data
     */
    private $helper;

    /**
     * @var array
     */
    private $finalPrice = [];

    /**
     * Restrict constructor.
     *
     * @param \Ecomitize\Groupcat\Helper\Data $helper
     */
    public function __construct(\Ecomitize\Groupcat\Helper\Data $helper) {
        $this->helper       = $helper;
    }

    /**
     * {@inheritdoc}
     */
    public function execute(Observer $observer)
    {
        $product = $observer->getEvent()->getProduct();
        $qty = $observer->getEvent()->getQty();

        if ($this->helper->isBranchesOrGreyhoundGroup()) {
            if ( isset($this->finalPrice[$product->getId()]) && $this->finalPrice[$product->getId()] == $product->getId() ) {
                return $this;
            } else {
                $this->finalPrice[$product->getId()] = $product->getId();
                if ( is_null($qty) ) {
                    $qty = 1;
                }
                $finalPrice = min($product->getTierPrice($qty), $product->getPrice());
                $this->finalPrice[$product->getId()] = $finalPrice;

                $product->setFinalPrice($finalPrice);
            }
        }

        return $this;
    }
}
