<?php
/**
 * Cgi Book Module
 *
 * @category   Cgi
 * @package    Cgi_Book
 * @version    1.0.0
 * @description get customer name even id page cache is enabled
 *
 * Release with version 1.0.0
 *
 *
 */

namespace Cgi\Book\Plugin;

class CustomerSessionContext
{
    /**
     * @var \Magento\Customer\Model\Session
     */
    protected $customerSession;

    /**
 	* @var \Magento\Framework\App\Http\Context
 	*/
    protected $httpContext;

    /**
     * @param \Magento\Customer\Model\Session $customerSession
     * @param \Magento\Framework\App\Http\Context $httpContext
     */
    public function __construct(
    	\Magento\Customer\Model\Session $customerSession,
    	\Magento\Framework\App\Http\Context $httpContext
    ) 
    {
    	$this->customerSession = $customerSession;
    	$this->httpContext = $httpContext;
    }

    /**
     * @param \Magento\Framework\App\ActionInterface $subject
     * @param callable $proceed
     * @param \Magento\Framework\App\RequestInterface $request
     * @return mixed
     */
    public function aroundDispatch(
    	\Magento\Framework\App\ActionInterface $subject,
    	\Closure $proceed,
    	\Magento\Framework\App\RequestInterface $request
    )
    {
    	$this->httpContext->setValue(
        	'customer_id',
        	$this->customerSession->getCustomerId(),
        	false
    	);

    	$this->httpContext->setValue(
        	'customer_name',
        	$this->customerSession->getCustomer()->getName(),
        	false
    	);

        return $proceed($request);
    }
}