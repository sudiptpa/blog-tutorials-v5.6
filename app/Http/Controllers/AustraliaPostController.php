<?php

namespace App\Http\Controllers;

use App\Auspost\Request as Auspost;
use Illuminate\Http\Request;

/**
 * Class AustraliaPostController
 * @package App\Http\Controllers
 */
class AustraliaPostController extends Controller
{
    /**
     * @param Request $request
     */
    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    /**
     * Australia Post API search form.
     *
     * @return mixed
     */
    public function index()
    {
        return view('auspost.search');
    }

    /**
     * @return array
     */
    public function search()
    {
        $parameters = [
            'q' => $this->request->get('query'),
        ];

        $response = with(new Auspost(config('auspost.auth_key')))
            ->send($parameters);

        $localities = collect($response['localities']['locality'] ?? []);

        if ($localities->count()) {
            $collection = is_array($localities->first()) ? $localities : [$localities];

            return response()->json($collection);
        }

        return [];
    }
}
