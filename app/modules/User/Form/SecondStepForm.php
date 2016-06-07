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

class SecondStepForm extends Form
{

    public function initialize($entity = null, $options = null)
    {
        // First name
        $name = new Text('name');

        $name->setLabel('Имя!');

        $name->addValidators(array(
            new PresenceOf(array(
                'message' => 'Введите имя.'
            ))
        ));

        $this->add($name);

        // Last name
        $surname = new Text('surname');

        $surname->setLabel('Фамилия!');

        $surname->addValidators(array(
            new PresenceOf(array(
                'message' => 'Введите фамилию.'
            ))
        ));

        $this->add($surname);

        $this->add($name);

        // Second name
        $secondName = new Text('secondName');

        $secondName->setLabel('Отчество!');

        $secondName->addValidators(array(
            new PresenceOf(array(
                'message' => 'Введите отчество.'
            ))
        ));

        $this->add($secondName);

        // Gender
        $gender = new Text('gender');

        $gender->setLabel('Пол!');

        $gender->addValidators(array(
            new PresenceOf(array(
                'message' => 'Укажите свой пол.'
            ))
        ));

        $this->add($gender);


        // Birthday
        $birthday = new Text('birthday');

        $birthday->setLabel('День рождения!');

        $birthday->addValidators(array(
            new PresenceOf(array(
                'message' => 'Укажите дату рождения.'
            ))
        ));

        $this->add($birthday);

        // PassportNS
        $passportNS = new Text('passportNS');

        $passportNS->setLabel('passport number');

        $passportNS->addValidators(array(
            new PresenceOf(array(
                'message' => 'Серия и номер паспорта'
            ))
        ));

        $this->add($passportNS);

        // Passport Issued
        $passportIssued = new Text('passportIssued');

        $passportIssued->setLabel('passportIssued');

        $passportIssued->addValidators(array(
            new PresenceOf(array(
                'message' => 'Кем выдан'
            )),
        ));

        $this->add($passportIssued);

        // Passport Issued Time
        $passportIssuedTime = new Text('passportIssuedTime');

        $passportIssuedTime->setLabel('passportIssuedTime');

        $passportIssuedTime->addValidators(array(
            new PresenceOf(array(
                'message' => 'Когда выдан'
            ))
        ));

        $this->add($passportIssuedTime);

        // identification Number
        $identificationNumber = new Password('identificationNumber');

        $identificationNumber->setLabel('identificationNumber');

        $identificationNumber->addValidators(array(
            new PresenceOf(array(
                'message' => 'Введите'
            )),
            new StringLength(array(
                'min' => 8,
                'messageMinimum' => 'слишком короткий. Минимум 8 знаков.'
            ))
        ));

        $this->add($identificationNumber);

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
