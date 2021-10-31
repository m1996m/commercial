<?php

namespace App\Form;

use App\Entity\ProduitStock;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProduitStockType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('PUA')
            ->add('PUV')
            ->add('createdAt')
            ->add('quantite')
            ->add('user')
            ->add('produit')
            ->add('fournisseur')
            ->add('stock')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => ProduitStock::class,
        ]);
    }
}
