<?php
class Bootstrap_Form extends Zend_Form
{
    protected $_customDecorators = array();

    protected $_defaultElementDecorators = array();
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

        $this->initDefaultDecorators();

        parent::__construct($options);
    }

    public function initDefaultDecorators() {
        $this->_defaultElementDecorators = array(
            'viewHelper',
            array('Errors', array('class' => 'help-inline')),
            array('Description', array('placement' => 'append', 'tag' => 'div', 'class' => 'help-block', 'escape' => false)),
            array(array('controls' => 'htmlTag'), array('tag' => 'div', 'class' => 'controls')),
            array('Label', array('placement' => 'preppend', 'class' => 'control-label')),
            array(new Bootstrap_Form_Decorator_ControlGroup()),
        );

        $this->_checkboxDecorators = array(
            'viewHelper',
            array(new Bootstrap_Form_Decorator_CheckboxLabel(array('class' => 'checkbox'))),
            array('Description', array('placement' => 'append', 'tag' => 'div', 'class' => 'help-block', 'escape' => false)),
            array('Errors', array('class' => 'help-block')),
            array(array('controls' => 'htmlTag'), array('tag' => 'div', 'class' => 'controls')),
            array(new Bootstrap_Form_Decorator_ControlGroup()),
        );

        $this->_buttonDecorators = array(
            'viewHelper',
        );

        $this->_fileDecorators = array(
            'File',
            array('Description', array('placement' => 'append', 'tag' => 'div', 'class' => 'help-block', 'escape' => false)),
            array('Errors', array('class' => 'help-block')),
            array(array('controls' => 'htmlTag'), array('tag' => 'div', 'class' => 'controls')),
            array('Label', array('class' => 'control-label')),
            array(new Bootstrap_Form_Decorator_ControlGroup()),
        );

        $this->_multiDecoratorsRadio = array(
            array(new Bootstrap_Form_Decorator_Radio()),
            array('Errors', array('class' => 'help-inline')),
            array('Description', array('placement' => 'append', 'tag' => 'div', 'class' => 'help-block', 'escape' => false)),
            array(array('controls' => 'htmlTag'), array('tag' => 'div', 'class' => 'controls')),
            array('Label', array('class' => 'control-label')),
            array(new Bootstrap_Form_Decorator_ControlGroup()),
        );

        $this->_multiDecoratorsCheckbox = array(
            array(new Bootstrap_Form_Decorator_Checkbox()),
            array('Errors', array('class' => 'help-inline')),
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
                    $el->setDecorators($this->getDefaultElementDecorators());
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

    public function setCustomDecorators($customDecorators) {
        $this->_customDecorators = $customDecorators;
    }

    public function getCustomDecorators() {
        return unserialize(serialize($this->_customDecorators));
    }

    public function setDefaultElementDecorators($defaultElementDecorators) {
        $this->_defaultElementDecorators = $defaultElementDecorators;
    }

    public function getDefaultElementDecorators() {
        return unserialize(serialize($this->_defaultElementDecorators));
    }

    public function setCheckboxDecorators($checkboxDecorators) {
        $this->_checkboxDecorators = $checkboxDecorators;
    }

    public function getCheckboxDecorators() {
        return unserialize(serialize($this->_checkboxDecorators));
    }

    public function setButtonDecorators($buttonDecorators) {
        $this->_buttonDecorators = $buttonDecorators;
    }

    public function getButtonDecorators() {
        return unserialize(serialize($this->_buttonDecorators));
    }

    public function setFileDecorators($fileDecorators) {
        $this->_fileDecorators = $fileDecorators;
    }

    public function getFileDecorators() {
        return unserialize(serialize($this->_fileDecorators));
    }

    public function setMultiDecoratorsRadio($multiDecoratorsRadio) {
        $this->_multiDecoratorsRadio = $multiDecoratorsRadio;
    }

    public function getMultiDecoratorsRadio() {
        return unserialize(serialize($this->_multiDecoratorsRadio));
    }

    public function setMultiDecoratorsCheckbox($multiDecoratorsCheckbox) {
        $this->_multiDecoratorsCheckbox = $multiDecoratorsCheckbox;
    }

    public function getMultiDecoratorsCheckbox() {
        return unserialize(serialize($this->_multiDecoratorsCheckbox));
    }

    public function setGroupDecorators($groupDecorators) {
        $this->_groupDecorators = $groupDecorators;
    }

    public function getGroupDecorators() {
        return unserialize(serialize($this->_groupDecorators));
    }

    public function setSubmitGroupDecorators($submitGroupDecorators) {
        $this->_submitGroupDecorators = $submitGroupDecorators;
    }

    public function getSubmitGroupDecorators() {
        return unserialize(serialize($this->_submitGroupDecorators));
    }

}