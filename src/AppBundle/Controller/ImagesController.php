<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\Tools\Pagination\Paginator;

use AppBundle\Entity\Image;
use AppBundle\Form\ImageForm;


class ImagesController extends Controller
{
    /**
     * @Route("/", name="create")
     */
    public function createAction(Request $request)
    {

        $image = new Image();
        $form = $this->createForm(ImageForm::class, $image, array('attr' => array('novalidate' => 'novalidate')));
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $fileName = $this->__get_and_move_file($image);

            $image->setFile($fileName);
            $image->setUniqueId($fileName);

            $em = $this->getDoctrine()->getManager();
            $em->persist($image);
            $em->flush();

            return $this->redirect('list');
        }
        return $this->render(
            'images/new.html.twig', array(
                'form' => $form->createView(),
            )
        );

    }

    /**
     * @Route("/list", name="list")
     */
    public function listAction(Request $request)
    {
        $repository = $this->getDoctrine()->getRepository('AppBundle:Image');
        $limit = 5;

        $query = $repository->createQueryBuilder('image')
            ->orderBy('image.id', 'DESC')
            ->getQuery();

        $paginator  = $this->get('knp_paginator');
        $images = $paginator->paginate(
            $query,
            $request->query->getInt('page', 1),
            $limit
        );
        return $this->render('images/list.html.twig', compact('images'));
    }

    private function __get_and_move_file($image)
    {
        $file = $image->getFile();

        // Generate a unique name for the file before saving it
        $fileName = md5(uniqid()).'.'.$file->guessExtension();

        // Move the file to the directory where images are stored
        $file->move(
            $this->container->getParameter('images_directory'),
            $fileName
        );

        return $fileName;
    }

    private function __paginate($dql, $page = 1, $limit = 5)
    {
        $paginator = new Paginator($dql);

        $paginator->getQuery()
            ->setFirstResult($limit * ($page - 1)) // Offset
            ->setMaxResults($limit); // Limit

        return $paginator;
    }
}
