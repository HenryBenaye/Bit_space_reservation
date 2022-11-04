<p class="text-red-600">
    @if($errors->any())
        {{ implode('', $errors->all(':message')) }}
    @endif
</p>
