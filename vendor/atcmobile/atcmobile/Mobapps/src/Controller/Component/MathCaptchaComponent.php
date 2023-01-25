<?php
/**
 * Math Captcha Component class.
 *
 * Generates a simple, plain text math equation as an alternative to image-based CAPTCHAs.
 *
 * @filesource
 * @author			Jamie Nay
 * @copyright       Jamie Nay
 * @license			http://www.opensource.org/licenses/mit-license.php The MIT License
 * @link            http://jamienay.com/code/math-captcha-component
 */
 
namespace Atcmobapp\Mobapps\Controller\Component;

use Cake\Controller\Component;
use Cake\Event\Event;
use Cake\ORM\TableRegistry;
use Cake\Utility\Hash;

 
class MathCaptchaComponent extends Component {

    /**
     * Other components needed by this component
     *
     * @access public
     * @var array
     */
    // public $components = array('Session');

    /**
	 * component settings
	 *
	 * @access public
	 * @var array
	 */
     public $settings = array();

    /**
	 * Default values for settings.
	 *
	 * @access private
	 * @var array
	 */
    private $__defaults = array(
        'operand' => '+',
        'minNumber' => 1,
        'maxNumber' => 5,
        'numberOfVariables' => 3
    );

    /**
     * The variables used in the equation.
     *
     * @access public
     * @var array
     */
    public $variables = array();

    protected $_controller = null;
    
    /*
     * The math equation.
     *
     * @access public
     * @var string
     */
    public $equation = null;

	public function __construct($config,$controller)
	{
	    $this->settings = array_merge($this->__defaults, $config);
	    $this->_controller = $controller;
	}

    /**
     * Configuration method.
     *
     * @access public
     * @param object $model
     * @param array $settings
     */
     
    public function initialize(array $config)
    {
    
    }

    /*
     * Method that generates a math equation based on the component settings. It also calls
     * a secondary function, registerAnswer(), which determines the answer to the equation
     * and sets it as a session variable.
     *
     * @access public
     * @return string
     *
     */ 
    public function generateEquation() {
        foreach (range(1, $this->settings['numberOfVariables']) as $variable) {
            $this->variables[] = rand($this->settings['minNumber'], $this->settings['maxNumber']);
        }
        $this->equation = implode(' ' . $this->settings['operand'] . ' ', $this->variables);
        $this->registerAnswer();
        return $this->equation;
    }

    /*
     * Determines the answer to the math question from the variables set in generateEquation()
     * and registers it as a session variable.
     *
     * @access public
     * @return integer
     */
    public function registerAnswer() {
        $answer = '';
        eval("\$answer = ".$this->equation.";");
        $this->_controller->request->getSession()->write('MathCaptcha.answer', $answer);
        return $answer;
    }

    /*
     * Compares the given data to the registered equation answer.
     *
     * @access public
     * @return boolean
     */
    public function validates($data) {
	return $data == $this->_controller->request->getSession()->read('MathCaptcha.answer');
    }

}

?>