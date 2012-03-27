<?php
class Bootstrap_Form extends Zend_Form
{
    private $_customDecorators = array();
    public $formDecorators = array('formElements' , array('htmlTag' , array('tag' => 'div' , 'class' => 'group')) ,
        array('Form' , array('class' => 'nice'),));
    public $oneLineFormDecorators = array('formElements' , array('htmlTag' , array('tag' => 'div' , 'class' => 'one-line-group')),array('FormErrors',array('placement'=>'append')) ,
        array('Form' , array('class' => 'nice')));
    public $oneLineDecorators = array(
        'viewHelper', 
        
    );
    public $oneLineButtonDecorators = array(
        'viewHelper', 
        array('htmlTag',array('tag'=>'span','class'=>'button')),
        
    );
    public $elementDecorators = array();
    public $checkboxDecorators = array();
    public $multiDecoratorsRadio = array();
    public $multiDecoratorsCheckbox = array();
    public $buttonDecorators = array();
    public $groupDecorators = array();
    public $submitGroupDecorators = array();
    
    public function __construct($options = null)
    {
        $this->setAttrib('class', 'form-horizontal');
        $this->buttonDecorators = array('viewHelper');
        $this->groupDecorators = array('formElements', new Bootstrap_Form_Decorator_AutoFieldset());
        $this->elementDecorators = array(
            'viewHelper', 
        	array('Errors', array('tag' => 'span', 'class' => 'help-inline')),
            array('Description', array('placement' => 'append', 'tag' => 'div', 'class' => 'help-block', 'escape' => false)), 
            array(array('controls' => 'htmlTag'), array('tag' => 'div', 'class' => 'controls')), 
            array('Label', array('placement' => 'preppend', 'class' => 'control-label')), 
            array(new Bootstrap_Form_Decorator_ControlGroup()),
        );
        $this->multiDecoratorsRadio = array(
	        array(new Bootstrap_Form_Decorator_Radio()),
	        array('Errors', array('tag' => 'span', 'class' => 'help-inline')), 
	        array('Description', array('placement' => 'append', 'tag' => 'div', 'class' => 'help-block', 'escape' => false)), 
	        array(array('controls' => 'htmlTag'), array('tag' => 'div', 'class' => 'controls')),
	        array('Label', array('class' => 'control-label')), 
	        array(new Bootstrap_Form_Decorator_ControlGroup()), 
        );
        
        $this->multiDecoratorsCheckbox = array(
	        array(new Bootstrap_Form_Decorator_Checkbox()),
	        array('Errors', array('tag' => 'span', 'class' => 'help-inline')), 
	        array('Description', array('placement' => 'append', 'tag' => 'div', 'class' => 'help-block', 'escape' => false)), 
	        array(array('controls' => 'htmlTag'), array('tag' => 'div', 'class' => 'controls')),
	        array('Label', array('class' => 'control-label')), 
	        array(new Bootstrap_Form_Decorator_ControlGroup()), 
        );
        
        $this->checkboxDecorators = array(
            'viewHelper',
        	array(new Bootstrap_Form_Decorator_CheckboxLabel(array('class' => 'checkbox'))), 
        	array('Errors', array('tag' => 'span', 'class' => 'help-inline')),
            array('Description', array('placement' => 'append', 'tag' => 'div', 'class' => 'help-block', 'escape' => false)), 
            array(array('controls' => 'htmlTag'), array('tag' => 'div', 'class' => 'controls')), 
             
            array(new Bootstrap_Form_Decorator_ControlGroup()),
        );
        
        $this->groupDecorators = array(
            'FormElements',
        	'Fieldset',
        );
        
        $this->submitGroupDecorators = array(
            'FormElements',
        	array('htmlTag', array('class' => 'form-actions')), 
        );
        
        parent::__construct($options);
    }
    
    public function loadDefaultDecorators()
    {
        parent::loadDefaultDecorators();
        $this->setElementDefaultDecorators();    
    }
    
    public function setElementDefaultDecorators ()
    {
        foreach ($this->getSubForms() as $sf) {
            $sf->setElementDefaultDecorators();
        }
        foreach ($this->getElements() as $el) {
            if(in_array($el->getName(),$this->getCustomDecorators()) ){
                continue;
            }
            //echo '|'.$el->getName().' is '.$el->helper;
            switch ($el->helper) {
                case 'formSubmit':
                case 'formReset':
                    $el->setDecorators($this->buttonDecorators);
                    break;
                case 'formRadio':
                    $el->setDecorators($this->multiDecoratorsRadio);
                    break;
                case 'formMultiCheckbox':
                	$el->setDecorators($this->multiDecoratorsCheckbox);
                    break;
                case 'formCheckbox':
                    $el->setDecorators($this->checkboxDecorators);
                    break;
                
                default:
                    $el->setDecorators($this->elementDecorators);
                    break;
            }
        }
        foreach ($this->getDisplayGroups() as $group) {
        	
        	if (strpos($group->getName(), 'submit_') === 0) {
	            $group->setDecorators($this->submitGroupDecorators);
	            continue;
        	}
            $group->setDecorators($this->groupDecorators);
        }
    }
    
    public function getCustomDecorators()
    {
        return $this->_customDecorators;
    }
}