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
                <h3>Match Orders</h3>
                <p>
                    @if ($schedule->homeTeam->isNotEmpty())
                        {{ $schedule->homeTeam[0]->club_name }}
                    @endif vs
                    @if ($schedule->awayTeam->isNotEmpty())
                        {{ $schedule->awayTeam[0]->club_name }}
                    @endif
                </p>
            </div>
            <h5>Set Lineup</h5>
            <div>
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
                            @for ($i = 1; $i <= 11; $i++)
                                @if ($i === 1)
                                    <tr>
                                        <td>{{ $i }}</td>
                                        <td>
                                            <select class="select-option" name="players[]">
                                                <option value=""></option> <!-- Empty default option -->
                                                @foreach ($options as $option)
                                                    <option value="{{ $option->id }}">{{ $option->first_name }}
                                                        {{ $option->last_name }}</option>
                                                @endforeach
                                            </select>
                                        </td>
                                        <td>
                                            <select name="positions[]">
                                                <option value="GK">GK</option>
                                            </select>
                                        </td>
                                    </tr>
                                @else
                                    <tr>
                                        <td>{{ $i }}</td>
                                        <td>
                                            <select class="select-option" name="players[]">
                                                <option value=""></option> <!-- Empty default option -->
                                                @foreach ($options as $option)
                                                    <option value="{{ $option->id }}">{{ $option->first_name }}
                                                        {{ $option->last_name }}</option>
                                                @endforeach
                                            </select>
                                        </td>
                                        <td>
                                            <select class="select-position" name="positions[]"
                                                data-row="{{ $i }}">
                                                @foreach ($positions as $position)
                                                    <option value=""></option> <!-- Empty default option -->
                                                    <option value="{{ $position }}">{{ $position }}</option>
                                                @endforeach
                                            </select>
                                        </td>
                                    </tr>
                                @endif
                            @endfor
                        </tbody>
                    </table>
                    <button type="submit">Submit</button>
                  </form>

                    <script>
                        const selectOptions = document.querySelectorAll('.select-option');
                        selectOptions.forEach(select => {
                            select.addEventListener('change', function() {
                                const selectedOption = this.value;
                                selectOptions.forEach(otherSelect => {
                                    if (otherSelect !== this && otherSelect.value === selectedOption) {
                                        otherSelect.value = '';
                                    }
                                });
                            });
                        });
                    </script>

                    <script>
                        const selectPositions = document.querySelectorAll('.select-position');
                        selectPositions.forEach(select => {
                            select.addEventListener('change', function() {
                                const selectedPosition = this.value;
                                const selectedRow = this.dataset.row;
                                const positionCount = {};

                                selectPositions.forEach(otherSelect => {
                                    if (otherSelect !== this) {
                                        const value = otherSelect.value;
                                        const row = otherSelect.dataset.row;

                                        if (value !== '') {
                                            if (positionCount[value]) {
                                                positionCount[value].push(row);
                                            } else {
                                                positionCount[value] = [row];
                                            }
                                        }
                                    }
                                });

                                if (selectedPosition !== '') {
                                    if (positionCount[selectedPosition] && positionCount[selectedPosition].length >
                                        getPositionLimit(selectedPosition)) {
                                        this.value = '';
                                    } else {
                                        this.style.backgroundColor = 'white';
                                    }
                                }

                                selectPositions.forEach(otherSelect => {
                                    if (otherSelect !== this && otherSelect.value === '') {
                                        const row = otherSelect.dataset.row;
                                    }
                                });
                            });
                        });

                        function getPositionLimit(position) {
                            switch (position) {
                                case 'DEF':
                                    return 4;
                                case 'MID':
                                    return 5;
                                case 'FOW':
                                    return 2;
                                default:
                                    return 0;
                            }
                        }

                        // Add event listener to recheck fields when position is unselected
                        selectPositions.forEach(select => {
                            select.addEventListener('change', function() {
                                if (this.value === '') {
                                    const selectedRow = this.dataset.row;
                                    const positionCount = {};

                                    selectPositions.forEach(otherSelect => {
                                        if (otherSelect !== this) {
                                            const value = otherSelect.value;
                                            const row = otherSelect.dataset.row;

                                            if (value !== '') {
                                                if (positionCount[value]) {
                                                    positionCount[value].push(row);
                                                } else {
                                                    positionCount[value] = [row];
                                                }
                                            }
                                        }
                                    });

                                    selectPositions.forEach(otherSelect => {
                                        if (otherSelect.value === '') {
                                            const row = otherSelect.dataset.row;
                                            const position = otherSelect.value;

                                            if (positionCount[position] && positionCount[position].includes(row)) {
                                                otherSelect.style.backgroundColor = 'red';
                                            } else {
                                                otherSelect.style.backgroundColor = 'white';
                                            }
                                        }
                                    });
                                }
                            });
                        });
                    </script>
            @endsection
