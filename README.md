# How to use?

```php
$config = new \PHPAuth\Config($pdo);

$config->setMailer(new \PHPAuth\Mailer\NetteMailerDriver([
    'smtp'      =>  true,
    
    'host'      =>  'smtp.gmail.com',
    'port'      =>  587, // relative to security type 

    'username'  =>  'your-email@gmail.com',
    'password'  =>  'your-password',

    'secure'    =>  \PHPMailer\PHPMailer\PHPMailer::ENCRYPTION_STARTTLS, // 'tls'
    // OR
    'secure'    =>  \PHPMailer\PHPMailer\PHPMailer::ENCRYPTION_SMTPS,   // 'ssl'
    
    // setFrom
    'site_email'    => 'noreply@yoursite.com',
    'site_name'     => 'Your Site'
]));

$auth = new \PHPAuth\Auth($pdo, $config);
```
