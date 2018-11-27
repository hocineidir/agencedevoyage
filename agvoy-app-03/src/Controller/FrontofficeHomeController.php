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
        
        if ( $this->get('session')->has('likes') ) {
            $likes = $this->get('session')->get('likes');
        }
        else {
            $likes = [];
        }
        
        return $this->render('front/home.html.twig', [
            'circuitsp' => $circuitp,
            'circuits' => $circuits,
            'likes' => $likes
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
        
        if ( $this->get('session')->has('likes') ) {
            $likes = $this->get('session')->get('likes');
        }
        else {
            $likes = [];
        }
        
        return $this->render('front/circuit_show.html.twig', [
            'circuit' => $circuit,
            'likes' => $likes,
        ]);
    }
    /**
     * Finds and save likes.
     *
     * @Route("/circuit/likes/{id}", name="likes")
     */
    public function likeShow($id) {
        $em = $this->getDoctrine()->getManager();
        
        $circuit = $em->getRepository(Circuit::class)->find($id);
        
        if ( $this->get('session')->has('likes') ) {
            $likes = $this->get('session')->get('likes');
        }
        else {
            $likes = [];
        }
        
        if (! in_array($id, $likes)) {
            $likes[] = $id;
        }
        else {
            $likes = array_diff($likes, array($id));
        }
        
        $this->get('session')->set('likes', $likes);
        $this->get('session')->getFlashBag()->add('message', 'La liste des circuits favoris a été mise à jour');
        
        
        return $this->render('front/circuit_show.html.twig', [
            'circuit' => $circuit,
            'id' => $id, 
            'likes' => $likes]);
        
    }
        
    
    
    
    
    
    
    
}