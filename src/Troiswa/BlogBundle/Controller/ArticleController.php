<?php
namespace Troiswa\BlogBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Troiswa\BlogBundle\Entity\Article;
use Troiswa\BlogBundle\Entity\Comments;
use Troiswa\BlogBundle\Entity;
use Troiswa\BlogBundle\Form\ArticleType;
use Doctrine\Common\Util\Debug;


class ArticleController extends Controller
{

    public function createAction(Request $request)
    {

        $article = new Article();
        $article -> setDateCreation(new\DateTime('now'));
        //        valeur par default
//        $article->setAuteur('Manu');


//       $form = $this -> createFormBuilder($article)
//
//
//            ->add('titre','text')
//            ->add('auteur','text')
//            -> add('contenu','textarea')
//            -> add('cover', 'choice', array(
//                'choices'   => array (0 => 'simple', 1 => 'popular'),'expanded' => true, 'multiple'  => false, 'data' => 0 ))
//            -> add('submit','submit')
//            -> getForm();

//            ou en utilisant le terminial avec doctrine:generate:form TroiswaBLogBundle:Article
//        doctrine va creer tout seul un artcile Type.php et on pourra recuperer le form en faisant:


        $form = $this->createForm(new ArticleType(), $article);

    // prend les données de $_POST et les incorpore au formulaire:
        $form -> handleRequest($request);

        if($form -> isValid())
        {

            $em = $this -> getDoctrine() -> getManager();
            $em -> persist($article);
            $em -> flush();
            $this -> get('session') -> getFlashBag() -> add('notice','Your article has been created ');
        }
        else{
            $validator = $this->get('validator');
            $errors = $validator->validate($form);
            Debug::dump($errors);
        }

        $articles = $this -> getDoctrine() -> getRepository('TroiswaBlogBundle:Article') -> findAllByDateDesc();

        return $this->render('TroiswaBlogBundle:Default:admincreatearticle.html.twig', array('articles' => $articles, 'formArt' => $form -> createView()));
    }

    public function deleteAction($idarticle)
    {
        $article = $this->getDoctrine()->getRepository('TroiswaBlogBundle:Article')->findOne($idarticle);
        $em = $this -> getDoctrine() -> getManager();
        $em -> remove($article);
        $em -> flush();

        $this -> get('session') -> getFlashBag() -> add('notice',' article has been deleted ');
       return $this->redirect($this->generateUrl('troiswa_blog_blog'));
    }



    public function editAction($idarticle,Request $request)
    {
        $article = $this->getDoctrine()->getRepository('TroiswaBlogBundle:Article')->findOne($idarticle);



       $form = $this->createForm(new ArticleType(), $article);

        $form -> handleRequest($request);

        if($form -> isValid())
        {

            $em = $this -> getDoctrine() -> getManager();
            $em -> persist($article);
            $em -> flush();

            $this -> get('session') -> getFlashBag() -> add('notice','Your article has been modified ');
        }



        return $this->render('TroiswaBlogBundle:Default:admineditarticle.html.twig', array('formArt' => $form -> createView()));
    }



    public function displayAction($idarticle, Request $request)
    {
        //avec fonction magique native doctrine :

        //$thearticle = $this->getDoctrine()->getRepository('TroiswaBlogBundle:Article')->findOneById($idarticle);

        //avec la fonction crée par mes soins dans Article Repositery:
        $thearticle = $this->getDoctrine()->getRepository('TroiswaBlogBundle:Article')->findOne($idarticle);

        if ($thearticle == null)
        {
            throw $this->createNotFoundException('Artcile inexistant');
        }
        else
        {
            $comment = new Comments();
            $comment->setDateCreation(new \Datetime('now'));

            $form = $this->createFormBuilder($comment)
                ->add('auteur', 'text')
                ->add('contenu')
               ->add('note')
                ->add('valider', 'submit')
                ->getForm();







//            if('POST' == $request->getMethod())
//            {
//                $form->bind($request);
//
//                $validator =$this->get('validator');
//                $errors = $validator->validate($form);
//                       if(!empty($errors))
//                       {
//                            $em =$this->getDoctrine()->getManager();
//                            $comment->setArticle($thearticle);
//                           $thearticle->addComment($comment);
//                            $em->persist($thearticle);
//                           $em->persist($comment);
//                            $em->flush();
//
//                       }
//©
//            }


///mieux:

                $formCloned = clone $form;

                $form->handleRequest($request);

                    if ($form->isValid())
                    {

                        $em = $this->getDoctrine()->getManager();
                        //$comment->setArticle($thearticle);
                        $thearticle->addComment($comment);
                        //$em->persist($thearticle);
                        $em->persist($comment);
                        $em->flush();
                        $form = $formCloned;

                        $this->get('session')->getFlashBag()->add('notice','Votre commentaire a bien eté pris en compte !');

                    }



        return $this->render('TroiswaBlogBundle:Default:article.html.twig', array('thearticle' => $thearticle,
            'formComm' => $form->createView()));

        }
        }

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
    public function displayCategoryAction($id)
    {
        $articles = $this->getDoctrine()->getRepository('TroiswaBlogBundle:Category')->findArticlesbyCategory($id);
  Debug::dump($articles);
        return $this->render('TroiswaBlogBundle:Default:category.html.twig',
            array('articles' => $articles,

            ));
    }

}


