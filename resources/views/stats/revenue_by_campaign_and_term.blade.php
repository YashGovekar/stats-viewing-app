@extends('welcome')

@section('content')
    <div class="flex justify-between items-center my-4 gap-4 w-full sm:w-2/4">
        <div>
            <a class="px-3 py-2 bg-red-500 rounded-xl text-white font-bold" href="{{ route('campaign', $campaign) }}">
                &larr; Back to <span class="underline underline-offset-3">{{ $campaign->utm_campaign }}</span> Campaign
            </a>
        </div>
        <h2 class="font-bold text-2xl underline self-center underline-offset-3 text-white">
            Revenue by Publisher for Campaign: {{ $campaign->utm_campaign }}
        </h2>
    </div>
    <table class="mt-3 w-full md:w-2/4 leading-normal">
        <thead>
            <tr>
                <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Publisher</th>
                <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Total Revenue</th>
            </tr>
        </thead>
        <tbody>
        @foreach($data->items() as $row)
            <tr class="text-gray-900">
                <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">{{ $row->term?->utm_term }}</td>
                <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">{{ $row->total_revenue }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
    <div class="my-4">
        {{ $data->links() }}
    </div>
@endsection
