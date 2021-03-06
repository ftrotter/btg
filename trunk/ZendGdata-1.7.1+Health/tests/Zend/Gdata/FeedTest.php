<?php
/**
 * Zend Framework
 *
 * LICENSE
 *
 * This source file is subject to the new BSD license that is bundled
 * with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://framework.zend.com/license/new-bsd
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@zend.com so we can send you a copy immediately.
 *
 * @category     Zend
 * @package      Zend_Gdata
 * @subpackage   UnitTests
 * @copyright    Copyright (c) 2005-2008 Zend Technologies USA Inc. (http://www.zend.com);
 * @license    http://framework.zend.com/license/new-bsd     New BSD License
 */

require_once 'Zend/Gdata.php';
require_once 'Zend/Gdata/Feed.php';
require_once 'Zend/Gdata/App/Util.php';

/**
 * @package    Zend_Gdata
 * @subpackage UnitTests
 * @copyright  Copyright (c) 2005-2008 Zend Technologies USA Inc. (http://www.zend.com)
 * @license    http://framework.zend.com/license/new-bsd     New BSD License
 */
class Zend_Gdata_FeedTest extends PHPUnit_Framework_TestCase
{

    public function setUp() {
        $this->etagLocalName = 'etag';
        $this->expectedEtag = 'W/"CE4BRXw4cCp7ImA9WxRVFEs."';
        $this->expectedMismatchExceptionMessage = "ETag mismatch";
        $this->feed = new Zend_Gdata_Feed();
        $this->feedText = file_get_contents(
                'Zend/Gdata/_files/FeedSample1.xml',
                true);
        $this->gdNamespace = 'http://schemas.google.com/g/2005';
        $this->openSearchNamespacev1 = 'http://a9.com/-/spec/opensearchrss/1.0/';
        $this->openSearchNamespacev2 = 'http://a9.com/-/spec/opensearch/1.1/';
    }

    public function testXMLHasNoEtagsWhenUsingV1() {
        $etagData = 'Quux';
        $this->feed->setEtag($etagData);
        $domNode = $this->feed->getDOM(null, 1, null);
        $this->assertNull(
            $domNode->attributes->getNamedItemNS(
                $this->gdNamespace, $this->etagLocalName));
    }

    public function testXMLHasNoEtagsWhenUsingV1X() {
        $etagData = 'Quux';
        $this->feed->setEtag($etagData);
        $domNode = $this->feed->getDOM(null, 1, 1);
        $this->assertNull(
            $domNode->attributes->getNamedItemNS(
                $this->gdNamespace, $this->etagLocalName));
    }

    public function testXMLHasEtagsWhenUsingV2() {
        $etagData = 'Quux';
        $this->feed->setEtag($etagData);
        $domNode = $this->feed->getDOM(null, 2, null);
        $this->assertEquals(
            $etagData,
            $domNode->attributes->getNamedItemNS(
                $this->gdNamespace, $this->etagLocalName)->nodeValue);
    }

    public function testXMLHasEtagsWhenUsingV2X() {
        $etagData = 'Quux';
        $this->feed->setEtag($etagData);
        $domNode = $this->feed->getDOM(null, 2, 1);
        $this->assertEquals(
            $etagData,
            $domNode->attributes->getNamedItemNS(
                $this->gdNamespace, $this->etagLocalName)->nodeValue);
    }

    public function testXMLETagsPropagateToFeed() {
        $this->feed->transferFromXML($this->feedText);
        $etagValue = $this->feed->getEtag();
        $this->assertEquals($this->expectedEtag, $this->feed->getEtag());
    }

    public function testXMLandHTMLEtagsDifferingThrowsException() {
        $exceptionCaught = false;
        $this->feed->setEtag("Foo");
        try {
            $this->feed->transferFromXML($this->feedText);
        } catch (Zend_Gdata_App_IOException $e) {
            $exceptionCaught = true;
        }
        $this->assertTrue($exceptionCaught, "Exception Zend_Gdata_IO_Exception expected");
    }

    public function testHttpAndXmlEtagsDifferingThrowsExceptionWithMessage() {
        $messageCorrect = false;
        $this->feed->setEtag("Foo");
        try {
            $this->feed->transferFromXML($this->feedText);
        } catch (Zend_Gdata_App_IOException $e) {
            if ($e->getMessage() == $this->expectedMismatchExceptionMessage)
                $messageCorrect = true;
        }
        $this->assertTrue($messageCorrect, "Exception Zend_Gdata_IO_Exception message incorrect");
    }

    public function testNothingBadHappensWhenHttpAndXmlEtagsMatch() {
        $this->feed->setEtag($this->expectedEtag);
        $this->feed->transferFromXML($this->feedText);
        $this->assertEquals($this->expectedEtag, $this->feed->getEtag());
    }

    public function testLookUpOpenSearchv1Namespace() {
        $this->assertEquals($this->openSearchNamespacev1,
            $this->feed->lookupNamespace('openSearch', 1, 0));
        $this->assertEquals($this->openSearchNamespacev1,
            $this->feed->lookupNamespace('openSearch', 1, null));
    }

    public function testLookupOpenSearchv2Namespace() {
        $this->assertEquals($this->openSearchNamespacev2,
            $this->feed->lookupNamespace('openSearch', 2, 0));
        $this->assertEquals($this->openSearchNamespacev2,
            $this->feed->lookupNamespace('openSearch', 2, null));
    }
}
