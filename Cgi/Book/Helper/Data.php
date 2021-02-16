<?php
/**
 * Cgi Book Module
 *
 * @category   Cgi
 * @package    Cgi_Book
 * @version    1.0.0
 * @description helper function
 *
 * Release with version 1.0.0
 *
 *
 */

namespace Cgi\Book\Helper;

use Magento\Framework\App\Helper\AbstractHelper;

class Data extends AbstractHelper
{
    // @codingStandardsIgnoreStart
    /**
     * @var \Magento\Framework\App\Config\ScopeConfigInterface
     */
    protected $scopeConfig;
    
    /**
     * @var \Magento\Store\Model\StoreManagerInterface
     */
    protected $storeManager;
    
    /**
     * @var \Magento\Eav\Model\ResourceModel\Entity\Attribute\Set\Collection
     */
    protected $attributeSetCollection;

    // @codingStandardsIgnoreEnd
    
    /**
     * 
     * @param \Magento\Framework\App\Helper\Context $context
     * @param \Magento\Store\Model\StoreManagerInterface $storeManager
     * @param \Magento\Eav\Model\ResourceModel\Entity\Attribute\Set\CollectionFactory $attributeSetCollection
     */
    public function __construct(
        \Magento\Framework\App\Helper\Context $context,
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        \Magento\Eav\Model\ResourceModel\Entity\Attribute\Set\CollectionFactory $attributeSetCollection
    ) {
        $this->scopeConfig = $context->getScopeConfig();
        $this->storeManager = $storeManager;
        $this->attributeSetCollection = $attributeSetCollection;
        
        parent::__construct(
            $context
        );
    }
    
    /**
     * Return attribute set id by Name.
     * @param type $attributeSetName
     * @return int
     */
    public function getAttributeSetIdByName($attributeSetName)
    {
        $attributeId = $this->attributeSetCollection->create()
            ->addFieldToSelect('attribute_set_id')
            ->addFieldToFilter('attribute_set_name', $attributeSetName);
        foreach($attributeId as $attrId):
            $attributeSetId = $attrId->getAttributeSetId();
        endforeach;
        return $attributeSetId;
    }
    
}
