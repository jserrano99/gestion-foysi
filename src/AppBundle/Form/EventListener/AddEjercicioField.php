
<?php


namespace AppBundle\Form\EventListener;

use Symfony\Component\Form\Form;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Form\FormFactoryInterface;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use BackendBundle\Entity\DbProvincia;

class AddEjercicioField implements EventSubscriberInterface
{
     private $factory;

    public function __construct(FormFactoryInterface $factory) {
        $this->factory = $factory;
    }
    public static function getSubscribedEvents() {
        return array(
            FormEvents::PRE_SET_DATA => 'preSetData',
            FormEvents::PRE_SUBMIT     => 'preSubmit'
        );
    }
	
    private function addEjercicioForm($form, $ejercicio) {

       $form -> add('ejercicio', EntityType::class, array(
            'class'         => 'AppBundle:Ejercicio',
            'label'         => 'Ejercicio',
            'placeholder'   => 'Seleccionar Ejercicio ...',
            'auto_initialize' => false,
            'mapped'        => false,
            'attr'=> array('class' => 'form-control medio'),
            'query_builder' => function (EntityRepository $repository) {
                $qb = $repository->createQueryBuilder('ejercicio');
                return $qb;
            }
        ));
    }
	
    public function preSetData(FormEvent $event){
        $data = $event->getData();
        $form = $event->getForm();

        if (null === $data) {return;}
    }
	
    public function preSubmit(FormEvent $event) {
        $data = $event->getData();
        $form = $event->getForm();

        if (null === $data) { return;}
    }
}