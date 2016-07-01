<?php
namespace Collecting\Controller\Admin;

use Collecting\Form\CollectingForm;
use Omeka\Form\ConfirmForm;
use Omeka\Mvc\Exception;
use Zend\View\Model\ViewModel;
use Zend\Mvc\Controller\AbstractActionController;

class IndexController extends AbstractActionController
{
    public function adminAction()
    {
        $site = $this->currentSite();

        $view = new ViewModel;
        $view->setVariable('site', $site);
        return $view;
    }

    public function indexAction()
    {
        $site = $this->currentSite();
        $collectingForms = $this->api()
            ->search('collecting_forms', ['site_id' => $site->id()])->getContent();

        $view = new ViewModel;
        $view->setVariable('site', $site);
        $view->setVariable('collectingForms', $collectingForms);
        return $view;
    }

    public function addAction()
    {
        return $this->handleAddEdit();
    }

    public function editAction()
    {
        return $this->handleAddEdit();
    }

    protected function handleAddEdit()
    {
        $site = $this->currentSite();
        $form = $this->getForm(CollectingForm::class);

        $view = new ViewModel;
        $view->setTemplate('collecting/admin/index/form');
        $view->setVariable('site', $site);
        $view->setVariable('form', $form);
        $view->setVariable('isEdit', false);

        if ('edit' === $this->params('action')) {
            $collectingForm = $this->api()
                ->read('collecting_forms', $this->params('id'))->getContent();
            $form->setData($collectingForm->jsonSerialize());
            $view->setVariable('collectingForm', $collectingForm);
            $view->setVariable('isEdit', true);
        }

        if ($this->getRequest()->isPost()) {
            $data = $this->params()->fromPost();
            $form->setData($data);
            if ($form->isValid()) {
                var_dump($data);exit;
            } else {
                $this->messenger()->addError('There was an error during validation');
            }
        }

        return $view;
    }

    public function deleteConfirmAction()
    {
        $site = $this->currentSite();
        $collectingForm = $this->api()
            ->read('collecting_forms', $this->params('id'))->getContent();

        $view = new ViewModel;
        $view->setTerminal(true);
        $view->setTemplate('common/delete-confirm-details');
        $view->setVariable('resourceLabel', 'collecting form');
        $view->setVariable('resource', $collectingForm);
        return $view;
    }

    public function deleteAction()
    {
        if ($this->getRequest()->isPost()) {
            $form = $this->getForm(ConfirmForm::class);
            $form->setData($this->getRequest()->getPost());
            if ($form->isValid()) {
                $response = $this->api()->delete('collecting_forms', $this->params('id'));
                if ($response->isError()) {
                    $this->messenger()->addError('Form could not be deleted');
                } else {
                    $this->messenger()->addSuccess('Form successfully deleted');
                }
            } else {
                $this->messenger()->addError('Form could not be deleted');
            }
        }
        return $this->redirect()->toRoute(
            'admin/site/slug/collecting/default',
            ['action' => 'index'],
            true
        );
    }
}

