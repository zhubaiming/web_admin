<?php

namespace Aex\Packagetest;

use Illuminate\Config\Repository;
use Illuminate\Session\SessionManager;

class Packagetest
{
    protected $session;

    protected $config;

    public function __construct(SessionManager $session, Repository $config)
    {
        $this->session = $session;
        $this->config = $config;
    }

    public function test_rtn($msg = '')
    {
        $config_arr = $this->config->get('packagetest.options');
        return $msg . '<strong>from your custom develop package!</strong>';
    }
}
