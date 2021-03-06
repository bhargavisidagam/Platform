<?php

namespace DocsPen\Http\Controllers;

use Illuminate\Http\Response;

class SitemapsController extends Controller
{
    public function index()
    {
        return response()->view('sitemaps.index')
                    ->header('Content-Type', 'text/xml');
    }

    public function books()
    {
        return response()->view('sitemaps.books')
                    ->header('Content-Type', 'text/xml');
    }

    public function pages()
    {
        return response()->view('sitemaps.pages')
                    ->header('Content-Type', 'text/xml');
    }

    public function chapters()
    {
        return response()->view('sitemaps.chapters')
                    ->header('Content-Type', 'text/xml');
    }

    public function users()
    {
        $this->checkPermission('users-manage');
        $listDetails = [
            'order'  => $request->get('order', 'asc'),
            'search' => $request->get('search', ''),
            'sort'   => $request->get('sort', 'name'),
        ];
        $users = $this->userRepo->getAllUsersPaginatedAndSorted(20, $listDetails);
        $this->setPageTitle(trans('settings.users'));
        $users->appends($listDetails);

        return response()->view('sitemaps.users', ['users' => $users])
                    ->header('Content-Type', 'text/xml');
    }
}
