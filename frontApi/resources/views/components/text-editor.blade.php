@php
    $id = uniqid()
@endphp

<div
    x-data="{ data: @entangle($attributes->wire('model')) }"
    x-init="
        quill{{$id}} = new Quill($refs.editor, {  modules: {
    toolbar: toolbarOptions
  },theme: 'snow'});
        delta = quill{{$id}}.clipboard.convert(data)
        quill{{$id}}.setContents(delta, 'silent')
        quill{{$id}}.on('text-change', function () {
            data = quill{{$id}}.root.innerHTML;
        });
    "
    wire:ignore
>
    <div x-ref="editor"></div>
</div>