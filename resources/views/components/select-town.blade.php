@props([
    'options',
])

<select {{ $attributes->merge(['class' => 'block font-medium text-sm text-gray-700']) }}>
    @foreach($options as $value => $label)
        <option value="{{ $value }}" isSelected($value)>{{ $label->town_name}}</option>
    @endforeach
</select>