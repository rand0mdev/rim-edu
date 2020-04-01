<?php

/*
 * This file is part of the COURAT application.
 *
 * (c) Bechir Ba and contributors
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Form;

use App\Entity\Classe;
use App\Entity\Day;
use App\Entity\Planning;
use App\Entity\Subject;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PlanningType extends AbstractType
{
    const ENTITY_CLASS = 'class';
    const ENTITY_LABEL = 'choice_label';

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('classes', EntityType::class, [
                self::ENTITY_CLASS => Classe::class,
                self::ENTITY_LABEL => 'name',
                'query_builder' => function (EntityRepository $repo) {
                    return $repo->createQueryBuilder('f')
                        ->where('f.id > :id')
                        ->setParameter('id', 1);
                },
                'label' => 'Who is fighting in this round?',
                'multiple' => true,
            ])
            ->add('subjects', EntityType::class, [
                self::ENTITY_CLASS => Subject::class,
                self::ENTITY_LABEL => 'code',
                'translation_domain' => true,
                'choice_translation_domain' => 'messages',
                'query_builder' => function (EntityRepository $repo) {
                    return $repo->createQueryBuilder('f')
                        ->where('f.id > :id')
                        ->setParameter('id', 1);
                },
                'label' => 'Who is fighting in this round?',
                'multiple' => true,
            ])
            ->add('day', EntityType::class, [
                self::ENTITY_CLASS => Day::class,
                self::ENTITY_LABEL => 'name',
                'translation_domain' => true,
                'choice_translation_domain' => 'messages',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Planning::class,
        ]);
    }
}
