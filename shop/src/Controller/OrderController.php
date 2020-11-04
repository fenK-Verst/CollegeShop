<?php


namespace App\Controller;

use App\Db\ObjectManager;
use App\Entity\Order;
use App\Entity\OrderItem;
use App\Http\Response;
use App\Repository\OrderRepository;
use App\Repository\ProductRepository;
use App\Service\CartService;
use App\Service\UserService;
use DateTime;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

/**
 * Class OrderController
 *
 * @Route("/orders")
 * @package App\Controller
 */
class OrderController extends AbstractController
{
    /**
     * @Route("/")
     *
     * @param OrderRepository $order_repository
     * @param UserService     $user_service
     *
     * @return Response
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     */
    public function index(OrderRepository $order_repository, UserService $user_service)
    {
        $user = $user_service->getCurrentUser();
        if (!$user) {
            return $this->redirect("/");
        }
        $orders = $order_repository->findBy([
            "user_id" => $user->getId()
        ]);
        $statuses = [
            Order::STATUS_WAITING => "Ожидание оплаты",
            Order::STATUS_ARCHIVED => "Готово",
            Order::STATUS_DONE => "Готово",
            Order::STATUS_PAID => "Оплачено",
        ];
        return $this->render("/order/list.html.twig", [
            "orders" => $orders,
            "statuses" => $statuses
        ]);
    }

    /**
     * @Route("/add")
     *
     * @param UserService       $user_service
     * @param CartService       $cart_service
     * @param ProductRepository $product_repository
     * @param ObjectManager     $object_manager
     *
     * @return Response
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     */
    public function add(
        UserService $user_service,
        CartService $cart_service,
        ProductRepository $product_repository,
        ObjectManager $object_manager
    ) {
        $error = '';
        $user = $user_service->getCurrentUser();
        if (!$user) {
            return $this->redirect("/");
        }
        $cart = $cart_service->getCart();
        if (empty($cart)) {
            return $this->redirect("/");
        }
        $order = new Order();

        $order->setUser($user);
        $now = new DateTime();
        $order->setCreatedAt($now);
        $order->setStatus(Order::STATUS_WAITING);
        /** @var Order $order */
        $order = $object_manager->save($order);

        foreach ($cart as $product_id => $item) {
            $product = $product_repository->find($product_id);
            if ($product) {
                if ($item["count"] > $product->getCount()) {
                    $error .= "Товара " . $product->getName() . " недостаточно на складе\n";
                    break;
                }
                $order_item = new OrderItem();
                $order_item->setCount($item["count"]);
                $order_item->setProduct($product);
                $order->addOrderItem($order_item);
                $order_item->setOrder($order);
            }
        }
        if (!$error) {
            $object_manager->save($order);
            $cart_service->clearCart();
            foreach ($cart as $product_id => $item) {
                $product = $product_repository->find($product_id);
                if ($product) {
                    $product->setCount($product->getCount() - $item["count"]);
                    $object_manager->save($product);
                }
            }
            return $this->redirect("/orders");

        } else {
            $object_manager->remove($order);
            $cart = $cart_service->getCart();
            $products = [];
            foreach ($cart as $id => $product) {
                $products[] = $product_repository->find($id);
            }

            return $this->render("cart/cart.html.twig", [
                "cart" => $cart,
                "products" => $products
            ]);

        }
    }
}