<?php

namespace Ecomitize\Price\Plugin;

class SpecialPrice
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
     * @param \Magento\Catalog\Model\Product $subject
     * @param callable                                  $proceed
     *
     * @return float
     */
    public function aroundGetSpecialPrice(\Magento\Catalog\Model\Product $subject, callable $proceed)
    {
        if ($this->helper->isBranchesOrGreyhoundGroup()) {
            return null;
        }

        return $proceed();
    }
}