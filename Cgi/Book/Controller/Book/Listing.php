<?php

/**
 * Cgi Book Module
 *
 * @category   Cgi
 * @package    Cgi_Book
 * @version    1.0.0
 * @description action for listing books
 *
 * Release with version 1.0.0
 *
 *
 */

namespace Cgi\Book\Controller\Book;

use \Magento\Customer\Model\Session;

class Listing extends \Magento\Framework\App\Action\Action
{

    // @codingStandardsIgnoreStart
    /**
     *
     * @var \Magento\Framework\Controller\Result\JsonFactory
     */
    protected $resultJsonFactory;

    /**
     *
     * @var \Magento\Framework\DataObject
     */
    protected $dataObject;

    protected $model;
    // @codingStandardsIgnoreEnd

    /**
     * 
     * @param \Magento\Framework\App\Action\Context $context
     * @param \Magento\Framework\Controller\Result\JsonFactory $resultJsonFactory
     * @param \Magento\Framework\DataObject $dataObject
     * @param \Cgi\Book\Model\GetBooks $model
     * @param Session $customerSession
     */
    public function __construct(
        \Magento\Framework\App\Action\Context $context,
        \Magento\Framework\Controller\Result\JsonFactory $resultJsonFactory,
        \Magento\Framework\DataObject $dataObject,
        \Cgi\Book\Model\GetBooks $model,
        Session $customerSession
    ) {
        $this->resultJsonFactory = $resultJsonFactory;
        $this->dataObject = $dataObject;
        $this->customerSession = $customerSession;
        $this->model = $model;
        parent::__construct($context);
    }

    /**
     * 
     * @return type
     * Render book listing using datatable
     */
    public function execute()
    {   
        $this->setdataObject($this->getRequest()->getParams());
        $result = $this->resultJsonFactory->create();

        $products = $this->model->getProductCollection(
            [
                'p' => $this->dataObject->start,
                'limit' => $this->dataObject->length,
                'bookTitle' => $this->dataObject->bookTitle,
                'pageNumber' => ($this->dataObject->pageNumber + 1)
            ],
            $this->customerSession->getCustomer()->getId()
        );

        $output = [
            "sEcho" => $this->dataObject->sEcho,
            "iTotalRecords" => $products->getSize(),
            "iTotalDisplayRecords" => $products->getSize(),
            "aaData" => []
        ];
        
        if ($products->getSize() > 0) {
            $count = 0;
            foreach ($products as $record) {
                // @codingStandardsIgnoreStart
                $count++;
                $record->setCount($count);
                $row =  $this->_view->getLayout()->createBlock(\Cgi\Book\Block\Book\Index::class)->setData('row', $record)->setTemplate('Cgi_Book::book/listing/getdata.phtml')
                        ->toHtml();
                $rowdata = [];
                $rowdata['cour_name'] = $row;
                $output['aaData'][] = $rowdata;
                // @codingStandardsIgnoreEnd
            }
        }
        $result->setData($output);
        return $result;
    }
    
    /**
     *
     * @param type $requestParams
     */
    private function setDataObject($requestParams)
    {
        $this->dataObject->start = $requestParams['iDisplayStart'];
        $this->dataObject->length = $requestParams['iDisplayLength'];
        $this->dataObject->sEcho = $requestParams['sEcho'];
        $this->dataObject->search = $requestParams['sSearch'];
        $this->dataObject->pageNumber = $requestParams['pageNumber'];
        $this->dataObject->bookTitle = (array_key_exists('bookTitle', $requestParams))? $requestParams['bookTitle'] : '';
    }
}
