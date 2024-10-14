<?php

namespace Api\Controller;

use Api\Repository\ProductsRepository;
use PDO;
use Api\Repository\DB;
use Exception;

class HomeController
{
    /** 
     * @var PDO
     */
    private PDO $db;

    public function __construct() {
        $this->db = DB::getInstance()->getConnection();
    }

    /**
     * Home index action handler.
     *
     * @param HTTPRequest $request
     * @return void
     */
    public function index(HTTPRequest $request): void
    {
        try {
            $repository = new ProductsRepository($this->db);
            $results = $repository->getAll();
            
            $response = [
                "code" => 200,
                "status" => "success",
                "message" => "",
                "data" => $results
            ];            
        } catch (Exception $e) {
            $response = [
                "code" => 500,
                "status" => "error",
                "message" => $e->getMessage(),
                "data" => []
            ];
        } finally {
            header("Content-Type: application/json; charset=UTF-8");

            echo json_encode($response);
        }
    }
}