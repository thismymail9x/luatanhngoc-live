<?php
namespace App\Filters;

use App\Models\Base;
use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

class MyAuth implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        $base_model = new Base();
        $session_data = $base_model->get_ses_login();

        if (empty($session_data)) {
            return redirect()->to(base_url());
        }
		// Do any thing for authentication
    }
    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Do something here
    }
}