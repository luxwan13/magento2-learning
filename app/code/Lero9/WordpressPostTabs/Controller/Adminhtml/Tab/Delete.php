<?php
namespace Lero9\WordpressPostTabs\Controller\Adminhtml\Tab;

use Magento\Backend\App\Action;
use Magento\TestFramework\ErrorLog\Logger;

class Delete extends \Magento\Backend\App\Action
{

    /**
     * {@inheritdoc}
     */
    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed('Lero9_WordpressPostTabs::tab_delete');
    }

    /**
     * Delete action
     *
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        $id = $this->getRequest()->getParam('tab_id');
        /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
        $resultRedirect = $this->resultRedirectFactory->create();
        if ($id) {
            try {
                $model = $this->_objectManager->create('Lero9\WordpressPostTabs\Model\Tab');
                $model->load($id);
                $model->delete();
                $this->messageManager->addSuccess(__('The tab has been deleted.'));
                return $resultRedirect->setPath('*/*/');
            } catch (\Exception $e) {
                $this->messageManager->addError($e->getMessage());
                return $resultRedirect->setPath('*/*/edit', ['tab_id' => $id]);
            }
        }
        $this->messageManager->addError(__('We can\'t find a tab to delete.'));
        return $resultRedirect->setPath('*/*/');
    }
}