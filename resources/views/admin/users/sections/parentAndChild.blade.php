
<p>
    سرگروه :

    @if(!is_null($parent))
        {{ $parent->name }} - {{ $parent->mobile }}

    @else
        ندارد
    @endif
</p>

<p>
    زیرگروه ها :
</p>
<ul>
    @foreach($child as $children)
   <li>
       {{ $children->name }} - {{ $children->mobile }}
   </li>
    @endforeach
</ul>