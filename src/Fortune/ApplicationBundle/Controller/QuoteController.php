<?php

namespace Fortune\ApplicationBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;

class QuoteController extends Controller
{
    public function submitAction(Request $request)
    {
        $quoteRepository = $this->container->get('fortune_application.quote_repository');
        //$postedContent = $request->getContent();
        //$postedValues = json_decode($postedContent, true);
        $postedValues = $request->request->all();

        if (empty($postedValues['content'])) {
            $answer = array('message' => 'Missing required parameter: content');

            return new JsonResponse($answer, Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $quote = $quoteRepository->insert($postedValues['content']);

        return new JsonResponse($quote, Response::HTTP_CREATED);
    }

    public function listAction(Request $request)
    {
        $quoteRepository = $this->container->get('fortune_application.quote_repository');
        $quotes = $quoteRepository->findAll();

        return new JsonResponse($quotes, Response::HTTP_OK);
    }
}