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

class AddBooksWithIsbnAttributeSet implements DataPatchInterface
{
    /** @var ModuleDataSetupInterface */
    private $moduleDataSetup;

    /** @var EavSetupFactory */
    private $eavSetupFactory;

    /** @var AttributeSetFactory */
    private $attributeSetFactory;

    /** @var CategorySetupFactory */
    private $categorySetupFactory;
    
    protected $cgiHelper;

    /**
     * @param ModuleDataSetupInterface $moduleDataSetup
     * @param EavSetupFactory $eavSetupFactory
     */
    public function __construct(
        ModuleDataSetupInterface $moduleDataSetup,
        EavSetupFactory $eavSetupFactory,
        AttributeSetFactory $attributeSetFactory,
        CategorySetupFactory $categorySetupFactory,
        \Cgi\Book\Helper\Data $cgiHelper
    ) {
        $this->moduleDataSetup = $moduleDataSetup;
        $this->eavSetupFactory = $eavSetupFactory;
        $this->attributeSetFactory = $attributeSetFactory;
        $this->categorySetupFactory = $categorySetupFactory;
        $this->cgiHelper = $cgiHelper;
    }

    /**
     * {@inheritdoc}
     */
    public function apply()
    {
        /** @var EavSetup $eavSetup */
        $this->moduleDataSetup->startSetup();
        $eavSetup = $this->eavSetupFactory->create(['setup' => $this->moduleDataSetup]);
        $attributeSet = $this->attributeSetFactory->create();
        $categorySetup = $this->categorySetupFactory->create(['setup' => $this->moduleDataSetup]);

        $entityTypeId = $categorySetup->getEntityTypeId(\Magento\Catalog\Model\Product::ENTITY);
        $defaultAttrSetId = $categorySetup->getDefaultAttributeSetId($entityTypeId);

        $attributeSetName = "Books With Isbn";

        /** Add New attribute */
        $data = [
            'attribute_set_name' => $attributeSetName,
            'entity_type_id' => $entityTypeId,
            'sort_order' => 60,
        ];

        $attributeSet->setEntityTypeId($entityTypeId)->load($attributeSetName, 'attribute_set_name');

        if (!$attributeSet->getId()) {
            $attributeSet->setData($data);
            $attributeSet->validate();
            $attributeSet->save();
        }
        $attributeSet->initFromSkeleton($defaultAttrSetId)->save();
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
