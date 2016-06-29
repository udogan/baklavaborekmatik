<?php
namespace BaklavaBorekBundle\Controller;

use BaklavaBorekBundle\Entity\Product;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;


/**
 * Class ProductController
 *
 * @package BaklavaBorekBundle\Controller
 * @Route("/product")
 */
class ProductController extends Controller
{
	/**
	 * @Route("/", name="BaklavaBorekBundle_Product_index")
	 */
	public function indexAction()
	{
		$em = $this->getDoctrine()->getManager();
		$repository = $em->getRepository("BaklavaBorekBundle:Product");
		$products = $repository->findAll();
		return $this->render('BaklavaBorekBundle:Product:index.html.twig', array(
				"products" => $products
		));
	}

	/**
	 * @Route("/create", name="BaklavaBorekBundle_Product_create")
	 */
	public function createAction(Request $request)
	{
		$product = new Product();
		$form = $this->createForm('BaklavaBorekBundle\Form\ProductType', $product);

		$form->handleRequest($request);
		if ($form->isSubmitted() && $form->isValid()) {
			$em = $this->getDoctrine()->getManager();
			$em->persist($product);
			$em->flush();
			return $this->redirect($this->generateUrl("BaklavaBorekBundle_Product_index"));
		}

		return $this->render('BaklavaBorekBundle:Product:create.html.twig', array(
				"form" => $form->createView()
		));
	}

	/**
	 * @Route("/edit/{productId}", name="BaklavaBorekBundle_Product_edit")
	 */
	public function editAction(Request $request, $productId)
	{
		$translator = $this->get('translator');
		$em = $this->getDoctrine()->getManager();
		$repository = $em->getRepository("BaklavaBorekBundle:Product");
		$product = $repository->findOneBy(array("id" => $productId));

		if (!$product) {
			throw $this->createNotFoundException($translator->trans("Product Not Found With Id %id%", array("%id%" => $productId)));
		}

		$form = $this->createForm('BaklavaBorekBundle\Form\ProductType', $product);

		$form->handleRequest($request);
		if ($form->isSubmitted() && $form->isValid()) {
			$em = $this->getDoctrine()->getManager();
			$em->persist($product);
			$em->flush();
			return $this->redirect($this->generateUrl("BaklavaBorekBundle_Product_index"));
		}

		return $this->render('BaklavaBorekBundle:Product:edit.html.twig', array(
				"form" => $form->createView()
		));
	}

	/**
	 * @Route("/delete/{productId}", name="BaklavaBorekBundle_Product_delete")
	 */
	public function deleteAction(Request $request, $productId)
	{
		$translator = $this->get('translator');
		$em = $this->getDoctrine()->getManager();
		$repository = $em->getRepository("BaklavaBorekBundle:Product");
		$product = $repository->findOneBy(array("id" => $productId));

		if (!$product) {
			throw $this->createNotFoundException($translator->trans("Product Not Found With Id %id%", array("%id%" => $productId)));
		}

		$form = $this->createFormBuilder(array('productId' => $productId))
		->add('productId', 'hidden')
		->getForm();

		$form->handleRequest($request);
		if ($form->isSubmitted() && $form->isValid()) {
			$em = $this->getDoctrine()->getManager();
			$em->remove($product);
			$em->flush();
			return $this->redirect($this->generateUrl("BaklavaBorekBundle_Product_index"));
		}

		return $this->render('BaklavaBorekBundle:Product:delete.html.twig', array(
				"form" => $form->createView(),
				"product" => $product
		));
	}
}