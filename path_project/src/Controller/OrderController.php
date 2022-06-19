<?php

namespace App\Controller;

use App\Repository\ProductRepository;
use App\Service\OrderService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/api/order", name="app_order")
 */
class OrderController extends AbstractController
{
    /**
     * @Route("/", name="app_order_index", methods={"GET"})
     */
    public function listOrders(OrderService $orderService): JsonResponse
    {
        $user = $this->getUser();
        $data = $orderService->listOrders($user);

        return $this->json($data);
    }

    /**
     * @Route ("/new", name="order_new", methods={"POST"})
     */
    public function newOrder(Request $request, OrderService $orderService): JsonResponse
    {
        $user = $this->getUser();

        $orderService->newOrder($request, $user);

        return $this->json("Order created succesfully");
    }

    /**
     * @Route ("/show/{id}", name="order_show", methods={"GET"})
     */
    public function showOrder($id, OrderService $orderService): JsonResponse
    {
        $user = $this->getUser();
        $data = $orderService->showOrder($id, $user);

        return $this->json($data);
    }

    /**
     * @Route ("/edit/{id}", name="order_edit", methods={"POST"})
     */
    public function editOrder($id, OrderService $orderService): JsonResponse
    {
        $this->getUser();
        $canEdit = $orderService->editOrder(new Request(), $id);

        return $canEdit ?
            $this->json("Order updated succesfully") :
            $this->json("Order didn't updated.")  ;
    }
}
