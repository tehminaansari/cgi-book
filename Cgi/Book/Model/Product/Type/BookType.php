<?php
/**
 * Cgi Book Module
 *
 * @category   Cgi
 * @package    Cgi_Book
 * @version    1.0.0
 * @description model for book product type
 *
 * Release with version 1.0.0
 *
 *
 */
namespace Cgi\Book\Model\Product\Type;


/**
 * @SuppressWarnings(PHPMD.LongVariable)
 * @SuppressWarnings(PHPMD.ExcessivePublicCount)
 * @SuppressWarnings(PHPMD.TooManyFields)
 * @SuppressWarnings(PHPMD.ExcessiveClassComplexity)
 * @SuppressWarnings(PHPMD.CouplingBetweenObjects)
 * @SuppressWarnings(PHPMD.UnusedFormalParameter)
 * @codingStandardsIgnoreFile
 */
class BookType extends \Magento\Catalog\Model\Product\Type\AbstractType
{
    const TYPE_CODE = 'book_type';
    
    /**
     * 
     * @param type $product
     * @return $this
     */
    public function save($product)
    {
        parent::save($product);
        return $this;
    }
    
    /**
     * 
     * @param \Magento\Catalog\Model\Product $product
     * @return $this
     */
    public function deleteTypeSpecificData(\Magento\Catalog\Model\Product $product)
    {
        return $this;
    } 
    
}