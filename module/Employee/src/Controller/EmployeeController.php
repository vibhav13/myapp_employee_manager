<?php  
namespace Employee\Controller; 
use Zend\Mvc\Controller\AbstractActionController; 
use Zend\View\Model\ViewModel; 
use Employee\Model\Employee;       
use Employee\Model\EmployeeTable;    
use Employee\Form\EmployeeForm;

class EmployeeController extends AbstractActionController { 
   private $table;  
   public function __construct(EmployeeTable $table) { 
      $this->table = $table; 
   }  
   public function indexAction() { 
      $view = new ViewModel([ 
         'data' => $this->table->fetchAll(), 
      ]);  
      return $view; 
   }
   public function addAction() { 
   $form = new EmployeeForm();  
   $form->get('submit')->setValue('Add');  
   $request = $this->getRequest(); 
   
   if ($request->isPost()) { 
      $employee = new Employee(); 
      $form->setInputFilter($employee->getInputFilter()); 
      $form->setData($request->getPost());  
      
      if ($form->isValid()) { 
         $employee->exchangeArray($form->getData()); 
         $this->table->saveEmployee($employee);  
         
         // Redirect to list of employees 
         return $this->redirect()->toRoute('employee'); 
      } 
   } 
   return array('form' => $form); 
   }
   public function editAction() { 
	   $id = (int) $this->params()->fromRoute('id', 0); 
	   if (!$id) { 
	      return $this->redirect()->toRoute('employee', array( 
	         'action' => 'add' 
	      )); 
	   }  
	   try { 
	      $employee = $this->table->getEmployee($id); 
	   } catch (\Exception $ex) { 
	      return $this->redirect()->toRoute('employee', array( 
	         'action' => 'index' 
	      )); 
	   }  
	   $form = new EmployeeForm(); 
	   $form->bind($employee); 
	   $form->get('submit')->setAttribute('value', 'Edit');  
	   $request = $this->getRequest(); 
	   
	   if ($request->isPost()) { 
	      $form->setInputFilter($employee->getInputFilter()); 
	      $form->setData($request->getPost());  
	      if ($form->isValid()) { 
	         $this->table->saveEmployee($employee);  
	         
	         // Redirect to list of employees 
	         return $this->redirect()->toRoute('employee'); 
	      } 
	   }  
	   return array('id' => $id, 'form' => $form,); 
	}
	public function deleteAction() { 
	   $id = (int) $this->params()->fromRoute('id', 0); 
	   if (!$id) { 
	      return $this->redirect()->toRoute('employee'); 
	   }  
	   $request = $this->getRequest(); 
	   if ($request->isPost()) { 
	      $del = $request->getPost('del', 'No');  
	      if ($del == 'Yes') { 
	         $id = (int) $request->getPost('id');
	         $this->table->deleteEmployee($id); 
	      } 
	      return $this->redirect()->toRoute('employee'); 
	   }  
	   return array( 
	      'id' => $id, 
	      'employee' => $this->table->getEmployee($id) 
	   ); 
	}              
} 