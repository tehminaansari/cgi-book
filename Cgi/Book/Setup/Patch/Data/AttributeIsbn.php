<?php
/**
 * Cgi Book Module
 *
 * @category   Cgi
 * @package    Cgi_Book
 * @version    1.0.0
 * @description create attribute and attribute set
 *
 * Release with version 1.0.0
 *
 *
 */

namespace Cgi\Book\Setup\Patch\Data;

use Magento\Catalog\Setup\CategorySetupFactory;
use Magento\Eav\Model\Entity\Attribute\SetFactory as AttributeSetFactory;
use Magento\Eav\Setup\EavSetupFactory;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Framework\Setup\Patch\DataPatchInterface;

class AttributeIsbn implements DataPatchInterface
{
    /** @var ModuleDataSetupInterface */
    private $moduleDataSetup;

    /** @var EavSetupFactory */
    private $eavSetupFactory;

    /** @var AttributeSetFactory */
    private $attributeSetFactory;
    
    protected $cgiHelper;

    /** @var CategorySetupFactory */
    private $categorySetupFactory;
    
    /**
     * @param ModuleDataSetupInterface $moduleDataSetup
     * @param EavSetupFactory $eavSetupFactory
     */
    public function __construct(
        ModuleDataSetupInterface $moduleDataSetup,
        EavSetupFactory $eavSetupFactory,
        AttributeSetFactory $attributeSetFactory,
        \Cgi\Book\Helper\Data $cgiHelper,
        CategorySetupFactory $categorySetupFactory
    ) {
        $this->moduleDataSetup = $moduleDataSetup;
        $this->eavSetupFactory = $eavSetupFactory;
        $this->attributeSetFactory = $attributeSetFactory;
        $this->cgiHelper = $cgiHelper;
        $this->categorySetupFactory = $categorySetupFactory;
    }

    /**
     * {@inheritdoc}
     */
    public function apply()
    {
        /** @var EavSetup $eavSetup */
        $this->moduleDataSetup->startSetup();
        $eavSetup = $this->eavSetupFactory->create(['setup' => $this->moduleDataSetup]);
        $categorySetup = $this->categorySetupFactory->create(['setup' => $this->moduleDataSetup]);
        $entityTypeId = $categorySetup->getEntityTypeId(\Magento\Catalog\Model\Product::ENTITY);
        
        /** @var EavSetup $eavSetup */
        $attributeCode = 'isbn';
        $eavSetup->addAttribute(\Magento\Catalog\Model\Product::ENTITY, $attributeCode, [
            'type' => 'varchar',
            'input' => 'text',
            'label' => 'ISBN',
            'global' => \Magento\Eav\Model\Entity\Attribute\ScopedAttributeInterface::SCOPE_GLOBAL,
            'source' => '',
            'required' => false,
            'user_defined' => true,  
            'is_html_allowed_on_front' => true,
            'visible_on_front' => true,
            'used_in_product_listing' => true,
            'used_for_sort_by' => false,
            'option' => []
        ]);
        $bookAttrSetId = $eavSetup->getAttributeSetId($entityTypeId, "Books With Isbn");
        $eavSetup->addAttributeToGroup($entityTypeId, $bookAttrSetId, 'General', $attributeCode, 259);
        
        
        $fieldList = [
            'price',
            'special_price',
            'special_from_date',
            'special_to_date',
            'minimal_price',
            'cost',
            'tier_price',
        ];

        // make these attributes applicable to book products
        foreach ($fieldList as $field) {
            $applyTo = explode(
                ',',
                $eavSetup->getAttribute(\Magento\Catalog\Model\Product::ENTITY, $field, 'apply_to')
            );
            if (!in_array('book_type', $applyTo)) {
                $applyTo[] = 'book_type';
                $eavSetup->updateAttribute(
                    \Magento\Catalog\Model\Product::ENTITY,
                    $field,
                    'apply_to',
                    implode(',', $applyTo)
                );
            }
        }
    }

    /**
     * {@inheritdoc}
     */
    public static function getDependencies()
    {
        return [];
    }

    /**
     * {@inheritdoc}
     */
    public function getAliases()
    {
        return [];
    }
}
