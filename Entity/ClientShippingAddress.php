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

namespace WellCommerce\Bundle\ClientBundle\Entity;

use WellCommerce\Bundle\CoreBundle\Entity\AddressTrait;

/**
 * Class ClientShippingAddress
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class ClientShippingAddress implements ClientShippingAddressInterface
{
    use AddressTrait;
    
    /**
     * @var string
     */
    private $firstName;
    
    /**
     * @var string
     */
    private $lastName;
    
    /**
     * @var bool
     */
    private $copyBillingAddress;
    /**
     * @var string
     */
    private $companyName;
    
    public function getFirstName() : string
    {
        return $this->firstName;
    }
    
    public function setFirstName(string $firstName)
    {
        $this->firstName = $firstName;
    }
    
    public function getLastName() : string
    {
        return $this->lastName;
    }
    
    public function setLastName(string $lastName)
    {
        $this->lastName = $lastName;
    }

    public function getCopyBillingAddress() : bool
    {
        return $this->copyBillingAddress;
    }

    public function setCopyBillingAddress(bool $copyBillingAddress)
    {
        $this->copyBillingAddress = $copyBillingAddress;
    }
    
    public function getCompanyName()
    {
        return $this->companyName;
    }
    
    public function setCompanyName(string $companyName)
    {
        $this->companyName = $companyName;
    }
}
