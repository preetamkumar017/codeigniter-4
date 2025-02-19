<?php

namespace App\Filters;

use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Config\Services;

use Predis\Client;

class AuthFilter implements FilterInterface

{
    public function before(RequestInterface $request, $arguments = null)
    {
        $redis = new Client([
            'scheme' => 'tcp',
            'host'   => '127.0.0.1',
            // 'host'   => '172.16.225.1',
            'port'   => 6379,
        ]);

        $key = getenv('encryption.key');
        $url = ltrim(str_replace(['index.php/', base_url()], '', current_url()), '/');

        if (strpos($request->getHeaderLine('User-Agent'), 'Mobile') !== false) {
            $authHeader = $request->getHeaderLine('Authorization');
            if (!$authHeader) {
                return service('response')->setJSON(['error' => 'Unauthorized'])->setStatusCode(401);
            }

            try {
                $token = explode(" ", $authHeader)[1];
                $decoded = JWT::decode($token, new Key($key, 'HS256'));

                $cacheKey = "user_{$decoded->user_id}_links";
                $retrievedValue = $redis->get($cacheKey);
                if ($retrievedValue) {
                    log_message('debug', 'Retrieved simple cached value: AuthFilter: ' . $retrievedValue);
                } else {
                    log_message('error', 'Failed to retrieve simple cached value for key: ' . $cacheKey);
                }
                
                $links = json_decode($redis->get($cacheKey), true);


                if (!in_array($url, $links ?? [])) {
                    return service('response')->setJSON(['error' => 'No Access'])->setStatusCode(403);
                }
            } catch (\Exception $e) {
                return service('response')->setJSON(['error' => 'Invalid Token'])->setStatusCode(401);
            }
        } else {
            if (!session()->get('logged_in')) {
                return redirect()->to('public/auth/login');
            }

            $userId = session()->get('user_id');
            $cacheKey = "user_{$userId}_links";
            // $cacheKey = "user_{$decoded->user_id}_links";
            $retrievedValue = $redis->get($cacheKey);
            if ($retrievedValue) {
                log_message('debug', 'Retrieved simple cached value: AuthFilter: ' . $retrievedValue);
            } else {
                log_message('error', 'Failed to retrieve simple cached value for key: ' . $cacheKey);
            }
            
            $allData = json_decode($redis->get($cacheKey), true);

            // if (!$links) {
            //     $roles = session()->get('roles');
            //     $links = $this->getUserLinks($roles);
            //     // $redis->setex($cacheKey, 600, json_encode($links));
            // }
            // print_r($allData);

            if (!in_array($url, $allData['links'] ?? [])) {
                 // Use the services class to get the response object
            $response = Services::response();

            // Return 403 Forbidden response
            return $response->setStatusCode(403)
                             ->setBody('Forbidden. You do not have access to this resource.');
            }
            $session = session();
            $session->setFlashdata('allData', (object) $allData);
        }
    }

    private function getUserLinks($roles)
    {
        $db = \Config\Database::connect();
        $builder = $db->table('role_links');
        $builder->select('link')->whereIn('role_id', $roles);
        $result = $builder->get()->getResultArray();

        return array_column($result, 'link');
    }
    
    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Your code here...
    }


}

