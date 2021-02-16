<?php
/**
 * Cgi Book Module
 *
 * @category   Cgi
 * @package    Cgi_Book
 * @version    1.0.0
 * @description listing of books
 *
 * Release with version 1.0.0
 *
 *
 */

namespace Cgi\Book\Controller\Book;

class Index extends \Magento\Framework\App\Action\Action
{
    // @codingStandardsIgnoreStart
    /**
     * Page result factory
     * @var \Magento\Framework\View\Result\PageFactory
     */
    protected $resultPageFactory;

    /**
     * Customer Session
     * @var \Magento\Customer\Model\Session
     */
    protected $customerSession;

    /**
     * @var \Magento\Framework\Message\ManagerInterface $messageManager
     */
    protected $messageManager;

    /**
     * @var type \Magento\Sales\Model\Order
     */
    protected $orderModel;

    /**
     * @var type \Magento\Framework\View\Result\JsonFactory
     */
    protected $resultJsonFactory;
    
    protected $getBookModel;


    /**
     * 
     * @param \Magento\Framework\App\Action\Context $context
     * @param \Magento\Framework\View\Result\PageFactory $resultPageFactory
     * @param \Magento\Framework\Message\ManagerInterface $messageManager
     * @param \Magento\Framework\Controller\Result\JsonFactory $resultJsonFactory
     * @param \Cgi\Book\Model\GetBooks $getBookModel
     */
    public function __construct(
        \Magento\Framework\App\Action\Context $context,
        \Magento\Framework\View\Result\PageFactory $resultPageFactory,
        \Magento\Framework\Message\ManagerInterface $messageManager,
        \Magento\Framework\Controller\Result\JsonFactory $resultJsonFactory,
        \Cgi\Book\Model\GetBooks $getBookModel
    ) {
        $this->resultPageFactory = $resultPageFactory;
        $this->messageManager = $messageManager;
        $this->resultJsonFactory = $resultJsonFactory;
        $this->getBookModel = $getBookModel;
        parent::__construct($context);
    }

     /**
     * 
     * @return type
     */
    public function execute()
    {
        $this->_view->loadLayout();
        $this->_view->renderLayout();
    }
}
