<?php

namespace Fortune\ApplicationBundle\EventListener;

use Symfony\Component\HttpKernel\Event\GetResponseEvent;

class SubmitJsonListener
{
    public function onKernelRequest(GetResponseEvent $event)
    {
        $request = $event->getRequest();
        $content = $request->getContent();
        $data = json_decode($content, true);
        if (JSON_ERROR_NONE !== json_last_error()) {
            $data = array('message' => 'Invalid or malformed JSON');
            $response = new JsonResponse($data, Response::HTTP_BAD_REQUEST);
            $event->setResponse($response);
            $event->stopPropagation();
        }
        $request->request->add($data ?: array());
    }
}