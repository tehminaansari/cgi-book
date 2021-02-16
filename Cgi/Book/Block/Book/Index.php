<?php
/**
 * Cgi Book Module
 *
 * @category   Cgi
 * @package    Cgi_Book
 * @version    1.0.0
 * @description getter methods for pulling customer name
 *
 * Release with version 1.0.0
 *
 *
 */
namespace Cgi\Book\Block\Book;

class Index extends \Magento\Framework\View\Element\Template
{
    // @codingStandardsIgnoreStart
    
    protected $httpContext;
    
    // @codingStandardsIgnoreEnd

    /**
     * 
     * @param \Magento\Framework\View\Element\Template\Context $context
     * @param \Magento\Framework\App\Http\Context $httpContext
     * @param array $data
     */
    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        \Magento\Framework\App\Http\Context $httpContext,
        array $data = []
    ) {
        $this->httpContext = $httpContext;
        parent::__construct($context, $data);
    }

    /**
     * 
     * @return type
     * return if customer is logged in
     */
    public function getCustomerIsLoggedIn()
    {
    	return (bool)$this->httpContext->getValue(\Magento\Customer\Model\Context::CONTEXT_AUTH);
    }

    /**
     * 
     * @return type
     * return customer id
     */
    public function getCustomerId()
    {
    	return $this->httpContext->getValue('customer_id');
    }

    /**
     * 
     * @return type
     * return customer name
     */
    public function getCustomerName()
    {
    	return $this->httpContext->getValue('customer_name');
    }

}
