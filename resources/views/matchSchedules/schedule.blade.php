@extends('layouts.app')
@section('content')
    <div class='main'>
        <div class='mainItem'>
            @if ($errors->any())
                <div class="alert alert-danger">
                    <p><strong>Opps Something went wrong</strong></p>
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @elseif(session()->has('status_success'))
                <div class="alert alert-success">
                    {{ session()->get('status_success') }}
                </div>
            @endif

            <div class="title">
                <h3>Fixtures</h3>
            </div>
            <table>
                <tr>
                    <th>Date</th>
                    <th>Teams</th>
                    <th>Match Type</th>
                    <th>Match Report</th>
                    <th>Actions</th>
                </tr>
            <div>
                @foreach ($schedules as $schedule)
                    <tr>
                        <td>{{$schedule->match_date}} </td>
                        <td>
                        @if (!is_null($schedule->homeTeam))
                            {{ $schedule->homeTeam->club_name }}
                        @endif vs  
                        @if (!is_null($schedule->awayTeam))
                        {{ $schedule->awayTeam->club_name }}
                        @endif
                        </td>
                        <td>{{ $schedule->type }}</td>
                        <td>
                           <button type="button" class="button">
                                <a href="{{ route('matchReport', [$schedule->id]) }}"
                                    class="text-sm text-gray-700 dark:text-gray-500">Match Centre</a>
                            </button></td>
                        <td>
                            @if ($schedule->status === 'pending')
                            <button type="button" class="button">
                            <a href="{{ route('matchOrders', [$schedule->id]) }}"
                                class="text-sm text-gray-700 dark:text-gray-500">Set Match Orders</a>
                        </button>
                            @endif    
                    </td></td>
                    </tr>
                @endforeach
            </table>
        </div>
    </div>
@endsection
