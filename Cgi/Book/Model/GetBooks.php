<?php
/**
 * Cgi Book Module
 *
 * @category   Cgi
 * @package    Cgi_Book
 * @version    1.0.0
 * @description get books
 *
 * Release with version 1.0.0
 *
 *
 */
namespace Cgi\Book\Model;


/**
 * @SuppressWarnings(PHPMD.LongVariable)
 * @SuppressWarnings(PHPMD.ExcessivePublicCount)
 * @SuppressWarnings(PHPMD.TooManyFields)
 * @SuppressWarnings(PHPMD.ExcessiveClassComplexity)
 * @SuppressWarnings(PHPMD.CouplingBetweenObjects)
 * @SuppressWarnings(PHPMD.UnusedFormalParameter)
 * @codingStandardsIgnoreFile
 */
class GetBooks extends \Magento\Framework\Model\AbstractModel
{
    /**
     * @var \Magento\Catalog\Model\Resource\Product\CollectionFactory
     */
    protected $productCollectionFactory;
    
    /**
     * @var \Magento\Eav\Model\Config
     */
    protected $eavConfig;
    
    protected $cgiHelper;
    
     /**
     * @var \Magento\Sales\Model\ResourceModel\Order\Collection
     */
    protected $booksCollection;

    /**
     * 
     * @param \Magento\Catalog\Model\ResourceModel\Product\CollectionFactory $productCollectionFactory
     * @param \Magento\Eav\Model\Config $eavConfig
     * @param \Cgi\Book\Helper\Data $cgiHelper
     */
    public function __construct(
        \Magento\Catalog\Model\ResourceModel\Product\CollectionFactory $productCollectionFactory,
        \Magento\Eav\Model\Config $eavConfig,
        \Cgi\Book\Helper\Data $cgiHelper
    ) {
        $this->productCollectionFactory = $productCollectionFactory;
        $this->eavConfig = $eavConfig;
        $this->cgiHelper = $cgiHelper;
    }

    /**
     * 
     * @param type $dataFilter
     * @param type $customerId
     * @return type
     */
    public function getProductCollection($dataFilter, $customerId)
    {
        $page = (array_key_exists('pageNumber', $dataFilter))? $dataFilter['pageNumber'] : 1;
        $pageSize = (array_key_exists('limit', $dataFilter))? $dataFilter['limit'] : 10;
        $bookTitle = (array_key_exists('bookTitle', $dataFilter))? trim($dataFilter['bookTitle']) : '';

        if (empty($this->booksCollection)) {
            $bookAttrSetId = $this->cgiHelper->getAttributeSetIdByName("Books With Isbn");
            $this->booksCollection = $this->productCollectionFactory->create()
                    ->addAttributeToSelect(["name", "sku", "isbn"])
                    ->addAttributeToFilter('attribute_set_id', $bookAttrSetId);
        }
        // @codingStandardsIgnoreStart

        if ($bookTitle !== "") {
            $this->booksCollection->addFieldToFilter('name', ['like' => '%'.$bookTitle.'%']);
        }

        $this->booksCollection->setPageSize($pageSize);
        $this->booksCollection->setCurPage($page);

        $this->booksCollection->setOrder('entity_id','DESC');
        // @codingStandardsIgnoreEnd
        return $this->booksCollection;
    }
    
}