<?php

namespace Troiswa\BlogBundle\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\SecurityContext;
use Troiswa\BlogBundle\Entity\User;
use Troiswa\BlogBundle\Form\UserType;

class SecurityController extends Controller
{
    public function loginAction(Request $request)
    {

        $session = $request->getSession();
// get the login error if there is one
        if ($request->attributes->has(SecurityContext::AUTHENTICATION_ERROR)) {
            $error = $request->attributes->get(SecurityContext::AUTHENTICATION_ERROR);
        } else {
            $error = $session->get(SecurityContext::AUTHENTICATION_ERROR);
            $session->remove(SecurityContext::AUTHENTICATION_ERROR);
        }
        return $this->render('TroiswaBlogBundle:Default:login.html.twig', array(
// last username entered by the user
            'last_username' => $session->get(SecurityContext::LAST_USERNAME),
            'error' => $error,
        ));
    }


    public function testAction()
    {
        return new Response('Je suis admin');
    }

    public

    function registerUserAction(Request $request)
    {
        $user = new User();
//
        //$user->getUsername('admin');
//        $factory = $this->get('security.encoder_factory');
//        $encoder = $factory->getEncoder($user);
//        $password = $encoder->encodePassword('admin', $user->getSalt());
//
        $formReg = $this->createForm(new UserType(), $user);


        if('POST' == $request->getMethod())
        {
            $formReg->handleRequest($request);
            if($formReg->isValid())
            {
                $factory = $this->get('security.encoder_factory');
                $encoder = $factory->getEncoder($user);
                $password = $encoder->encodePassword($user->getPassword(), $user->getSalt());
                $user->setPassword($password);
                $em = $this->getDoctrine()->getManager();
                $em->persist($user);
                $em->flush();

                $this->get('session')->getFlashBag()->add('notice', 'Nouvel user bien créé !!!!!!');
            }
        }



      return $this->render('TroiswaBlogBundle:Default:register.html.twig',
          array( 'formReg' => $formReg->createView())
      );

    }




}
