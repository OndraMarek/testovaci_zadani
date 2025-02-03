<?php

namespace App\Controller;

use App\Repository\ProductRepository;
use App\Entity\Product;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Form\ProductType;


final class ProductController extends AbstractController
{
    #[Route('/', name: 'product_index')]
    public function index(ProductRepository $repository, Request $request): Response
    {
        $page = max(1, $request->query->getInt('page', 1));
        $limit = 10;
        $offset = ($page - 1) * $limit;

        $sort = $request->query->get('sort', 'name');
        $order = strtoupper($request->query->get('order', 'ASC')) === 'DESC' ? 'DESC' : 'ASC';

        $filterField = $request->query->get('filter_field', 'name');
        $filterValue = $request->query->get('filter_value', '');

        $paginator = $repository->findPaginatedSortedFiltered($offset, $limit, $sort, $order, $filterField, $filterValue);

        return $this->render('product/index.html.twig', [
            'products' => $paginator,
            'currentPage' => $page,
            'totalPages' => ceil(count($paginator) / $limit),
            'sort' => $sort,
            'order' => $order,
            'filter_field' => $filterField,
            'filter_value' => $filterValue,
        ]);
    }


    #[Route('/{id<\d+>}/edit', name: 'product_edit')]
    public function edit(Product $product, Request $request, EntityManagerInterface $manager): Response
    {
        $form = $this->createForm(ProductType::class, $product);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $manager->flush();

            $this->addFlash(
                'notice',
                'Product updated successfully!'
            );

            return $this->redirectToRoute('product_index');
        }

        return $this->render('product/edit.html.twig', [
            'form' => $form,
        ]);
    }
}
