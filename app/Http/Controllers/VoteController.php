<?php

namespace App\Http\Controllers;

use App\Models\Voter;
use App\Models\Resource;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;

class VoteController extends Controller
{
    public function __invoke(Request $request, Resource $resource)
    {
        
        $voter = Voter::getOrCreateVoter($request);

        $resource->votes()->toggle($voter->id);
        
        return $resource->load('votes', 'category');

    }
}
