<?php

namespace Acme\UserBundle\Validator\Constraints;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\HttpFoundation\Request;
use ZendService\ReCaptcha\ReCaptcha;

class RecaptchaValidator extends ConstraintValidator
{
    public $message = 'This value is not a valid captcha.';
    
    public $pubKey = '6Lck-cwSAAAAAEsR9fjwcbnF-vnS201EIm7u3hHt'; 
    
    private $privKey = '6Lck-cwSAAAAAGS8YFI3DJGNgoDEzlavglTFJkWT';
    
    public $request;
    
    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function validate($value, Constraint $constraint)
    {
         $recaptcha = new ReCaptcha();
         $recaptcha->setPublicKey($this->pubKey);
         $recaptcha->setPrivateKey($this->privKey);
     
         $resp = $request->request->get('recaptcha_response_field');
         if (!empty($resp)) {

            $result = $recaptcha->verify(
                $request->request->get('recaptcha_challenge_field'),
                $request->request->get('recaptcha_response_field')
            );

            if (!$result->isValid()) {
                $this->context->addViolation($constraint->message);
                // Failed validation
            }
        }
    }
}
