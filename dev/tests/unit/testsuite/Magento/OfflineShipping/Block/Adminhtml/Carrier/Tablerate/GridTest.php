<?php
/**
 * Copyright © 2015 Magento. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Magento\OfflineShipping\Block\Adminhtml\Carrier\Tablerate;

class GridTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var \Magento\OfflineShipping\Block\Adminhtml\Carrier\Tablerate\Grid
     */
    protected $model;

    /**
     * @var \Magento\Framework\Store\StoreManagerInterface|\PHPUnit_Framework_MockObject_MockObject
     */
    protected $storeManagerMock;

    /**
     * @var \Magento\Backend\Helper\Data|\PHPUnit_Framework_MockObject_MockObject
     */
    protected $backendHelperMock;

    /**
     * @var \PHPUnit_Framework_MockObject_MockObject
     */
    protected $tablerateMock;

    /**
     * @var \PHPUnit_Framework_MockObject_MockObject
     */
    protected $context;

    /**
     * @var \PHPUnit_Framework_MockObject_MockObject
     */
    protected $collectionFactoryMock;

    protected function setUp()
    {
        $objectManager = new \Magento\TestFramework\Helper\ObjectManager($this);

        $this->storeManagerMock = $this->getMockBuilder('Magento\Framework\Store\StoreManagerInterface')
            ->disableOriginalConstructor()
            ->getMock();

        $this->context = $objectManager->getObject('Magento\Backend\Block\Template\Context', [
            'storeManager' => $this->storeManagerMock
        ]);

        $this->backendHelperMock = $this->getMockBuilder('\Magento\Backend\Helper\Data')
            ->disableOriginalConstructor()
            ->getMock();

        $this->collectionFactoryMock =
            $this->getMockBuilder('\Magento\OfflineShipping\Model\Resource\Carrier\Tablerate\CollectionFactory')
            ->disableOriginalConstructor()
            ->getMock();

        $this->tablerateMock = $this->getMockBuilder('Magento\OfflineShipping\Model\Carrier\Tablerate')
            ->disableOriginalConstructor()
            ->getMock();

        $this->model = new \Magento\OfflineShipping\Block\Adminhtml\Carrier\Tablerate\Grid(
            $this->context,
            $this->backendHelperMock,
            $this->collectionFactoryMock,
            $this->tablerateMock
        );
    }

    public function testSetWebsiteId()
    {
        $websiteId = 1;

        $websiteMock = $this->getMockBuilder('Magento\Store\Model\Website')
            ->setMethods(['getId'])
            ->disableOriginalConstructor()
            ->getMock();

        $this->storeManagerMock->expects($this->once())
            ->method('getWebsite')
            ->with($websiteId)
            ->willReturn($websiteMock);

        $websiteMock->expects($this->once())
            ->method('getId')
            ->willReturn($websiteId);

        $this->assertSame($this->model, $this->model->setWebsiteId($websiteId));
        $this->assertEquals($websiteId, $this->model->getWebsiteId());
    }

    public function testGetWebsiteId()
    {
        $websiteId = 10;

        $websiteMock = $this->getMockBuilder('Magento\Store\Model\Website')
            ->disableOriginalConstructor()
            ->setMethods(['getId'])
            ->getMock();

        $websiteMock->expects($this->once())
            ->method('getId')
            ->willReturn($websiteId);

        $this->storeManagerMock->expects($this->once())
            ->method('getWebsite')
            ->willReturn($websiteMock);

        $this->assertEquals($websiteId, $this->model->getWebsiteId());

        $this->storeManagerMock->expects($this->never())
            ->method('getWebsite')
            ->willReturn($websiteMock);

        $this->assertEquals($websiteId, $this->model->getWebsiteId());
    }

    public function testSetAndGetConditionName()
    {
        $conditionName = 'someName';
        $this->assertEquals($this->model, $this->model->setConditionName($conditionName));
        $this->assertEquals($conditionName, $this->model->getConditionName());
    }
}
