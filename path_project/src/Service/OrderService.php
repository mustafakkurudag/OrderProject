<?php

namespace App\Service;

use App\Entity\Order;
use App\Repository\OrderRepository;
use App\Repository\ProductRepository;
use App\Repository\UserRepository;
use Symfony\Component\HttpFoundation\Request;

class OrderService
{
    private $orderRepository;
    private $productRepository;
    private $userRepository;

    public function __construct(OrderRepository   $orderRepository,
                                ProductRepository $productRepository,
                                UserRepository    $userRepository)
    {
        $this->orderRepository = $orderRepository;
        $this->productRepository = $productRepository;
        $this->userRepository = $userRepository;
    }

    public function listOrders($user): array
    {
        $orders = $this->orderRepository->findAll();

        $data = [];

        foreach ($orders as $order) {
            if ($order->getUser() === $user) {
                $data[] = [
                    'id' => $order->getId(),
                    'orderCode' => $order->getOrderCode(),
                    'productId' => $order->getProduct()->getId(),
                    'quantity' => $order->getQuantity(),
                    'address' => $order->getAddress(),
                    'shippingDate' => $order->getShippingDate()->format('d-m-Y'),
                    'userid' => $order->getUser()->getId(),
                ];
            }
        }

        return $data;
    }

    public function newOrder(Request $request, $user)
    {
        $data = json_decode($request->getContent(), true);

        $shippingDate = new \DateTime();
        $shippingDate->modify('+3 day')->format('d-m-Y - H:i:s');

        $product = $this->productRepository->find($data['product']);

        $order = new Order();
        $order
            ->setOrderCode($data['orderCode'])
            ->setProduct($product)
            ->setQuantity($data['quantity'])
            ->setAddress($data['address'])
            ->setShippingDate($shippingDate)
            ->setUser($user);

        $this->orderRepository->add($order, true);
    }

    public function showOrder($id, $user): array
    {
        $order = $this->orderRepository->find($id);
        $ordersUser = $order->getUser();

        $data = [];

        if ($user === $ordersUser) {
            $data = [
                'id' => $order->getId(),
                'orderCode' => $order->getOrderCode(),
                'productId' => $order->getProduct()->getId(),
                'quantity' => $order->getQuantity(),
                'address' => $order->getAddress(),
                'shippingDate' => $order->getShippingDate()->format('d-m-Y'),
                'userid' => $order->getUser()->getId(),
            ];
        }

        return $data;
    }

    public function editOrder(Request $request, $id): bool
    {
        $data = json_decode($request->getContent(), true);

        $order = $this->orderRepository->find($id);

        $today = new \DateTime();
        $today->format('d-m-Y');

        if($today >= $order->getShippingDate()) {
            return false;
        } else {
            $product = $this->productRepository->find($data['productid']);

            $order
                ->setProduct($product)
                ->setQuantity($data['quantity'])
                ->setAddress($data['address']);

            $this->orderRepository->update($order, true);

            return true;
        }
    }
}