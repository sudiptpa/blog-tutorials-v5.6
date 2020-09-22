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
        $parameters['q'] = $this->request->get('query');

        $api_key = config('services.auspost.api_key');

        if (empty($api_key)) {
            return [];
        }

        $response = with(new Auspost($api_key))->locality($parameters);

        if ($response && $response->isSuccessful()) {
            $result = $response->toArray();

            $localities = collect($result['localities']['locality'] ?? []);

            if ($localities->count()) {
                $collection = is_array($localities->first()) ? $localities : [$localities];

                return response()->json($collection);
            }
        }

        return [];
    }
}
