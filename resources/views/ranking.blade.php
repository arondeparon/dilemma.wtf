@extends('layouts.app')

@section('content')
    <div class="max-w-7xl  mx-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-200">
            <tr>
                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                    Dilemma 1
                </th>
                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                    Votes
                </th>
                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                    Dilemma 2
                </th>
                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                    Votes
                </th>
            </tr>
            </thead>
            <tbody class="bg-white">
            @foreach ($rankings as $ranking)
                <tr>
                    <td class="px-6 py-1 whitespace-nowrap {{ $ranking->first_dilemma_votes > $ranking->second_dilemma_votes ? 'bg-green-300' : '' }}">
                        {{ $ranking->first_dilemma }}
                    </td>
                    <td class="px-6 py-1 whitespace-nowrap text-center {{ $ranking->first_dilemma_votes > $ranking->second_dilemma_votes ? 'bg-green-300' : '' }}">
                        {{ $ranking->first_dilemma_votes }}
                    </td>
                    <td class="px-6 py-1 whitespace-nowrap {{ $ranking->second_dilemma_votes > $ranking->first_dilemma_votes ? 'bg-green-300' : '' }}">
                        {{ $ranking->second_dilemma }}
                    </td>
                    <td class="px-6 py-1 whitespace-nowrap text-center {{ $ranking->second_dilemma_votes > $ranking->first_dilemma_votes ? 'bg-green-300' : '' }}">
                        {{ $ranking->second_dilemma_votes }}
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@endsection
