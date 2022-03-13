<?php declare(strict_types=1);

namespace App\Controllers;

use App\Core\App;

class PageController
{
    private App $app;
    private array $user;

    public function __construct(App $app)
    {
        $this->app = $app;
        $this->user = $_SESSION['user'];
    }

    /**
     * @return mixed
     * @throws \Exception
     */
    public function index()
    {
        $words = $this->app::get('database')
            ->selectAll(
                'words',
                (int) $this->user['id'],
                'desc'
            );

        /**********************************
         * returning json for rest api call
         *  return response($words, 200);
         */

        return view('index', compact('words'));
    }
}