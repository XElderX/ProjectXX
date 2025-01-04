@props([
    'options',
])

<select {{ $attributes->merge(['class' => 'block font-medium text-sm text-gray-700']) }}>
    @foreach($options as $value )
        <option value="{{ $value->id }}" isSelected($value)>{{ $value->country}}</option>
    @endforeach
</select>