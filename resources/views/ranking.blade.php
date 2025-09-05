@extends('layouts.app')

@section('content')
    <div class="max-w-4xl mx-auto p-4 mt-8">
        <div class="flex items-center justify-between mb-4">
            <h1 class="text-2xl font-bold text-gray-800 dark:text-gray-100">Current rankings</h1>
            <a href="/" class="text-blue-500 hover:text-blue-600">← Back to dilemmas</a>
        </div>
        <div class="overflow-x-auto rounded-lg shadow">
            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                <thead class="bg-gray-50 dark:bg-gray-800">
                <tr>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider dark:text-gray-300">
                        Dilemma 1
                    </th>
                    <th scope="col" class="px-6 py-3 text-center text-xs font-semibold text-gray-600 uppercase tracking-wider dark:text-gray-300">
                        Votes
                    </th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider dark:text-gray-300">
                        Dilemma 2
                    </th>
                    <th scope="col" class="px-6 py-3 text-center text-xs font-semibold text-gray-600 uppercase tracking-wider dark:text-gray-300">
                        Votes
                    </th>
                </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-100 dark:bg-gray-900 dark:divide-gray-800">
                @foreach ($rankings as $ranking)
                    @php
                        $total = $ranking->first_dilemma_votes + $ranking->second_dilemma_votes;
                        $p1 = $total > 0 ? round(($ranking->first_dilemma_votes / $total) * 100) : 0;
                        $p2 = 100 - $p1;
                        $firstWins = $ranking->first_dilemma_votes > $ranking->second_dilemma_votes;
                        $secondWins = $ranking->second_dilemma_votes > $ranking->first_dilemma_votes;
                    @endphp
                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-800">
                        <td class="px-6 py-3 align-top">
                            <a href="{{ route('dilemma', ['hash' => $ranking->hash]) }}"
                               class="block font-medium text-gray-900 dark:text-gray-100 truncate max-w-[36rem]"
                               title="{{ $ranking->firstDilemma->title }}">
                                {{ $ranking->firstDilemma->title }}
                            </a>
                            <div class="mt-1 h-2 w-full bg-gray-100 dark:bg-gray-700 rounded overflow-hidden">
                                <div class="h-full bg-green-400" style="width: {{ $p1 }}%"></div>
                            </div>
                        </td>
                        <td class="px-6 py-3 text-center align-top">
                            <div class="inline-flex flex-col items-center text-sm">
                                <span class="font-semibold {{ $firstWins ? 'text-green-600 dark:text-green-400' : 'text-gray-600 dark:text-gray-300' }}">{{ $ranking->first_dilemma_votes }}</span>
                                <span class="text-xs text-gray-500">{{ $p1 }}%</span>
                            </div>
                        </td>
                        <td class="px-6 py-3 align-top">
                            <a href="{{ route('dilemma', ['hash' => $ranking->hash]) }}"
                               class="block font-medium text-gray-900 dark:text-gray-100 truncate max-w-[36rem]"
                               title="{{ $ranking->secondDilemma->title }}">
                                {{ $ranking->secondDilemma->title }}
                            </a>
                            <div class="mt-1 h-2 w-full bg-gray-100 dark:bg-gray-700 rounded overflow-hidden">
                                <div class="h-full bg-green-400" style="width: {{ $p2 }}%"></div>
                            </div>
                        </td>
                        <td class="px-6 py-3 text-center align-top">
                            <div class="inline-flex flex-col items-center text-sm">
                                <span class="font-semibold {{ $secondWins ? 'text-green-600 dark:text-green-400' : 'text-gray-600 dark:text-gray-300' }}">{{ $ranking->second_dilemma_votes }}</span>
                                <span class="text-xs text-gray-500">{{ $p2 }}%</span>
                            </div>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
