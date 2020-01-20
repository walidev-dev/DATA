<?php

namespace OC\PlatformeBundle\Controller;

use OC\PlatformeBundle\Form\ListAdvertsType;
use SoapClient;
use OC\PlatformeBundle\Antispam\OCAntispam;
use OC\PlatformeBundle\Beta\BetaHTMLAdder;
use OC\PlatformeBundle\Beta\BetaListener;
use OC\PlatformeBundle\Email\ApplicationMailer;
use OC\PlatformeBundle\Entity\Advert;
use OC\PlatformeBundle\Entity\Application;
use OC\PlatformeBundle\Event\MessagePostEvent;
use OC\PlatformeBundle\Event\PlatformEvents;
use OC\PlatformeBundle\Form\AdvertEditType;
use OC\PlatformeBundle\Form\AdvertType;
use Swift_Mailer;
use Symfony\Component\Finder\Exception\AccessDeniedException;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Validator\Constraints\DateTime;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

class AdvertController extends Controller
{

    public function purgeAction($days)
    {


        return new  Response("");
    }

    public function indexAction($page)
    {
        if ($page < 1) {
            throw $this->createNotFoundException('page ' . $page . ' inexistante');
        }
        $nbPerPage = 3;
        $listAdverts = $this->getDoctrine()
            ->getManager()
            ->getRepository("OCPlatformeBundle:Advert")
            ->getAdverts($page, $nbPerPage);
        $nbPages = ceil(count($listAdverts) / $nbPerPage);
        if ($page > $nbPages) {
            throw $this->createNotFoundException("La page " . $page . " n'existe pas");
        }
        return $this->render('OCPlatformeBundle:Advert:index.html.twig', [
                'page' => $page,
                'listAdverts' => $listAdverts,
                'nbPages' => $nbPages
            ]
        );
    }

    public function viewAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $repository = $em->getRepository("OCPlatformeBundle:Advert");
        $advert = $repository->find($id);
        if ($advert === null) {
            throw new NotFoundHttpException("L'annonce d'id " . $id . "n'existe pas");
        }

        $listApplications = $em
            ->getRepository("OCPlatformeBundle:Application")
            ->findBy(['advert' => $advert]);

        $listAdvertSkills = $em
            ->getRepository("OCPlatformeBundle:AdvertSkill")
            ->findBy(['advert' => $advert]);

        return $this->render('OCPlatformeBundle:Advert:view.html.twig', [
                'advert' => $advert,
                'listeApplications' => $listApplications,
                'listAdvertSkill' => $listAdvertSkills
            ]
        );
    }
    //    /**
//     * @Security("has_role('ROLE_ADMIN')")
//     */
    public function addAction(Request $request)
    {
        if (!$this->get('security.authorization_checker')
            ->isGranted('ROLE_ADMIN')) {
            throw new AccessDeniedException("accés limité seulement à l'administrateur du site");
        }
        /**
         * RÉCUPERER L'UTILISATEUR COURANT
         */
        $token = $this->container->get('security.token_storage')->getToken();
        //$token=$this->get('security.token_storage')->getToken();
        $user = $token->getUser();
        $advert = new Advert();
        /**
         * RENSEIGNER L'UTILISATEUR CONNÉCTÉ DANS L'OBJET ADVERT
         */
        $advert->setUser($user);
        /**
         * PERMET DE PRE-REMPLIR LES CHAMPS DEPUIS L'OBJET $advert
         */
        $form = $this->createForm(AdvertType::class, $advert);
        // $form=$this->get('form.factory')->create(AdvertType::class,$advert);
        /**
         * TRAITEMENT DE LA REQUETE
         */

        if ($request->isMethod("POST")) {
            /*
             * PERMET D'AFFECTER LES VALEURS SOUMISES DU FORMULAIRE A L'OBJET $advert
             */
            $form->handleRequest($request);
            if ($form->isSubmitted() && $form->isValid()) {
                //$advert->getImage()->upload();

                /**
                 * CRÉATION ET DÉCLENCHEMENT DE L'EVENEMENT POST MESSAGE (MessagePostEvent)
                 */
                $event = new MessagePostEvent($advert->getContent(), $advert->getUser());
                $this->get('event_dispatcher')->dispatch(PlatformEvents::POST_MESSAGE, $event);
                $advert->setContent($event->getMessage());

                $em = $this->getDoctrine()->getManager();
                $em->persist($advert);
                $em->flush();
                $this->addFlash('success', 'Annonce ajoutée avec succés');
                return $this->redirectToRoute('oc_platform_home');
            } else {
                $validator = $this->get('validator');
                $listErrors = $validator->validate($advert);
                return $this->render("OCPlatformeBundle:Advert:add.html.twig", [
                        'form' => $form->createView(),
                        'listErrors' => $listErrors
                    ]
                );
            }
        }

        return $this->render("OCPlatformeBundle:Advert:add.html.twig", [
                'form' => $form->createView()
            ]
        );
    }

    public function editAction($id, Request $request)
    {
        /**
         * Récuperer l'annonce liée à l'id
         */
        // $title=$request->request->get("title");
        $em = $this->getDoctrine()->getManager();
        $advert = $em->getRepository("OCPlatformeBundle:Advert")->find($id);
        $form = $this->createForm(AdvertEditType::class, $advert);

        if ($request->isMethod('POST')) {
            $form->handleRequest($request);
            if ($form->isSubmitted() && $form->isValid()) {
                $em->flush();
                $this->addFlash('success', 'Annonce modifiée avec succés');
                return $this->RedirectToRoute('oc_platform_view', ['id' => $advert->getId()]);
            }
        }
        return $this->render('OCPlatformeBundle:Advert:edit.html.twig', [
                'form' => $form->createView(), 'advert' => $advert
            ]
        );
    }

    public function deleteAction($id, Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $advert = $em->getRepository("OCPlatformeBundle:Advert")->find($id);
        if ($advert === null) {
            throw new NotFoundHttpException("L'annonce d'id " . $id . " n'existe pas");
        }
        $form = $this->get('form.factory')->create();
        if ($request->isMethod("POST")) {
            $form->handleRequest($request);
            if ($form->isSubmitted() && $form->isValid()) {
                /**
                 * SUPPRIMER LES APPLICATIONS LIÉES
                 * SI ON N'A PAS MIS cascade={"remove"} DANS L'ENTITÉ ADVERT
                 */
//                foreach ($advert->getApplications() as $application){
//                    $em->remove($application);
//                }
                /**
                 * SUPPRIMER L'ADVERT
                 */
                $em->remove($advert);
                $em->flush();
                $this->addFlash("success", "L'annonce a été supprimée avec succés");
                return $this->redirectToRoute('oc_platform_home');
            }
        }


        return $this->render("OCPlatformeBundle:Advert:delete.html.twig", [
                'form' => $form->createView(), 'advert' => $advert
            ]
        );

    }

    public function menuAction($limit)
    {
        /*
         * création des 3 dérniéres annonces
         */
        $em = $this->getDoctrine()->getManager();
        $repository = $em->getRepository("OCPlatformeBundle:Advert");
        $adverts = $repository->findBy(
            [],
            ['date' => 'DESC'],
            $limit,
            0
        );
        return $this->render("OCPlatformeBundle:Advert:menu.html.twig", ['adverts' => $adverts]);
    }

    public function showAction()
    {
//       $em=$this->getDoctrine();
//       $repository=$em->getRepository("OCPlatformeBundle:Advert");
//       $advert=$repository->find(3);
//        $advert=$this->getDoctrine()
//            ->getRepository("OCPlatformeBundle:Advert")
//            ->find(3);

//        $query=$repository->createQueryBuilder('a')
//            ->select('a')
//            ->getQuery();
//        $adverts=$query->getResult();
        $repository = $this->getDoctrine()->getRepository("OCPlatformeBundle:Advert");
        //$advert=$repository->myFindOne(7);
        $adverts = $repository->getAdvertWithCategories(['Développeur', 'Intégrateur']);

        return $this->render("OCPlatformeBundle:Advert:show.html.twig", ['adverts' => $adverts]);
    }

    public function testAction()
    {
//        $advert_id=2;
//        $limit=2;
//        $repository=$this->getDoctrine()->getRepository("OCPlatformeBundle:Application");
//        $advert=$repository->getApplicationsWithAdvert($limit,$advert_id);

        /**
         * La liste des candidatures pour une annonce donnée
         */

//        $em=$this->getDoctrine()->getManager();
//        $repository=$em->getRepository("OCPlatformeBundle:Advert");
//        $advert_id=5;
//        $advert=$repository->find($advert_id);
//        $applications=$em
//            ->getRepository("OCPlatformeBundle:Application")
//            ->findBy(['advert'=>$advert]);
//
//        $em=$this->getDoctrine()->getManager();
//        $advert=$em
//            ->getRepository("OCPlatformeBundle:Advert")
//            ->find(42);
//        $applications=$advert->getApplications();
//        foreach ($applications as $app){
//            dump($app);
//        }
        //die();

        /**
         * CALCULER LE NOMBRE D'APPLICATIONS SELON UN ID ADVERT
         */

//        $em=$this->getDoctrine()->getManager();
//        $qb=$em->createQueryBuilder();
//        $qb->select('count(application.id)');
//        $qb->from('OCPlatformeBundle:Application','application');
//        $qb->where('application.advert =:advert_id');
//        $qb->setParameter('advert_id',31);
//        $count=$qb->getQuery()->getSingleScalarResult();
//        var_dump($count);
//        die();

//        $em=$this->getDoctrine()->getManager();
//        $repository=$em->getRepository("OCPlatformeBundle:Application");
//        $count=$repository->getNbApplicationsByAdvert(42);
//        dump($count);

        $obj = $this->get('oc_platform.antispam');
        dump($obj);
        $currentDate=new \DateTime();
        $diffDays = $currentDate->diff(new \DateTime('2018-02-20'))->days;
        $diffMinutes = $diffDays * 24 * 60;
        $diffSecondes = $diffMinutes * 60;
        dump("diff en Jours : " . $diffDays . " jours // diff en Minutes : "
            . $diffMinutes . " // diff en Secondes : " . $diffSecondes);

//       $webmaster=$this->container->getParameter("webmaster");
//       dump($webmaster);
        die();

    }

    public function applicationsByAdvertAction(Request $request)
    {
        $form = $this->createForm(ListAdvertsType::class);
        if ($request->isXmlHttpRequest()) {

            $advert_id = $request->request->get('advert_id');
            $repository = $this->getDoctrine()->getRepository('OCPlatformeBundle:Application');
            $applications = $repository->getApplicationsByAdvert($advert_id);
            return $this->render('OCPlatformeBundle:Advert:applications_by_advert.html.twig', [
                    'applications' => $applications
                ]
            );
        }
        return $this->render('OCPlatformeBundle:Advert:list_adverts.html.twig', [
            'form' => $form->createView()
        ]);
    }
}