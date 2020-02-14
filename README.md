
# Laravel Flymail

## About
Laravel Flymail adds **Mail::config()** method to Laravel\Mail. Config method will setup mail config data on the fly. 
Use Flymail if you need to send Mails with dynamic credentials you store in DB or other configs.
Since it just extends Laravel's Mail and adds **config** method, everything else remains same. 

## Installation
```bash
composer require emchooo/laravel-flymail
```

## Usage

```php
use Illuminate\Support\Facades\Mail;

// get config file from DB or other source

// SES config
$config = [ 
	'driver' => 'ses', 
	'key' => 'xxx', 
	'secret' => 'xxx', 
	'from' => [ 
		'address' => 'address@mail.com', 
		'name' => 'Name' 
		] 
	];
// SMTP config
$config = [
	'driver' => 'smtp',
	'host' => 'smtp.xxx.io', 
	'port' => 2525,
	'username' => 'xxx',
	'password' => 'xxx',
	'encription' => 'null'
	'from' => [ 
		'address' => 'address@mail.com', 
		'name' => 'Name' 
		]
	];

Mail::config($config)->to($request->user())->send(new OrderShipped($order));

```

## NOTE ON QUEUES

If you use **Mail::config** than don't use **->queue();** , use **->send();** .
If you use queue on Mail then it will use config from /config/mail.php while sending.
Might try to fix that one day.

If you need to queue Mail with custom config then use Jobs.

```php
	SendEmail::dispatch($config, $order);
```
---
```php
	/**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($config, $order)
    {
        $this->config = $config;
        $this->order = $order;
    }
    
	 /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        Mail::config($this->config)
        ->to($this->order->email)
        ->send(new OrderShipped($this->order));
    }
```


## License
The MIT License (MIT). Please see [License File](LICENSE.md) for more information.