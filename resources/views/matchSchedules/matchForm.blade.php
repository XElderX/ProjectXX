@extends('layouts.app')

@section('content')

<style>
    .mainItem, .secondary-item {
        width: 100%;
        padding: 15px;
        border: 1px solid #ccc;
    }

    .comparison-container {
        display: flex;
        justify-content: space-around;
        align-items: center;
        align-content: center;
    }

    .custom-dropdown {
        position: relative;
        width: 200px;
    }

    .dropdown-select {
        background-color: #fff;
        border: 1px solid #ccc;
        padding: 8px;
        cursor: pointer;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .dropdown-options {
        display: none;
        position: absolute;
        top: 100%;
        left: 0;
        width: 100%;
        background-color: #fff;
        border: 1px solid #ccc;
        max-height: 150px;
        overflow-y: auto;
        z-index: 1;
    }

    .dropdown-option {
        padding: 8px;
        cursor: pointer;
    }

    .dropdown-option.disabled {
        background-color: #e0e0e0;
        pointer-events: none;
    }
</style>

<div class="main">
    <div class="mainItem">
        @if ($errors->any())
            <div class="alert alert-danger">
                <p><strong>Oops! Something went wrong</strong></p>
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
            <h3>Match Orders</h3>
            <p>
                {{ optional($schedule->homeTeam)->club_name }} vs {{ optional($schedule->awayTeam)->club_name }}
            </p>
        </div>

        <h5>Set Lineup</h5>
        <form action="{{ route('postLineup', [$schedule->id]) }}" method="POST">
            @csrf
            <table>
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Player</th>
                        <th>Position</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $lineupMap = collect($lineupData)->keyBy('pos_no');
                    @endphp

                    @for ($i = 0; $i < 11; $i++)
                        @php
                            $savedPlayer = $lineupMap[$i]['player_id'] ?? null;
                            $savedPosition = $lineupMap[$i]['position'] ?? null;
                        @endphp
                        <tr data-row="{{ $i }}">
                            <td>{{ $i + 1 }}</td>
                            <td>
                                <div class="custom-dropdown">
                                    <div class="dropdown-select player-select" data-row="{{ $i }}">
                                        <span class="dropdown-placeholder">
                                            @if($savedPlayer)
                                                {{ optional($options->firstWhere('id', $savedPlayer))->first_name }} 
                                                {{ optional($options->firstWhere('id', $savedPlayer))->last_name }}
                                            @else
                                                -- Select Player --
                                            @endif
                                        </span>
                                        <div class="dropdown-arrow">&#x25BC;</div>
                                    </div>
                                    <ul class="dropdown-options">
                                        @foreach ($options as $option)
                                            <li 
                                                class="dropdown-option"
                                                data-skills='@json($option)'
                                                data-player-id="{{ $option->id }}"
                                                {{ $savedPlayer == $option->id ? 'class=selected' : '' }}
                                                {{ in_array($option->id, $lineupMap->pluck('player_id')->toArray()) ? 'class="disabled"' : '' }}>
                                                {{ $option->first_name }} {{ $option->last_name }}
                                            </li>
                                        @endforeach
                                    </ul>
                                    <input type="hidden" name="players[]" class="selected-player" value="{{ $savedPlayer }}">
                                </div>
                            </td>
                            <td>
                                <select class="select-position form-control" name="positions[]" data-row="{{ $i }}">
                                    <option value="">-- Select Position --</option>
                                    @foreach ($positions as $position)
                                        <option value="{{ $position }}" 
                                            {{ $savedPosition == $position ? 'selected' : '' }}>
                                            {{ $position }}
                                        </option>
                                    @endforeach
                                </select>
                            </td>
                        </tr>
                    @endfor
                </tbody>
            </table>
            <button type="submit" class="btn btn-primary mt-3">Submit</button>
        </form>
    </div>

    <div class="secondary-item">
        <div class="comparison-container">

            <div class="player-info" id="selected-player-info">
            <h4>Selected Player</h4>
            <p><strong>Name:</strong> <span id="selected-player-name">--</span></p>
            <p><strong>Position:</strong> <span id="selected-player-position">--</span></p>
            <h5>Skills</h5>
            <p><strong>Goalkeeping:</strong> <span id="selected-player-gk">0</span></p>
            <p><strong>Defending:</strong> <span id="selected-player-def">0</span></p>
            <p><strong>Playmaking:</strong> <span id="selected-player-pm">0</span></p>
            <p><strong>Pace:</strong> <span id="selected-player-pace">0</span></p>
            <p><strong>Technique:</strong> <span id="selected-player-technique">0</span></p>
            <p><strong>Passing:</strong> <span id="selected-player-passing">0</span></p>
            <p><strong>Heading:</strong> <span id="selected-player-heading">0</span></p>
            <p><strong>Striker:</strong> <span id="selected-player-striker">0</span></p>
        </div>

        <!-- Comparison Player's Skills -->
        <div class="player-info" id="comparison-player-info">
            <h4>Comparison Player</h4>
            <p><strong>Name:</strong> <span id="comparison-player-name">--</span></p>
            <p><strong>Position:</strong> <span id="comparison-player-position">--</span></p>
            <h5>Skills</h5>
            <p><strong>Goalkeeping:</strong> <span id="comparison-player-gk">0</span></p>
            <p><strong>Defending:</strong> <span id="comparison-player-def">0</span></p>
            <p><strong>Playmaking:</strong> <span id="comparison-player-pm">0</span></p>
            <p><strong>Pace:</strong> <span id="comparison-player-pace">0</span></p>
            <p><strong>Technique:</strong> <span id="comparison-player-technique">0</span></p>
            <p><strong>Passing:</strong> <span id="comparison-player-passing">0</span></p>
            <p><strong>Heading:</strong> <span id="comparison-player-heading">0</span></p>
            <p><strong>Striker:</strong> <span id="comparison-player-striker">0</span></p>
        </div>
    </div>
</div>

<script>
document.querySelectorAll('.player-select').forEach(select => {
    select.addEventListener('click', function () {
        const dropdown = this.nextElementSibling;
        dropdown.style.display = dropdown.style.display === 'block' ? 'none' : 'block';
    });
});

document.querySelectorAll('.dropdown-option').forEach(option => {
    option.addEventListener('click', function () {
        const selectedPlayerId = this.getAttribute('data-player-id');
        const selectedPlayerName = this.innerText;
        const skills = JSON.parse(this.getAttribute('data-skills') || '{}');

        const dropdown = this.closest('.custom-dropdown');
        const hiddenInput = dropdown.querySelector('.selected-player');
        const row = dropdown.closest('tr');
        const rowIndex = row.getAttribute('data-row');

        hiddenInput.value = selectedPlayerId;
        dropdown.querySelector('.dropdown-placeholder').innerText = selectedPlayerName;

        // Update selected player stats
        document.getElementById('selected-player-name').innerText = selectedPlayerName;
        document.getElementById('selected-player-position').innerText = skills.position || '--';
        document.getElementById('selected-player-gk').innerText = skills.gk || '0';
        document.getElementById('selected-player-def').innerText = skills.def || '0';
        document.getElementById('selected-player-pm').innerText = skills.pm || '0';
        document.getElementById('selected-player-pace').innerText = skills.pace || '0';
        document.getElementById('selected-player-technique').innerText = skills.tech || '0';
        document.getElementById('selected-player-passing').innerText = skills.pass || '0';
        document.getElementById('selected-player-heading').innerText = skills.heading || '0';
        document.getElementById('selected-player-striker').innerText = skills.str || '0';

        dropdown.querySelector('.dropdown-options').style.display = 'none';
    });

    option.addEventListener('mouseover', function () {
        const skills = JSON.parse(this.getAttribute('data-skills') || '{}');
        document.getElementById('comparison-player-name').innerText = this.innerText;
        document.getElementById('comparison-player-position').innerText = skills.position || '--';
        document.getElementById('comparison-player-gk').innerText = skills.gk || '0';
        document.getElementById('comparison-player-def').innerText = skills.def || '0';
        document.getElementById('comparison-player-pm').innerText = skills.pm || '0';
        document.getElementById('comparison-player-pace').innerText = skills.pace || '0';
        document.getElementById('comparison-player-technique').innerText = skills.tech || '0';
        document.getElementById('comparison-player-passing').innerText = skills.pass || '0';
        document.getElementById('comparison-player-heading').innerText = skills.heading || '0';
        document.getElementById('comparison-player-striker').innerText = skills.str || '0';
    });
});

document.addEventListener('click', function (e) {
    if (!e.target.closest('.custom-dropdown')) {
        document.querySelectorAll('.dropdown-options').forEach(dropdown => {
            dropdown.style.display = 'none';
        });
    }
});

</script>

@endsection
