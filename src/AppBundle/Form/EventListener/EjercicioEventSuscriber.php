<?php

namespace AppBundle\Form\EventListener;

use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\PropertyAccess\PropertyAccess;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class EjercicioEventSuscriber implements EventSubscriberInterface
{
 
    public static function getSubscribedEvents()
    {
        return array(
            FormEvents::PRE_SET_DATA => 'preSetData',
            FormEvents::PRE_SUBMIT   => 'preSubmit'
        );
    }

    private function addEjercicioForm($form)
    {
        $formOptions = array(
            'class'         => 'AppBundle:Ejercicio',
            'mapped'        => false,
            'label'         => 'País',
            'empty_value'   => 'País',
            'attr'          => array(
                'class' => 'ejercicio_selector',
            ),
        );

        if ($ejercicio) {
            $formOptions['data'] = $ejercicio;
        }

        $form->add('ejercicio2', 'entity', $formOptions);
    }

    public function preSetData(FormEvent $event)
    {
        $data = $event->getData();
        $form = $event->getForm();

        if (null === $data) {
            return;
        }

        $accessor = PropertyAccess::getPropertyAccessor();

        $this->addEjercicioForm($form);
    }

    public function preSubmit(FormEvent $event)
    {
        $form = $event->getForm();

        $this->addEjercicioForm($form);
    }
}
