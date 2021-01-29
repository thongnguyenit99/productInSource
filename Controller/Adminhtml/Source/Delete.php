<?php

namespace Team1\ProductSource\Controller\Adminhtml\Source;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\View\Result\Page;
use Magento\Framework\View\Result\PageFactory;
use Magento\InventoryApi\Api\SourceItemsDeleteInterface;
use Magento\InventoryApi\Api\Data\SourceItemInterfaceFactory;
use Magento\Framework\Controller\ResultFactory; 

/**
 * Class Index
 */
class Delete extends Action
{
    /**
     * Page result factory
     *
     * @var PageFactory
     */
    protected $resultPageFactory;
    protected $_sourceItemsDeleteInterface;
    protected $_sourceItemFactory;
    protected $_urlInterface;
    protected $redirect;
    protected $resultFactory;

    /**
     * Index constructor.
     *
     * @param Context $context
     * @param PageFactory $resultPageFactory
     */
    public function __construct(
        Context $context,
        PageFactory $resultPageFactory,
        SourceItemsDeleteInterface $sourceItemsDeleteInterface,
        SourceItemInterfaceFactory $sourceItemFactory,
        \Magento\Framework\UrlInterface $urlInterface,
        \Magento\Framework\App\Response\RedirectInterface $redirect,
        ResultFactory $resultFactory
    ) {
        $this->resultPageFactory = $resultPageFactory;
        $this->_sourceItemsDeleteInterface = $sourceItemsDeleteInterface;
        $this->_sourceItemFactory = $sourceItemFactory;
        $this->_urlInterface = $urlInterface;
        $this->redirect = $redirect;
        $this->resultFactory = $resultFactory;

        parent::__construct($context);
    }

    /**
     * execute the action
     *
     * @return \Magento\Backend\Model\View\Result\Page|Page
     */
    public function execute()
    {
        $sku = $this->getRequest()->getParam('sku');
        $redirectUrl = $this->redirect->getRedirectUrl();
        $pattern = "/inventory\/source\/edit\/source_code\/[a-zA-Z0-9_.-]*\//";
        preg_match($pattern, $redirectUrl, $matchStr); 
        $patternRemove = "/inventory\/source\/edit\/source_code\//";
        $sourceCode = preg_replace($patternRemove, "", $matchStr[0]);
        $sourceCode = preg_replace("/\//", "", $sourceCode);
        $sourceItem = $this->_sourceItemFactory->create();
        $sourceItem->setSourceCode($sourceCode);
        $sourceItem->setSku($sku);

        $this->_sourceItemsDeleteInterface->execute([$sourceItem]);
        $resultRedirect = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);
        $resultRedirect->setUrl($redirectUrl);
        return $resultRedirect;
    }
}
