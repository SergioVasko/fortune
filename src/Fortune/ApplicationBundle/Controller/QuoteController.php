<?php

namespace Fortune\ApplicationBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class QuoteController extends Controller
{
    /**
     * @Route("/api/quotes", methods={"POST"})
     */
    public function submitAction(Request $request)
    {
        $quoteRepository = $this->container->get('fortune_application.quote_repository');
        $postedValues = $request->request->all();

        if (empty($postedValues['content'])) {
            $answer = array('message' => 'Missing required parameter: content');

            return new JsonResponse($answer, Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $quote = $quoteRepository->insert($postedValues['content']);

        return new JsonResponse($quote, Response::HTTP_CREATED);
    }

    /**
     * @Route("/api/quotes", methods={"GET"})
     */
    public function listAction(Request $request)
    {
        $quoteRepository = $this->container->get('fortune_application.quote_repository');
        $quotes = $quoteRepository->findAll();

        return new JsonResponse($quotes, Response::HTTP_OK);
    }
}