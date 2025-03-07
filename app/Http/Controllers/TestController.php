<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TestController extends FrontendController 
{
    public function testMailchimp()
    {
        $apiKey = config('newsletter.apiKey');
        $listId = config('newsletter.lists.Kitabbhandaar.id');

        return response()->json([
            'apiKey' => $apiKey,
            'listId' => $listId,
        ]);
    }
}