<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

use AppBundle\Entity\Image;
use AppBundle\Form\Type\ImageType;


class ImagesController extends Controller
{
    /**
     * @Route("/", name="create")
     */
    public function createAction(Request $request)
    {

        $image = new Image();
        $form = $this->createForm(ImageType::class, $image);
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
     *
     * TODO: pagination
     * TODO: validation messages cusomization
     * TODO: fix email
     * TODO: make default page to new
     * TODO: check TYpe for forms
     */
    public function listAction(Request $request)
    {
        $images = $this->getDoctrine()
            ->getRepository('AppBundle:Image')
            ->findAll();

        return $this->render(
            'images/list.html.twig',
            array('images' => $images)
        );
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
}
