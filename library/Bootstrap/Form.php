<?php
class Bootstrap_Form extends Zend_Form
{
    protected $_customDecorators = array();

    protected $_elementDecorators = array();
    protected $_checkboxDecorators = array();
    protected $_buttonDecorators = array();
    protected $_fileDecorators = array();
    protected $_multiDecoratorsRadio = array();
    protected $_multiDecoratorsCheckbox = array();
    protected $_groupDecorators = array();
    protected $_submitGroupDecorators = array();

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

    public function __construct($options = null)
    {
        $this->setAttrib('class', 'form-horizontal');

        // setup default form decorators

        $this->_elementDecorators = array(
            'viewHelper',
            array('Errors', array('tag' => 'span', 'class' => 'help-inline')),
            array('Description', array('placement' => 'append', 'tag' => 'div', 'class' => 'help-block', 'escape' => false)),
            array(array('controls' => 'htmlTag'), array('tag' => 'div', 'class' => 'controls')),
            array('Label', array('placement' => 'preppend', 'class' => 'control-label')),
            array(new Bootstrap_Form_Decorator_ControlGroup()),
        );

        $this->_checkboxDecorators = array(
            'viewHelper',
            array(new Bootstrap_Form_Decorator_CheckboxLabel(array('class' => 'checkbox'))),
            array('Description', array('placement' => 'append', 'tag' => 'div', 'class' => 'help-block', 'escape' => false)),
            array('Errors', array('tag' => 'span', 'class' => 'help-block')),
            array(array('controls' => 'htmlTag'), array('tag' => 'div', 'class' => 'controls')),
            array(new Bootstrap_Form_Decorator_ControlGroup()),
        );

        $this->_buttonDecorators = array(
            'viewHelper',
        );

        $this->_fileDecorators = array(
            'File',
            array('Description', array('placement' => 'append', 'tag' => 'div', 'class' => 'help-block', 'escape' => false)),
            array('Errors', array('tag' => 'span', 'class' => 'help-block')),
            array(array('controls' => 'htmlTag'), array('tag' => 'div', 'class' => 'controls')),
            array('Label', $labelOptions),
            array(new Bootstrap_Form_Decorator_ControlGroup()),
        );

        $this->_multiDecoratorsRadio = array(
            array(new Bootstrap_Form_Decorator_Radio()),
            array('Errors', array('tag' => 'span', 'class' => 'help-inline')),
            array('Description', array('placement' => 'append', 'tag' => 'div', 'class' => 'help-block', 'escape' => false)),
            array(array('controls' => 'htmlTag'), array('tag' => 'div', 'class' => 'controls')),
            array('Label', array('class' => 'control-label')),
            array(new Bootstrap_Form_Decorator_ControlGroup()),
        );

        $this->_multiDecoratorsCheckbox = array(
            array(new Bootstrap_Form_Decorator_Checkbox()),
            array('Errors', array('tag' => 'span', 'class' => 'help-inline')),
            array('Description', array('placement' => 'append', 'tag' => 'div', 'class' => 'help-block', 'escape' => false)),
            array(array('controls' => 'htmlTag'), array('tag' => 'div', 'class' => 'controls')),
            array('Label', array('class' => 'control-label')),
            array(new Bootstrap_Form_Decorator_ControlGroup()),
        );

        $this->_groupDecorators = array(
            'FormElements',
            'Fieldset', // new Bootstrap_Form_Decorator_AutoFieldset(),
        );

        $this->_submitGroupDecorators = array(
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
                    $el->setDecorators($this->getButtonDecorators());
                    break;
                case 'formRadio':
                    $el->setDecorators($this->getMultiDecoratorsRadio());
                    break;
                case 'formMultiCheckbox':
                    $el->setDecorators($this->getMultiDecoratorsCheckbox());
                    break;
                case 'formCheckbox':
                    $el->setDecorators($this->getCheckboxDecorators());
                    break;
                case 'formFile':
                    $el->setDecorators($this->getFileDecorators());
                    break;

                default:
                    $el->setDecorators($this->getElementDecorators());
                    break;
            }
        }
        foreach ($this->getDisplayGroups() as $group) {

            if (strpos($group->getName(), 'submit_') === 0) {
                $group->setDecorators($this->getSubmitGroupDecorators());
                continue;
            }
            $group->setDecorators($this->getGroupDecorators());
        }
    }

    public function getCustomDecorators() {
        return $this->_customDecorators;
    }

    public function getElementDecorators() {
        return $this->_elementDecorators;
    }

    public function getCheckboxDecorators() {
        return $this->_checkboxDecorators;
    }

    public function getButtonDecorators() {
        return $this->_buttonDecorators;
    }

    public function getFileDecorators() {
        return $this->_fileDecorators;
    }

    public function getMultiDecoratorsRadio() {
        return $this->_multiDecoratorsRadio;
    }

    public function getMultiDecoratorsCheckbox() {
        return $this->_multiDecoratorsCheckbox;
    }

    public function getGroupDecorators() {
        return $this->_groupDecorators;
    }

    public function getSubmitGroupDecorators() {
        return $this->_submitGroupDecorators;
    }
}