<?php
namespace Users\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Users\Form\RegisterForm;
use Users\Model\UserTable;
use Users\Model\User;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway\TableGateway;

class RegisterController extends AbstractActionController
{

    public function indexAction()
    {
        $form = new RegisterForm();
        $viewModel = new ViewModel(array(
            'form' => $form
        ));
        return $viewModel;
    }

    public function confirmAction()
    {
        $viewModel = new ViewModel();
        return $viewModel;
    }
   
    public function processAction()
    {
        if (! $this->request->isPost()) {
            return $this->redirect()->toRoute(NULL, array(
                'controller' => 'register',
                'action' => 'index'
            ));
        }
        $post = $this->request->getPost();
        $form = new RegisterForm();
        
        $form->setData($post);
        if (! $form->isValid()) {
            $model = new ViewModel(array(
                'error' => true,
                'form' => $form
            ));
            $model->setTemplate('users/register/index');
            return $model;
        } 
       $this->createUser($form->getData());
        
        return $this->redirect()->toRoute(NULL, array(
            'controller' => 'register',
            'action' => 'confirm'
        ));
      
    }
    protected function createUser(array $data)
    {
    	$sm = $this->getServiceLocator();
    	$dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
    	    	
    	$resultSetPrototype = new ResultSet();
    	$resultSetPrototype->setArrayObjectPrototype(new User());
  	
    	$tableGateway = new TableGateway('user', $dbAdapter, null, $resultSetPrototype);
    	
    	$user = new User();
    	$user->exchangeArray($data);
    	
    	$userTable = new UserTable($tableGateway);
    	$userTable->saveUser($user);
    
    	return true;
    }
  
}