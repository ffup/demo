<?php

namespace Acme\UserBundle\EventListener;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Exception\BadCredentialsException;
use Symfony\Component\Security\Http\Firewall\UsernamePasswordFormAuthenticationListener;
use ZendService\ReCaptcha\ReCaptcha;

class FormAuthenticationListener extends UsernamePasswordFormAuthenticationListener
{
    private $pubKey = '6Lck-cwSAAAAAEsR9fjwcbnF-vnS201EIm7u3hHt'; 
    
    private $privKey = '6Lck-cwSAAAAAGS8YFI3DJGNgoDEzlavglTFJkWT';

    protected function attemptAuthentication(Request $request)
    {
        $recaptcha = new ReCaptcha();
        $recaptcha->setPublicKey($this->pubKey);
        $recaptcha->setPrivateKey($this->privKey);

        $response = $request->request->get('recaptcha_response_field');
        $challenge = $request->request->get('recaptcha_challenge_field');
        
        if (empty($response)) {
            throw new BadCredentialsException('Captcha should not be blank');
        }
        
        $result = $recaptcha->verify(
            $challenge,
            $response
        );

        if (!$result->isValid()) {
            // Failed validation
            throw new BadCredentialsException('Captcha is invalid');
        }

        return parent::attemptAuthentication($request);
    }
}
