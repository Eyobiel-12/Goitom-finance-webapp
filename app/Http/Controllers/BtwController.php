<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\BtwAangifte;
use App\Models\BtwAftrek;
use Illuminate\Http\Request;
use Illuminate\View\View;

final class BtwController extends Controller
{
    public function index(Request $request): View
    {
        $organizationId = auth()->user()->organization_id;
        
        // BTW Aftrek stats
        $aftrekStats = [
            'total' => BtwAftrek::forOrganization($organizationId)->sum('btw_bedrag'),
            'count' => BtwAftrek::forOrganization($organizationId)->count(),
        ];
        
        $recentAftrek = BtwAftrek::forOrganization($organizationId)
            ->orderBy('datum', 'desc')
            ->limit(3)
            ->get();
        
        // BTW Aangifte stats
        $aangifteStats = [
            'this_year' => BtwAangifte::forOrganization($organizationId)
                ->where('jaar', now()->year)
                ->sum('btw_afdracht') - BtwAangifte::forOrganization($organizationId)
                ->where('jaar', now()->year)
                ->sum('btw_terug'),
        ];
        
        $recentAangifte = BtwAangifte::forOrganization($organizationId)
            ->orderBy('created_at', 'desc')
            ->limit(3)
            ->get();
        
        return view('app.btw.index', compact('aftrekStats', 'recentAftrek', 'aangifteStats', 'recentAangifte'));
    }
}

