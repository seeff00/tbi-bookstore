<?php
 
namespace Api\Controller;

use Api\Repository\ProductsRepository;
use PDO;
use Api\Repository\DB;
use Exception;

class CheckoutController
{
    /** 
     * @var PDO
     */
    private PDO $db;

    public function __construct() {
        $this->db = DB::getInstance()->getConnection();
    }

    /**
     * Checkout index action handler.
     *
     * @param HTTPRequest $request
     * @return void
     */
    public function index(HTTPRequest $request): void
    {
        $_SESSION["newsession"]=$value;
        // try {
        //     $repository = new ProductsRepository($this->db);
        //     $results = $repository->getAll();
            
        //     $response = [
        //         "code" => 200,
        //         "status" => "success",
        //         "message" => "",
        //         "data" => $results
        //     ];            
        // } catch (Exception $e) {
        //     $response = [
        //         "code" => 500,
        //         "status" => "error",
        //         "message" => $e->getMessage(),
        //         "data" => []
        //     ];
        // } finally {
        //     header("Content-Type: application/json; charset=UTF-8");

        //     echo json_encode($response);
        // }
    }

    /**
     * Checkout create action handler.
     *
     * @param HTTPRequest $request
     * @return void
     */
    public function create(HTTPRequest $request): void
    {

    }

    /**
     * Checkout delete action handler.
     *
     * @param HTTPRequest $request
     * @return void
     */
    public function delete(HTTPRequest $request): void
    {

    }

    /**
     * Checkout update action handler.
     *
     * @param HTTPRequest $request
     * @return void
     */
    public function update(HTTPRequest $request): void
    {

    }
}