<?php


namespace App\Controller;


use App\Db\ObjectManager;
use App\Entity\ProductComment;
use App\Http\Request;
use App\Repository\FolderRepository;
use App\Repository\ProductRepository;
use App\Repository\UserRepository;
use App\Repository\VendorRepository;

/**
 * Class ProductController
 *
 * @Route("/product")
 * @package App\Controller
 */
class ProductController extends AbstractController
{
    public static $LIMIT = 10;

    /**
     * @Route("/{id}", name="index")
     */
    public function index(
        ProductRepository $product_repository,
        FolderRepository $folder_repository,
        Request $request,
        UserRepository $user_repository,
        ObjectManager $object_manager
    ) {
        $product_id = $this->getRoute()->get("id");
        $product = $product_repository->find($product_id);
        $request_comment = $request->post("comment");
        $error = '';

        if ($product) {
            $folder = $product->getFolders()[0] ?? null;
            if ($folder)  $pagination_folders = $folder_repository->getParents($folder, true);


            if ($request_comment) {
                $comment = new ProductComment();
                $comment_text = $request_comment["value"];
                $comment_author = $request_comment["user_id"];
                $comment_rating = (float)$request_comment["rating"] ?? null;

                $author = $user_repository->find($comment_author);

                if (!$author) {
                    $error .= "Вы должны быть авторизованными, что бы оставлять комментарии";
                }
                if (!$comment_text) {
                    $error .= "Текст комментария не может быть пустым";
                }
                if (!$comment_rating) {
                    $error .= "Рейтинг товара не может быть пустым";
                }

                if (!$error) {
                    $comment->setProduct($product);
                    $comment->setValue($comment_text);
                    $comment->setUser($author);
                    $comment->setRating($comment_rating);
                    $object_manager->save($comment);
                }
            }
        }
        return $this->render("product/item.html.twig", [
            "product" => $product,
            "product_path" => $pagination_folders ?? null,
            "error"=>$error
        ]);
    }

    /**
     * @Route("/", name="index")
     */
    public function list(Request $request, ProductRepository $product_repository, VendorRepository $vendor_repository)
    {
        $filter = $request->get("filter") ?? [];
        $vendors = $vendor_repository->findAll();
        $page = $request->get("p") ?? 0;
        $limit = [$page * self::$LIMIT => self::$LIMIT];
        $product_count = (int)$product_repository->getFilteredCount($filter);
        $get = $request->getAll();
        unset($get["p"]);
        $query = http_build_query($get);
        $products = $product_repository->getFiltered($filter, $limit);
        $page_count = floor($product_count / self::$LIMIT);

        return $this->render("product/list.html.twig", [
            "products" => $products,
            "vendors" => $vendors,
            "filter" => $filter,
            "page" => $page,
            "page_count" => $page_count,
            "query" => $query,
            "current_page" => $page
        ]);
    }


}