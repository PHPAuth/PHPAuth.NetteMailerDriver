<?php

namespace PHPAuth\Mailer;

use PHPAuth\Exceptions\PHPAuthException;

class NetteMailerDriver implements MailerInterface
{
    private $mailer;
    private array $config;

    public function __construct(array $config = [])
    {
        if (!class_exists('\Nette\Mail\SendmailMailer')) {
            throw new \RuntimeException('Nette Mail не установлен. Установите: composer require nette/mail');
        }

        $this->config = $config;

        if (isset($config['smtp']) && $config['smtp']) {
            $this->mailer = new \Nette\Mail\SmtpMailer([
                'host' => $config['host'] ?? 'localhost',
                'username' => $config['username'] ?? '',
                'password' => $config['password'] ?? '',
                'secure' => $config['secure'] ?? '',
                'port' => $config['port'] ?? 25,
            ]);
        } else {
            $this->mailer = new \Nette\Mail\SendmailMailer();
        }
    }

    public function send(string $to, string $subject = '', string $body = '', string $altbody = '', string $from = null, string $fromName = null): bool
    {
        try {
            $mail = new \Nette\Mail\Message();

            $from = $from ?? $this->config['site_email'] ?? 'noreply@example.com';
            $fromName = $fromName ?? $this->config['site_name'] ?? 'PHPAuth';

            $mail->setFrom($from, $fromName)
                ->addTo($to)
                ->setSubject($subject)
                ->setHtmlBody($body);

            $this->mailer->send($mail);
            return true;
        } catch (\Exception $e) {
            throw new PHPAuthException('Nette Mail Error: ' . $e->getMessage());
        }
    }

    public function sendPasswordReset(string $email, string $resetKey): bool
    {
        return true;
    }

    public function sendActivation(string $email, string $activationKey): bool
    {
        return true;
    }
}