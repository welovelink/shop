<?php

namespace App\Helpers;

use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use Illuminate\Http\JsonResponse;

trait Helper
{

    public static function EmailSend($params = [])
    {
        $mail = new PHPMailer(true);
        try {
            //Server settings
            $mail->SMTPDebug = SMTP::DEBUG_OFF;
            $mail->isSMTP();
            $mail->CharSet = 'UTF-8';
            $mail->Host = env('MAIL_HOST');
            $mail->SMTPAuth = true;
            $mail->Username = env('MAIL_USERNAME');
            $mail->Password = env('MAIL_PASSWORD');
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = env('MAIL_PORT');

            $to_email = $params['email'];
            $to_name = $params['name'];
            //Recipients
            $mail->setFrom(env('MAIL_FROM_ADDRESS'), env('MAIL_FROM_NAME'));
            $mail->addAddress($to_email, $to_name);

            if (isset($params['attachment'])) {
                $mail->addAttachment($params['attachment']);
            }

            if (isset($params['attachments'])) {
                foreach ($params['attachments'] as $attachment) {
                    $mail->addAttachment($attachment);
                }
            }

            //Content
            $mail->isHTML(true);
            $mail->Subject = $params['subject'];
            $mail->Body = $params['message'];

            $mail->SMTPOptions = [
                'ssl' => [
                    'verify_peer' => false,
                    'verify_peer_name' => false,
                    'allow_self_signed' => true,
                ],
            ];

            $mail->send();

        } catch (Exception $e) {
            echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }

    }

    public static function isAdmin(): bool
    {
        return auth()->user()->tokenCan('admin');
    }

    public static function isEditor(): bool
    {
        return auth()->user()->tokenCan('editor');
    }

    public static function isViewer(): bool
    {
        return auth()->user()->tokenCan('viewer');
    }

    public static function isCustomer(): bool
    {
        return auth()->user()->tokenCan('customer');
    }

    protected function onSuccess($data, string $message = '', int $code = 200): JsonResponse
    {
        return response()->json([
            'status' => $code,
            'message' => $message,
            'data' => $data,
        ], $code);
    }

    protected function onError(int $code, string $message = ''): JsonResponse
    {
        return response()->json([
            'status' => $code,
            'message' => $message,
        ], $code);
    }

}
