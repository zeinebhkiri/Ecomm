<?php

namespace App\Controller;

use App\Entity\Produit;
use App\Form\AjoutVoitureType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Persistence\ManagerRegistry;
final class GestionVoitureController extends AbstractController
{
    #[Route('/produits', name: 'app_liste_produits')]
public function listeProduits(ManagerRegistry $doctrine): Response
{
    $produits = $doctrine->getRepository(Produit::class)->findAll();

    return $this->render('gestion_voiture/liste.html.twig', [
        'produits' => $produits
    ]);
}

    #[Route('/gestion/voiture', name: 'app_gestion_voiture')]
public function ajoutervoiture(Request $request, ManagerRegistry $doctrine)
{
$voiture = new Produit();
$form = $this->createForm(AjoutVoitureType::class, $voiture);
$form->handleRequest($request);
if ($form->isSubmitted() && $form->isValid()) {
$em = $doctrine->getManager();
$em->persist($voiture);
$em->flush();
return $this->redirectToRoute('app_liste_produits');
}
return $this->render('gestion_voiture/new.html.twig', [
'formvoiture' => $form->createView()
]);
}


#[Route('/gestion/voiture/{id}', name: 'app_update_voiture')]
public function updatevoiture(Request $request, ManagerRegistry $doctrine,Produit $voiture)
{

$form = $this->createForm(AjoutVoitureType::class, $voiture);
$form->handleRequest($request);
if ($form->isSubmitted() && $form->isValid()) {
$em = $doctrine->getManager();
$em->persist($voiture);
$em->flush();
return $this->redirectToRoute('app_liste_produits');
}
return $this->render('gestion_voiture/upd.html.twig', [
'formvoiture' => $form->createView()
]);
}
#[Route('/delete/voiture/{id}', name: 'app_delete_voiture')]
public function deletevoiture(Request $request, ManagerRegistry $doctrine,Produit $voiture)
{
     $em=$doctrine->getManager();
     $em->remove($voiture);
     $em->flush();
    return $this->redirectToRoute('app_liste_produits');
}
/*
#[Route('/produit/{id}', name: 'app_produit')]  
public function produit(ManagerRegistry $doctrine, Produit $produit): Response
{
    return $this->render('gestion_voiture/produit.html.twig', [
        'produit' => $produit,
    ]);
}*/
#[Route('/rechercherbynom',name:'app_rechercherby')]
public function rechercherby(Request $request, ManagerRegistry $doctrine): Response
{
    $nom = $request->query->get('nom');
    $produits = $doctrine->getRepository(Produit::class)->findBy(['nom' => $nom]);

    return $this->render('gestion_voiture/liste.html.twig', [
        'produits' => $produits,
    ]);
}

#[Route('/produitid',name:'app_rechercheByid')]
public function rechercheProduitId(Request $request,ManagerRegistry $doctrine): Response
{
    $id = $request->query->get('id');
    $produit = $id ? $doctrine->getRepository(Produit::class)->find($id):null;

    return $this->render('gestion_voiture/liste.html.twig', [
        'produits' => $produit ? [$produit] : []
    ]);
}


}