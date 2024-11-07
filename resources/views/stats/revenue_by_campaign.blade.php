@extends('welcome')

@section('content')
    <table class="w-full md:w-2/4 leading-normal">
        <thead>
        <tr>
            <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Campaign</th>
            <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Name</th>
            <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Total Revenue</th>
        </tr>
        </thead>
        <tbody>
        @foreach($campaigns->items() as $campaign)
            <tr class="text-gray-900">
                <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                    <a class="text-red-500 underline underline-offset-2 hover:text-red-700"
                       href="{{ route('campaign', $campaign) }}">{{ $campaign->utm_campaign }}</a>
                </td>
                <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">{{ $campaign->name }}</td>
                <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">{{ $campaign->stats_sum_revenue ?? 0 }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
    <div class="my-4">
        {{ $campaigns->links() }}
    </div>
@endsection
