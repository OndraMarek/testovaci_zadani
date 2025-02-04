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
        $paginationData = $this->getPaginationData($request);
        $sortingData = $this->getSortingData($request);
        $filterData = $this->getFilterData($request);

        $paginator = $repository->findPaginatedSortedFiltered(
            $paginationData['offset'],
            $paginationData['limit'],
            $sortingData['sort'],
            $sortingData['order'],
            $filterData['filterField'],
            $filterData['filterValue']
        );

        return $this->render('product/index.html.twig', [
            'products' => $paginator,
            'currentPage' => $paginationData['page'],
            'totalPages' => ceil(count($paginator) / $paginationData['limit']),
            'sort' => $sortingData['sort'],
            'order' => $sortingData['order'],
            'filter_field' => $filterData['filterField'],
            'filter_value' => $filterData['filterValue'],
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
                'Produkt byl úspěšně upraven.'
            );

            return $this->redirectToRoute('product_index');
        }

        return $this->render('product/edit.html.twig', [
            'form' => $form,
        ]);
    }

    private function getPaginationData(Request $request): array
    {
        $page = max(1, $request->query->getInt('page', 1));
        $limit = 10;
        $offset = ($page - 1) * $limit;

        return [
            'page' => $page,
            'limit' => $limit,
            'offset' => $offset,
        ];
    }

    private function getSortingData(Request $request): array
    {
        $sort = $request->query->get('sort', 'name');
        $order = strtoupper($request->query->get('order', 'ASC')) === 'DESC' ? 'DESC' : 'ASC';

        return [
            'sort' => $sort,
            'order' => $order,
        ];
    }

    private function getFilterData(Request $request): array
    {
        $filterField = $request->query->get('filter_field', 'name');
        $filterValue = $request->query->get('filter_value', '');

        return [
            'filterField' => $filterField,
            'filterValue' => $filterValue,
        ];
    }
}
