<?php

namespace App\EventListener;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;

class ExceptionListener
{
    /**
     * @param ExceptionEvent $event
     * @return void
     */
    public function onKernelException(ExceptionEvent $event)
    {
        $exception = $event->getThrowable();
        $request = $event->getRequest();

        if ('application/json' === $request->headers->get('Content-Type')) {

            $response = new JsonResponse([
                'message' => $exception->getMessage(),
                'code' => $exception->getCode(),
                'traces' => $exception->getTrace(),
            ]);

            if ($exception instanceof HttpExceptionInterface) {
                $response->setStatusCode($exception->getStatusCode());
                $response->headers->replace($exception->getHeaders());

                $id = $event->getRequest()->get('id');

                if ($response->isNotFound() && !filter_var($id, FILTER_VALIDATE_INT, ['options' => ['min_range' => 1]])) {
                    $response->setStatusCode(400);
                    $response->setData([
                        'message' => 'Bad Request',
                        'code'    => Response::HTTP_BAD_REQUEST,
                        'traces'  => $exception->getTrace(),
                    ]);
                }
            } else {
                $response->setStatusCode(Response::HTTP_INTERNAL_SERVER_ERROR);
            }

            $event->setResponse($response);
        }
    }
}
