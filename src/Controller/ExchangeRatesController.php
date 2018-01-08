<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\ExchangeEnquiry;
use App\ExchangeRates\ExchangeService;
use App\Form\ExchangeEnquiryType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ExchangeRatesController extends Controller
{
    /**
     * @param Request $request
     *
     * @return Response
     *
     * @Route("/", name="main_page")
     */
    public function calculator(Request $request, ExchangeService $service): Response
    {
        $exchangeEnquiry = new ExchangeEnquiry();
        $form            = $this->createForm(ExchangeEnquiryType::class, $exchangeEnquiry);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            return $this->render('result.html.twig', [
                'enquiry' => $exchangeEnquiry,
                'result'  => $service->exchange($exchangeEnquiry),
            ]);
        }

        return $this->render('calculator.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * Matches /result
     *
     * @param ExchangeService $service
     *
     * @return JsonResponse
     *
     * @Route("/result", name="result_page")
     */
    public function result(ExchangeService $service): JsonResponse
    {
        return $this->json(
            [
                'supported'        => $service->getSupportedCurrencies(),
                'calculatedAmount' => $service->exchange(new ExchangeEnquiry(7000.00, 'PLN', 'EUR')),
            ]
        );
    }
}
