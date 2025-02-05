<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

class AuthFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        
        $links = (array) session()->get('links'); // Ensure $links is always an array

        if (!session()->get('logged_in')) {
            return redirect()->to('public/auth/login');
        } else {
            $url = ltrim(str_replace(['index.php/', base_url()], '', current_url()), '/');

            if (!in_array($url, $links)) {
                return redirect()->to('/no-access');
            }
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
       
    }
}
