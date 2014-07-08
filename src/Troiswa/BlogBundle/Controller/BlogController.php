<?php
namespace Troiswa\BlogBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Troiswa\BlogBundle\Entity;

class BlogController extends Controller
{


    public function displayPostsAction()
    {
       // $articles = $this->getDoctrine()->getRepository('TroiswaBlogBundle:Article')->findAll();

         $articles = $this->getDoctrine()->getRepository('TroiswaBlogBundle:Article')->findAllByDateDesc();

         $nbArticles = $this->getDoctrine()->getRepository('TroiswaBlogBundle:Article')->countArticles();

       	return $this->render('TroiswaBlogBundle:Default:blog.html.twig',
            array('articles' => $articles,
                  'nbArticles' => $nbArticles
                    ));


    }

    public function displayBlogPhareAction()
    {
        // $articles = $this->getDoctrine()->getRepository('TroiswaBlogBundle:Article')->findAll();

        $articlesPhares = $this->getDoctrine()->getRepository('TroiswaBlogBundle:Article')->findPhareArticles();



        return $this->render('TroiswaBlogBundle:Default:blogPhares.html.twig',
            array(
                'articlesPhares' => $articlesPhares
            ));


    }
}


