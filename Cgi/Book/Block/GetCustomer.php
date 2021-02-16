<?php
/**
 * Cgi Book Module
 *
 * @category   Cgi
 * @package    Cgi_Book
 * @version    1.0.0
 * @description Render customer name in header
 *
 * Release with version 1.0.0
 *
 *
 */
namespace Cgi\Book\Block;
use Magento\Framework\App\ObjectManager;

class GetCustomer extends \Magento\Framework\View\Element\Html\Link
{
    protected $cgiBlock;

    
    /**
     * Render block HTML.
     *
     * @return string
     */
    protected function _toHtml()
    {
        if (false != $this->getTemplate()) {
            return parent::_toHtml();
        }
        
        $this->cgiBlock = ObjectManager::getInstance()->get(\Cgi\Book\Block\Book\Index::class);    
        $customerName =  '<li>Welcome to Cgimizon, Guest User</li>';
        if ($this->cgiBlock->getCustomerIsLoggedIn()) {
            $customerName =  '<li> Welcome to Cgimizon, '.$this->cgiBlock->getCustomerName().'</li>';
        }
        
        return $customerName;
    }
}