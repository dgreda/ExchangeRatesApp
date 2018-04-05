<?php

declare(strict_types = 1);

namespace App\Controller;

use App\Entity\ExchangeEnquiry;
use App\ExchangeRates\ExchangeService;
use App\Form\Type\ExchangeEnquiryType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ExchangeRatesController extends Controller
{
    /**
     * @Route("/", name="main_page")
     *
     * @param Request         $request
     * @param ExchangeService $service
     *
     * @return Response
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
}
