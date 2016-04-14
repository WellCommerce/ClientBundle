<?php
/*
 * WellCommerce Open-Source E-Commerce Platform
 * 
 * This file is part of the WellCommerce package.
 *
 * (c) Adam Piotrowski <adam@wellcommerce.org>
 * 
 * For the full copyright and license information,
 * please view the LICENSE file that was distributed with this source code.
 */

namespace WellCommerce\Bundle\ClientBundle\Visitor;

use WellCommerce\Bundle\ClientBundle\Entity\ClientInterface;
use WellCommerce\Bundle\CoreBundle\DependencyInjection\AbstractContainerAware;
use WellCommerce\Bundle\OrderBundle\Entity\OrderInterface;
use WellCommerce\Bundle\OrderBundle\Entity\OrderTotal;
use WellCommerce\Bundle\OrderBundle\Factory\OrderTotalDetailFactory;
use WellCommerce\Bundle\OrderBundle\Visitor\OrderVisitorInterface;

/**
 * Class OrderClientDiscountVisitor
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class OrderClientDiscountVisitor extends AbstractContainerAware implements OrderVisitorInterface
{
    const PRIORITY = 300;
    
    /**
     * {@inheritdoc}
     */
    public function visitOrder(OrderInterface $order)
    {
        if (null === $order->getCoupon()) {
            $orderTotal = new OrderTotal();
            $discount   = $this->getDiscountForClient($order->getClient());
            
            if ($discount > 0) {
                $productTotal = $order->getProductTotal();
                
                $orderTotal->setCurrency($order->getCurrency());
                $orderTotal->setGrossAmount($productTotal->getGrossAmount() * $discount);
                $orderTotal->setNetAmount($productTotal->getNetAmount() * $discount);
                $orderTotal->setTaxAmount($productTotal->getTaxAmount() * $discount);
                
                $orderTotalDetail = $this->initResource();
                $orderTotalDetail->setOrderTotal($orderTotal);
                $orderTotalDetail->setModifierType('%');
                $orderTotalDetail->setModifierValue($discount);
                $orderTotalDetail->setOrder($order);
                $orderTotalDetail->setSubtraction(true);
                
                $order->addTotal($orderTotalDetail);
            }
        }
    }
    
    /**
     * Returns client's discount
     *
     * @param null|ClientInterface $client
     *
     * @return float|int
     */
    protected function getDiscountForClient(ClientInterface $client = null)
    {
        if (null !== $client && null !== $client->getClientGroup()) {
            return round((float)$client->getClientGroup()->getDiscount() / 100, 2);
        }
        
        return 0;
    }
    
    /**
     * {@inheritdoc}
     */
    public function getAlias() : string
    {
        return 'client_discount';
    }
    
    /**
     * {@inheritdoc}
     */
    public function getDescription() : string
    {
        return $this->getTranslatorHelper()->trans('order.label.client_discount_description');
    }
    
    /**
     * {@inheritdoc}
     */
    public function getPriority() : int
    {
        return self::PRIORITY;
    }
}
