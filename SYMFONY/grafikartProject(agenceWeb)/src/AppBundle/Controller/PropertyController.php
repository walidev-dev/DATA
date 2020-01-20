<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Contact;
use AppBundle\Entity\Property;
use AppBundle\Entity\PropertySearch;
use AppBundle\Form\ContactType;
use AppBundle\Form\PropertySearchType;
use AppBundle\Notification\ContactNotification;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class PropertyController extends Controller
{
    public function indexAction(
        PaginatorInterface $paginator,
        Request $request
    ): Response
    {
        $search = new PropertySearch();
        $form = $this->createForm(PropertySearchType::class, $search);
        $form->handleRequest($request);
        $query = $this
            ->getDoctrine()
            ->getRepository(Property::class)
            ->findAllVisibleQuery($search);
        $properties = $paginator->paginate(
            $query,
            $request->query->getInt('page', 1),
            12
        );
        return $this->render('property/index.html.twig', [
            'current_menu' => 'properties',
            'properties' => $properties,
            'form' => $form->createView()
        ]);
    }

    public function showAction(string $slug, int $id, Request $request, ContactNotification $notification): Response
    {
        $property = $this->getDoctrine()->getRepository(Property::class)->findOne($id);
        if ($slug !== $property->getSlug()) {
            return $this->redirectToRoute('property_show',
                [
                    'slug' => $property->getSlug(),
                    'id' => $property->getId()
                ],
                301
            );
        }
        $contact = new Contact();
        $contact->setProperty($property);
        $form = $this->createForm(ContactType::class, $contact);
        if ($request->isMethod('POST')) {
            $form->handleRequest($request);
            if ($form->isValid()) {
                $notification->notify($contact);
                $this->addFlash('success', 'Votre email a bien été envoyé');
                return $this->redirectToRoute('property_show',
                    [
                        'slug' => $property->getSlug(),
                        'id' => $property->getId()
                    ]
                );
            }

        }
        return $this->render('property/show.html.twig', [
            'property' => $property,
            'form' => $form->createView()
        ]);
    }
}
