<?php

namespace Terminal\SecurityBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class TerminalSecurityBundle extends Bundle
{
    public function getParent()
    {
        return 'FOSUserBundle';
    }
}
