<?php

namespace App\Http\Controllers;

use App\Models\Campaign;
use App\Models\Stat;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\DB;

class CampaignController extends Controller
{
    /**
     * Display list of campaigns and aggregate revenue for each campaign
     *
     * @return View
     */
    public function index(): View
    {
        $campaigns = Campaign::withSum('stats', 'revenue')
            ->paginate(10);

        return view('stats.revenue_by_campaign', compact('campaigns'));
    }

    /**
     * Display a specific campaign with a hourly breakdown of all revenue
     *
     * @param Campaign $campaign
     * @return View
     */
    public function show(Campaign $campaign): View
    {
        $data = Stat::where('campaign_id', $campaign->id)
            ->select(DB::raw('DATE_FORMAT(event_time, "%Y-%m-%d %H:00:00") as hourly'), DB::raw('SUM(revenue) as total_revenue'))
            ->groupBy('hourly')
            ->paginate(10);

        return view('stats.revenue_by_campaign_and_hour', compact('data', 'campaign'));
    }

    /**
     * Display a specific campaign with the aggregate revenue by utm_term
     *
     * @param Campaign $campaign
     * @return View
     */
    public function publishers(Campaign $campaign): View
    {
        $data = $campaign->stats()
            ->with('term:id,utm_term')
            ->select('term_id', DB::raw('SUM(revenue) as total_revenue'))
            ->groupBy('term_id')
            ->paginate(10);

        return view('stats.revenue_by_campaign_and_term', compact('data', 'campaign'));
    }
}
