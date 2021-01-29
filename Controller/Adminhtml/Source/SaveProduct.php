<?php

namespace Team1\ProductSource\Controller\Adminhtml\Source;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\View\Result\Page;
use Magento\Framework\View\Result\PageFactory;
use Magento\InventoryApi\Api\SourceItemsSaveInterface;
use Magento\InventoryApi\Api\Data\SourceItemInterfaceFactory;

/**
 * Class Index
 */
class SaveProduct extends Action
{

    protected $resultPageFactory;
    protected $_sourceItemsSaveInterface;
    protected $_sourceItemFactory;


    /**
     * Index constructor.
     *
     * @param Context $context
     * @param PageFactory $resultPageFactory
     */
    public function __construct(
        Context $context,
        PageFactory $resultPageFactory,
        SourceItemsSaveInterface $sourceItemsSaveInterface,
        SourceItemInterfaceFactory $sourceItemFactory
    ) {
        $this->resultPageFactory = $resultPageFactory;
        $this->_sourceItemsSaveInterface = $sourceItemsSaveInterface;
        $this->_sourceItemFactory = $sourceItemFactory;

        parent::__construct($context);
    }

    /**
     * execute the action
     *
     * @return \Magento\Backend\Model\View\Result\Page|Page
     */
    public function execute()
    {
        // get data to file modal.js .Get 2 param
        $productData = $this->getRequest()->getParam('productdata');
        $sourceCode = $this->getRequest()->getParam('sourcecode');
        // loop values item in source .
        foreach ($productData as $product) {
            $sourceItem = $this->_sourceItemFactory->create();
            $sourceItem->setSourceCode($sourceCode);
            $sourceItem->setSku($product['sku']);
            $sourceItem->setQuantity(0);
            $sourceItem->setStatus(1);

            //pass the sourceItem as an array element, you can add more source items in the same call as further array elements
            $this->_sourceItemsSaveInterface->execute([$sourceItem]);
        }
    }
}