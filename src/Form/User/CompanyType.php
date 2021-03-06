<?php

namespace App\Form\User;

use App\Entity\Company;
use App\Repository\Api\RestCountries;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CompanyType extends AbstractType
{
    /**
     * @var RestCountries
     */
    private RestCountries $restCountries;

    public function __construct(RestCountries $restCountries)
    {
        $this->restCountries = $restCountries;
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        if ($options['action'] === UserType::CREATE_COMPANY) {
            $this->companyInformations($builder);
        }
        if ($options['action'] === UserType::EDIT_COMPANY_INFORMATION) {
            $this
                ->companyInformations($builder)
                ->siret($builder);
        }
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Company::class,
            'action' => ''
        ]);
    }

    private function companyInformations(FormBuilderInterface $builder): self
    {
        $countries = $this->restCountries->getAllCountries();

        $builder
            ->add('name', TextType::class, [
                'label' => 'Nom de l\'entreprise :'
            ])
            ->add('postalCode', IntegerType::class, [
                'label' => 'Code Postal :'
            ])
            ->add('city', TextType::class, [
                'label' => 'Ville :'
            ])
            ->add('country', ChoiceType::class, [
                'label' => 'Pays :',
                'choices' => $countries,
                'preferred_choices' => [$countries['France']],
                'empty_data' => $countries['France'],
            ])
            ->add('address', TextType::class, [
                'label' => 'Adresse :'
            ])
            ->add('siret', IntegerType::class)
            ->add('contact', ContactType::class, [
                'label' => false,
            ]);
        return $this;
    }

    private function siret(FormBuilderInterface $builder): self
    {
        $builder
            ->add('siret', IntegerType::class);

        return $this;
    }
}
