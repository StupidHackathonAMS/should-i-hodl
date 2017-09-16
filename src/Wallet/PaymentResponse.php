<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */

/**
 * Short File Description
 * 
 * PHP version 5
 * 
 * @category   aCategory
 * @package    aPackage
 * @subpackage aSubPackage
 * @author     anAuthor
 * @copyright  2014 a Copyright
 * @license    a License
 * @link       http://www.aLink.com
 */
namespace Blockchain\Wallet;

/**
 * Short Class Description
 * 
 * PHP version 5
 * 
 * @category   aCategory
 * @package    aPackage
 * @subpackage aSubPackage
 * @author     anAuthor
 * @copyright  2014 a Copyright
 * @license    a License
 * @link       http://www.aLink.com
 */
class PaymentResponse 
{
    /**
     * Properties
     */
    public $message;                    // string
    public $tx_hash;                    // string
    public $notice;                     // string

    /**
     * Methods
     */
    public function __construct($json) {
        if(array_key_exists('message', $json))
            $this->message = $json['message'];
        if(array_key_exists('tx_hash', $json))
            $this->tx_hash = $json['tx_hash'];
        if(array_key_exists('notice', $json))
            $this->notice = $json['notice'];
    }
}