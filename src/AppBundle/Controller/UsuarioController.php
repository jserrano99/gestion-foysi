<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;
use AppBundle\Entity\Usuario;
use AppBundle\Entity\cambioPassword;
use AppBundle\Entity\Conexion;
use AppBundle\Form\cambioPasswordType;
use AppBundle\Form\UsuarioType;


class UsuarioController extends Controller {

    private $sesion;

    public function __construct() {
        $this->sesion = new Session();
    }

    public function loginAction(Request $request) {
        $em = $this->getDoctrine()->getManager();
        $Usuario_Repo = $em->getRepository("AppBundle:Usuario");
        $authenticationUtils = $this->get("security.authentication_utils");
        $error = $authenticationUtils->getLastAuthenticationError();
        $lastUsername = $authenticationUtils->getLastUsername();
        $ServicioLog = $this->get('app.escribelog');
        $ServicioLog->setLogger('Acceso');
        $ultimaConexion = null;
        $Usuario = null;
        if ($error) {
            $this->sesion->getFlashBag()->add("status", "Usuario " . " " . $lastUsername . " no autorizado, revise la contraseña");
            $ServicioLog->setMensaje('Error en Inicio de Sesión: ' . $lastUsername . ' ' . $error);
            $ServicioLog->escribeLog();
        } else {
            $Usuario = $this->getUser();
            if ($Usuario) {
                $ultimaConexion = $this->logConexion($Usuario);
                $ServicioLog->setMensaje('Inicio de Sesión: ' . $Usuario);
                $ServicioLog->escribeLog();
                if ($Usuario->getEstadoUsuario()->getId() == 2) {
                    return $this->render("usuario/bloqueado.html.twig");
                }
            }
        }
        return $this->render("usuario/login.html.twig", array(
                    "error" => $error,
                    "last_username" => $lastUsername,
                    "Usuario" => $Usuario,
                    "Conexion" => $ultimaConexion
        ));
    }

    public function queryAction() {
        $EntityManager = $this->getDoctrine()->getManager();
        $Usuario_repo = $EntityManager->getRepository("AppBundle:Usuario");
        $UsuarioAll = $Usuario_repo->findAll();

        return $this->render('usuario/query.html.twig', array(
                    "UsuarioAll" => $UsuarioAll
        ));
    }

    public function editAction(Request $request, $id) {
        $EntityManager = $this->getDoctrine()->getManager();
        $Usuario_repo = $EntityManager->getRepository("AppBundle:Usuario");
        $Usuario = $Usuario_repo->find($id);

        $UsuarioForm = $this->createForm(UsuarioType::class, $Usuario);
        $UsuarioForm->handleRequest($request);

        if ($UsuarioForm->isSubmitted()) {
            $Usuario->setCodigo($UsuarioForm->get('codigo')->getData());
            $Usuario->setNombre($UsuarioForm->get('nombre')->getData());
            $Usuario->setApellidos($UsuarioForm->get('apellidos')->getData());
            $Usuario->setEmail($UsuarioForm->get('email')->getData());
            $Usuario->setEstadoUsuario($UsuarioForm->get('estadoUsuario')->getData());
            $Usuario->setPerfil($UsuarioForm->get('perfil')->getData());

            $EntityManager->persist($Usuario);
            $flush = $EntityManager->flush();
            if ($flush == null) {
                $status = 'Usuario Modificado Correctamente';
            } else {
                $status = 'Error en Modificación';
            }
            $this->sesion->getFlashBag()->add("status", $status);
            return $this->redirectToRoute("queryUsuario");
        }

        return $this->render("usuario/update.html.twig", array(
                    "form" => $UsuarioForm->createView(),
                    "usuario" => $Usuario
        ));
    }

    public function addAction(Request $request) {
        $EntityManager = $this->getDoctrine()->getManager();
        $Usuario_repo = $EntityManager->getRepository("AppBundle:Usuario");

        $Usuario = new Usuario();
        $UsuarioForm = $this->createForm(UsuarioType::class, $Usuario);
        $UsuarioForm->handleRequest($request);

        if ($UsuarioForm->isSubmitted()) {
            $Usuario = $Usuario_repo->findOneBy(array("codigo" => $UsuarioForm->get('codigo')->getData()));
            if (count($Usuario) == 0) {
                $newUsuario = new Usuario();
                $newUsuario->setCodigo($UsuarioForm->get('codigo')->getData());
                $newUsuario->setNombre($UsuarioForm->get('nombre')->getData());
                $newUsuario->setApellidos($UsuarioForm->get('apellidos')->getData());
                $newUsuario->setEmail($UsuarioForm->get('email')->getData());
                $newUsuario->setEstadoUsuario($UsuarioForm->get('estadoUsuario')->getData());
                $newUsuario->setPerfil($UsuarioForm->get('perfil')->getData());

                $factory = $this->get("security.encoder_factory");
                $encoder = $factory->getEncoder($newUsuario);
                $password = $encoder->encodePassword('cambiala', $newUsuario->getSalt());
                $newUsuario->setPassword($password);

                $EntityManager->persist($newUsuario);
                $flush = $EntityManager->flush();
                if ($flush == null) {
                    $status = 'Usuario Creado Correctamente';
                } else {
                    $status = 'Errorr en Modificación';
                }
                $this->sesion->getFlashBag()->add("status", $status);
                return $this->redirectToRoute("queryUsuario");
            } else {
                $status = " CÓDIGO DE USUARIO YA EXISTENTE ";
                $this->sesion->getFlashBag()->add("status", $status);
            }
        }

        return $this->render("usuario/insert.html.twig", array(
                    "form" => $UsuarioForm->createView()
        ));
    }

    public function deleteAction($id) {
        $EntityManager = $this->getDoctrine()->getManager();
        $Usuario_repo = $EntityManager->getRepository("AppBundle:Usuario");
        $Usuario = $Usuario_repo->find($id);

        $EntityManager->remove($Usuario);
        $EntityManager->flush();

        $status = " USUARIO ELIMINADO CORRECTAMENTE ";
        $this->sesion->getFlashBag()->add("status", $status);
        return $this->redirectToRoute("queryUsuario");
    }

    public function cambioPasswordAction(Request $request, $id) {
        $EntityManager = $this->getDoctrine()->getManager();
        $Usuario_repo = $EntityManager->getRepository("AppBundle:Usuario");
        $Usuario = $Usuario_repo->find($id);

        $cambioPassword = new cambioPassword();
        $Form = $this->createForm(cambioPasswordType::class, $cambioPassword);
        $Form->handleRequest($request);

        if ($Form->isSubmitted()) {
            if ($Form->isValid()) {
                $newPass = new cambioPassword();
                $new = $Form->get('new')->getData();
                $new2 = $Form->get('new2')->getData();

                if ($new != $new2) {
                    $error = true;
                    $status = " La contraseña nueva y la repetición no coinciden ";
                    $this->sesion->getFlashBag()->add("status", $status);
                } else {
                    $factory = $this->get("security.encoder_factory");
                    $encoder = $factory->getEncoder($Usuario);

                    $new = $encoder->encodePassword($Form->get('new')->getData(), $Usuario->getSalt());
                    $Usuario->setPassword($new);
                    $EntityManager->persist($Usuario);
                    $EntityManager->flush();

                    return $this->redirectToRoute("login");
                }
            }
        }

        return $this->render("usuario/cambioPassword.html.twig", array(
                    "form" => $Form->createView()
        ));
    }

    public function logConexion($Usuario) {
        $em = $this->getDoctrine()->getManager();
        $Conexion = new Conexion();
        $fecha = new \DateTime();
        $fecha->setDate(date('Y'), date('m'), date('d'));

        $Conexion->setFecha($fecha);
        $Conexion->setDescripcion('Inicio Conexión');
        $Conexion->setUsuario($Usuario);
        $em->persist($Conexion);
        $em->flush();

        return $this->ultimaConexion($Usuario);
        ;
    }

    public function ultimaConexion($Usuario) {
        $em = $this->getDoctrine()->getManager();
        $Conexion_repo = $em->getRepository("AppBundle:Conexion");
        $Conexion = $Conexion_repo->createQueryBuilder('u')
                        ->where('u.usuario = :usuario')
                        ->setParameter('usuario', $Usuario)
                        ->orderBy('u.id', 'desc')
                        ->getQuery()->getResult();
        return $Conexion[0];
    }

}
