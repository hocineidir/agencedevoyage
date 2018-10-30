<?php

namespace App\Controller;

use App\Entity\Circuit;
use App\Entity\ProgrammationCircuit;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;


class FrontofficeHomeController extends AbstractController
{
    /**
     * @Route("/home", name="frontoffice_home")
     */
    public function index()
    {
        $em = $this->getDoctrine()->getManager();
        $circuits=$em->getRepository(Circuit::class)->findAll();
        
        $circuitp = [];
        
        foreach ($em->getRepository(Circuit::class)->findAll() as $circuit){
            if (sizeof($circuit->getProgrammationCircuits())>0) {
                array_push($circuitp, $circuit);
            }
        }
        dump($circuitp);
        return $this->render('front/home.html.twig', [
            'circuitsp' => $circuitp,
            'circuits' => $circuits,
        ]);
    }
    /**
     * Finds and displays a circuit entity.
     *
     * @Route("/circuit/{id}", name="front_circuit_show")
     */
    public function circuitShow($id)
    {
        $em = $this->getDoctrine()->getManager();
        
        $circuit = $em->getRepository(Circuit::class)->find($id);
        
        if (sizeof($circuit->getProgrammationCircuits())==0){
            $circuit=null;
        }
        
        dump($circuit);
        
        return $this->render('front/circuit_show.html.twig', [
            'circuit' => $circuit,
        ]);
    }
    /**
     * Finds and save likes.
     *
     * @Route("/likes/{id}", name="likes")
     */
    public function Likeshow($id) {
        $em = $this->getDoctrine()->getManager();
        
        $circuit = $em->getRepository(Circuit::class)->find($id);
        
        $likes = $this->get('session')->get('likes');
        
        if (! in_array($id, $likes)) {
            $likes = $id;
        }
        else {
            $likes = array_diff($likes, array($id));
        }
        
        return $this->render('front/circuit_show.html.twig', [
            
        ]);
        
    }
        
    
    
    
    
    
    
    
}