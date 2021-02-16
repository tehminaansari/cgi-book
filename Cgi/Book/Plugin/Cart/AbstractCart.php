<?php
/**
 * Cgi Book Module
 *
 * @category   Cgi
 * @package    Cgi_Book
 * @version    1.0.0
 * @description Override cart/item/default.phtml file
 *
 * Release with version 1.0.0
 *
 *
 */

namespace Cgi\Book\Plugin\Cart;

class AbstractCart
{
    /*
    *   Override cart/item/default.phtml file
    *   \Magento\Checkout\Block\Cart\AbstractCart $subject
    *   $result
    */
    public function afterGetItemRenderer(\Magento\Checkout\Block\Cart\AbstractCart $subject, $result)
    {
        $result->setTemplate('Cgi_Book::cart/item/default.phtml');
        return $result;
    }
}