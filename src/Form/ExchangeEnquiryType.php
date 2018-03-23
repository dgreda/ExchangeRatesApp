<?php

declare(strict_types=1);

namespace App\Form;

use App\Entity\ExchangeEnquiry;
use App\ExchangeRates\ExchangeService;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CurrencyType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ExchangeEnquiryType extends AbstractType
{
    /**
     * @var ExchangeService
     */
    private $exchangeService;

    /**
     * ExchangeEnquiryType constructor.
     *
     * @param ExchangeService $exchangeService
     */
    public function __construct(ExchangeService $exchangeService)
    {
        $this->exchangeService = $exchangeService;
    }

    /**
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     *
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $currencies = $this->exchangeService->getSupportedCurrencies();
        array_unshift($currencies, 'EUR');
        $currenciesList = array_combine($currencies, $currencies);

        $builder
            ->add(
                'baseCurrency',
                CurrencyType::class,
                [
                    'choice_loader' => null,
                    'choices'       => $currenciesList,
                ]
            )
            ->add('amount', NumberType::class)
            ->add(
                'targetCurrency',
                CurrencyType::class,
                [
                    'choice_loader' => null,
                    'choices'       => $currenciesList,
                ]
            )
            ->add('Exchange!', SubmitType::class);
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => ExchangeEnquiry::class,
        ]);
    }
}
