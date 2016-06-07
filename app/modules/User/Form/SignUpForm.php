<?php
/**
 * @namespace
 */
namespace User\Form;

use Phalcon\Forms\Form;
use Phalcon\Forms\Element\Text;
use Phalcon\Forms\Element\Hidden;
use Phalcon\Forms\Element\Password;
use Phalcon\Forms\Element\Submit;
use Phalcon\Forms\Element\Check;
use Phalcon\Validation\Validator\PresenceOf;
use Phalcon\Validation\Validator\Email;
use Phalcon\Validation\Validator\Identical;
use Phalcon\Validation\Validator\StringLength;
use Phalcon\Validation\Validator\Confirmation;

class SignUpForm extends Form
{

    public function initialize($entity = null, $options = null)
    {
        $name = new Text('name');

        $name->setLabel('Имя!');

        $name->addValidators(array(
            new PresenceOf(array(
                'message' => 'Введите имя.'
            ))
        ));

        $this->add($name);

        // Cell phone number
        $cellPhoneNumber = new Text('cellPhoneNumber');

        $cellPhoneNumber->setLabel('Cell Phone Number');

        $cellPhoneNumber->addValidators(array(
            new PresenceOf(array(
                'message' => 'Введите номер телефона.'
            )),
        ));

        $this->add($cellPhoneNumber);

        // Email
        $email = new Text('email');

        $email->setLabel('E-Mail');

        $email->addValidators(array(
            new PresenceOf(array(
                'message' => 'Введите адрес элкетронной почты.'
            )),
            new Email(array(
                'message' => 'Неправильный адрес электронной почты.'
            ))
        ));

        $this->add($email);

        // Password
        $password = new Password('password');

        $password->setLabel('Пароль');

        $password->addValidators(array(
            new PresenceOf(array(
                'message' => 'Введите пароль'
            )),
            new StringLength(array(
                'min' => 8,
                'messageMinimum' => 'Пароль слишком короткий. Минимум 8 знаков.'
            )),
            new Confirmation(array(
                'message' => 'Password doesn\'t match confirmation',
                'with' => 'confirmPassword'
            ))
        ));

        $this->add($password);

        // Confirm Password
        $confirmPassword = new Password('confirmPassword');

        $confirmPassword->setLabel('Подтвердить пароль');

        $confirmPassword->addValidators(array(
            new PresenceOf(array(
                'message' => 'Введтие подтверждение пароля'
            ))
        ));

        $this->add($confirmPassword);

        // Remember
        $terms = new Check('terms', array(
            'value' => 'yes'
        ));

        $terms->setLabel('Accept terms and conditions');

        $terms->addValidator(new Identical(array(
            'value' => 'yes',
            'message' => 'Без согласия с правилами вы не можете продолжить регистрацию.'
        )));

        $this->add($terms);

/*        // CSRF
        $csrf = new Hidden('csrf');

        $csrf->addValidator(new Identical(array(
            'value' => $this->security->getSessionToken(),
            'message' => 'CSRF validation failed'
        )));

        $this->add($csrf);*/

        // Sign Up
        $this->add(new Submit('Sign Up', array(
            'class' => 'btn btn-success'
        )));
    }

    /**
     * Prints messages for a specific element
     */
    public function messages($name)
    {
        if ($this->hasMessagesFor($name)) {
            foreach ($this->getMessagesFor($name) as $message) {
                $this->flash->error($message);
            }
        }
    }
}
