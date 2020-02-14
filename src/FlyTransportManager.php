<?php

namespace Emchooo\Flymail;

use Illuminate\Mail\TransportManager;

class FlyTransportManager extends TransportManager
{
    /**
    * Set config.
    *
    * @param array $config
    * @return void
    */
    public function setConfig(array $config)
    {
        if ($config['driver'] == 'smtp') {
            $this->config['mail'] = $config;
        } else {
            $this->setServiceConfig($config);
        }
    }

    /**
    * Set service config
    *
    * @param array $config
    * @return void
    */
    protected function setServiceConfig(array $config)
    {
        $serviceConfig = $this->config['services'];
        $serviceConfig[$config['driver']] = $config;
        $this->config['services'] = $serviceConfig;
    }
}
