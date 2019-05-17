<?php
/**
 * Created by PhpStorm.
 * User: diana.lari
 * Date: 11/14/2018
 * Time: 9:23 AM
 */

declare(strict_types=1);

namespace App\EventListener;

use Symfony\Component\HttpKernel\Event\GetResponseForExceptionEvent;
use Symfony\Component\HttpFoundation\Response;

class ExceptionListener
{
    public function onKernelException(GetResponseForExceptionEvent $event)
    {
        $exception = $event->getException();
        $event->allowCustomResponseCode();
        $response = new Response($exception->getMessage(), 400);
        $event->setResponse($response);
    }
}