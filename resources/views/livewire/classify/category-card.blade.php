<li data-bs-toggle="modal" data-bs-target="#modal-category-{{ $category->id }}">
    <a href="#">
        {{ $category->name }}
        <span class="text-muted">{!! formatVND($category->money) !!}</span>
    </a>
</li>
