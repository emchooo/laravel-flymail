<?php

namespace Emchooo\Flymail;

use Swift_Mailer;
use Swift_SmtpTransport;
use Illuminate\Mail\Mailer;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Illuminate\Mail\TransportManager;
use Emchooo\Flymail\FlyTransportManager;

class Flymail extends Mailer
{
    /**
    * Set the config
    *
    * @param array $config
    * @return $this
    */
    public function config(array $config)
    {
        $transport = $this->registerFlyTransport($config);

        $swift_mailer = new Swift_Mailer($transport->driver());

        $this->setSwiftMailer($swift_mailer);

        foreach (['from', 'reply_to', 'to'] as $type) {
            $this->setGlobalAddress($this, $config, $type);
        }

        return $this;
    }

    /**
    * Set driver and config.
    *
    * @param array $config
    * @return \Emchooo\Flymail\FlyTransportManager
    */
    protected function registerFlyTransport(array $config)
    {
        $transport = new FlyTransportManager(app());

        $transport->setDefaultDriver($config['driver']);

        $transport->setConfig($config);

        return $transport;
    }

    /**
     * Set a global address on the mailer by type.
     *
     * @param  \Illuminate\Mail\Mailer  $mailer
     * @param  array  $config
     * @param  string  $type
     * @return void
     */
    protected function setGlobalAddress($mailer, array $config, $type)
    {
        $address = Arr::get($config, $type);

        if (is_array($address) && isset($address['address'])) {
            $mailer->{'always'.Str::studly($type)}($address['address'], $address['name']);
        }
    }
}
