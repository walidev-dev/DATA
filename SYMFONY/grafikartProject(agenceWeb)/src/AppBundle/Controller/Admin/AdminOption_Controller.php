<?php

namespace AppBundle\Controller\Admin;

use AppBundle\Entity\Option_;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Option_ controller.
 *
 */
class AdminOption_Controller extends Controller
{
    /**
     * Lists all option_ entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $option_s = $em->getRepository('AppBundle:Option_')->findAll();

        return $this->render('admin/option_/index.html.twig', array(
            'option_s' => $option_s,
        ));
    }

    /**
     * Creates a new option_ entity.
     *
     */
    public function newAction(Request $request)
    {
        $option_ = new Option_();
        $form = $this->createForm('AppBundle\Form\Option_Type', $option_);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($option_);
            $em->flush();
            $this->addFlash('success','L\'option a été ajouté avec succés');
            return $this->redirectToRoute('admin_option_index', array('id' => $option_->getId()));
        }

        return $this->render('admin/option_/new.html.twig', array(
            'option_' => $option_,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a option_ entity.
     *
     */
    public function showAction(Option_ $option_)
    {
        $deleteForm = $this->createDeleteForm($option_);

        return $this->render('admin/option_/show.html.twig', array(
            'option_' => $option_,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing option_ entity.
     *
     */
    public function editAction(Request $request, Option_ $option_)
    {
        $deleteForm = $this->createDeleteForm($option_);
        $editForm = $this->createForm('AppBundle\Form\Option_Type', $option_);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();
            $this->addFlash('success','L\'option a été modifié avec succés');
            return $this->redirectToRoute('admin_option_index', array('id' => $option_->getId()));
        }

        return $this->render('admin/option_/edit.html.twig', array(
            'option_' => $option_,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a option_ entity.
     *
     */
    public function deleteAction(Request $request, Option_ $option_)
    {
        $form = $this->createDeleteForm($option_);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($option_);
            $em->flush();
            $this->addFlash('success','L\'option a été supprimé avec succés');
        }

        return $this->redirectToRoute('admin_option_index');
    }

    /**
     * @param Option_ $option_
     * @return \Symfony\Component\Form\FormInterface
     */
    private function createDeleteForm(Option_ $option_)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('admin_option_delete', array('id' => $option_->getId())))
            ->setMethod('DELETE')
            ->getForm();
    }
}
