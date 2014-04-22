<?php

namespace Acme\UserBundle\Util;

interface TokenGeneratorInterface
{
    /**
     * @return string
     */
    public function generateToken();
}
