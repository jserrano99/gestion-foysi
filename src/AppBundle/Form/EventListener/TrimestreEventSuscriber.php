<?php

namespace AppBundle\Form\EventListener;

use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\PropertyAccess\PropertyAccess;
use Doctrine\ORM\EntityRepository;
use SMTC\MainBundle\Entity\Country;

class TrimestreEventSuscriber implements EventSubscriberInterface {

    public static function getSubscribedEvents() {
        return array(
            FormEvents::PRE_SET_DATA => 'preSetData',
            FormEvents::PRE_SUBMIT => 'preSubmit'
        );
    }

    private function addTrimestreForm($form, $ejercicio) {
        $formOptions = array(
            'class' => 'AppBundle:Trimestre',
            'empty_value' => 'Trimestre',
            'label' => 'Trimestre',
            'mapped' => false,
            'attr' => array(
                'class' => 'trimestre_selector',
            ),
            'query_builder' => function (EntityRepository $repository) use ($ejercicio) {
                $qb = $repository->createQueryBuilder('u')
                        ->where('u.ejercicio = :ejercicio')
                        ->setParameter('ejercicio', $ejercicio)
                ;

                return $qb;
            }
        );

        if ($trimestre) {
            $formOptions['data'] = $trimestre;
        }

        $form->add('trimestre', 'entity', $formOptions);
    }

    public function preSetData(FormEvent $event) {
        $data = $event->getData();
        $form = $event->getForm();

        if (null === $data) {
            return;
        }

        $accessor = PropertyAccess::getPropertyAccessor();

        $trimestre = $accessor->getValue($data, 'trimestre');
        $ejercicio = ($trimestre) ? $trimestre->getEjercicio() : null;


        $this->addTrimestreForm($form, $ejercicio);
    }

    public function preSubmit(FormEvent $event) {
        $data = $event->getData();
        $form = $event->getForm();

        $this->addTrimestreForm($form);
    }

}
