@extends('welcome')

@section('content')
    <div class="flex items-center my-4 gap-4 justify-between w-full sm:w-2/4">
        <div>
            <a class="px-3 py-2 bg-red-500 rounded-xl text-white font-bold" href="/">&larr; Back to all campaigns</a>
        </div>
        <h2 class="font-bold text-2xl underline underline-offset-3 text-white">Revenue by Hour for Campaign: {{ $campaign->utm_campaign }}</h2>
        <a class="px-3 py-2 bg-green-500 rounded-xl text-white font-bold" href="{{ route('publishers', $campaign) }}">View by Publishers &rarr;</a>
    </div>
    <table class="mt-3 w-full md:w-2/4 leading-normal">
        <tr>
            <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Hour</th>
            <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Total Revenue</th>
        </tr>
        @foreach($data as $row)
            <tr class="text-gray-900">
                <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">{{ $row->hourly }}</td>
                <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">{{ $row->total_revenue }}</td>
            </tr>
        @endforeach
    </table>
    <div class="my-4">
        {{ $data->links() }}
    </div>
@endsection
