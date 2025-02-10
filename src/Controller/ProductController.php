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
use Symfony\Component\HttpFoundation\StreamedResponse;


final class ProductController extends AbstractController
{

    #[Route('/', name: 'product_index')]
    public function index(ProductRepository $repository, Request $request): Response
    {
        [$page, $limit, $offset] = $this->getPaginationParams($request);
        [$sort, $order] = $this->getSortingParams($request);
        [$filterField, $filterValue] = $this->getFilteringParams($request);

        $products = $repository->findPaginatedSortedFiltered(
            $offset,
            $limit,
            $sort,
            $order,
            $filterField,
            $filterValue
        );

        return $this->render('product/index.html.twig', [
            'products' => $products,
            'currentPage' => $page,
            'totalPages' => ceil(count($products) / $limit),
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
                'Produkt byl úspěšně upraven.'
            );

            return $this->redirectToRoute('product_index');
        }

        return $this->render('product/edit.html.twig', [
            'form' => $form,
        ]);
    }

    #[Route('/export/csv', name: 'product_export_csv')]
    public function exportCsv(ProductRepository $repository, Request $request): StreamedResponse
    {
        [$sort, $order] = $this->getSortingParams($request);
        [$filterField, $filterValue] = $this->getFilteringParams($request);

        $products = $repository->findSortedFiltered(
            $sort,
            $order,
            $filterField,
            $filterValue
        );

        $response = new StreamedResponse(function () use ($products): void {
            $this->generateCsvContent($products);
        });

        $response->headers->set('Content-Type', 'text/csv; charset=UTF-8');
        $response->headers->set('Content-Disposition', 'attachment; filename="products.csv"');

        return $response;
    }

    private function getPaginationParams(Request $request): array
    {
        $page = max(1, $request->query->getInt('page', 1));
        $limit = 10;
        $offset = ($page - 1) * $limit;

        return [$page, $limit, $offset];
    }

    private function getSortingParams(Request $request): array
    {
        $sort = $request->query->get('sort', 'name');
        $order = strtoupper($request->query->get('order', 'ASC')) === 'DESC' ? 'DESC' : 'ASC';

        return [$sort, $order];
    }

    private function getFilteringParams(Request $request): array
    {
        $filterField = $request->query->get('filter_field', 'name');
        $filterValue = $request->query->get('filter_value', '');

        return [$filterField, $filterValue];
    }

    private function generateCsvContent($products): void
    {
        $handle = fopen('php://output', 'w');

        fputcsv($handle, ['ID', 'Kód', 'Název', 'Cena', 'Značka', 'Materiál']);

        foreach ($products as $product) {
            fputcsv($handle, [
                $product->getId(),
                $product->getCode(),
                $product->getName(),
                $product->getPrice(),
                $product->getBrand()->getName(),
                $product->getMaterial()->getName(),
            ]);
        }

        fclose($handle);
    }
}
