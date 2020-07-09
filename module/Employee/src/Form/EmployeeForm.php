<?php  
namespace Employee\Form; 
use Zend\Form\Form;  

class EmployeeForm extends Form { 
   public function __construct($name = null) { 
      parent::__construct('employee');  
      $this->add(array( 
         'name' => 'id', 
         'type' => 'Hidden', 
      )); 
      $this->add(array( 
         'name' => 'emp_name', 
         'type' => 'Text', 
         'options' => array( 
            'label' => 'Name', 
         ), 
      )); 
      $this->add(array( 
         'name' => 'emp_job', 
         'type' => 'Text', 
         'options' => array( 
            'label' => 'Job', 
         ), 
      )); 
      $this->add(array( 
         'name' => 'submit', 
         'type' => 'Submit', 
         'attributes' => array(
            'value' => 'Go', 
            'id' => 'submitbutton', 
         ), 
      )); 
   } 
}                    