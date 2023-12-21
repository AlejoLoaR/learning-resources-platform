<?php

namespace App\Http\Controllers;

use App\Models\Resource;
use App\Models\Voter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Str;

class VoteController extends Controller
{
    public function __invoke(Request $request, Resource $resource)
    {
        $voterId = $request->cookie('voter_code');
        $voter = Voter::where('code', $voterId)->first();

        if (!$voter) {
            $voter = Voter::create([
                'code' => Str::random(30),
            ]);
            Cookie::queue('voter_code', $voter->code, 60 * 24 * 30);

            $resource->votes()->toggle($voter->id);
            return $resource->load('votes', 'category');
        }

    }
}
