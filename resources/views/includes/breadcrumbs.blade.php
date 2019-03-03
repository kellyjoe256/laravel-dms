
<ol class="breadcrumb">

    @php($count = 1)

    @foreach (get_breadcrumbs() as $breadcrumb => $link)

    <li>
        <a href="{{ $link }}">
            @if ($count == 1)
            <i class="fa fa-dashboard"></i>
            @endif 
            {{ beautify_input($breadcrumb) }}
        </a>
    </li>

    @php($count += 1)

    @endforeach
    
    <li class="active">{{ strip_tags($title) }}</li>
</ol>
