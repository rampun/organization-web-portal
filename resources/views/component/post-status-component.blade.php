<ul class="post_status_count">
    <li>
       <a href="{{$allRoute}}" class='{{$allClass}}'>All <span class="count">({{ $allCount }})</span></a> |
    </li>

    <li>
        <a href="{{$publishRoute}}" class='{{$publishClass}}'>Publish <span class="count">({{ $publishCount }})</span></a> |
     </li>
    
     <li>
        <a href="{{$draftRoute}}" class='{{$draftClass}}'>Draft <span class="count">({{ $draftCount }})</span></a> |
     </li>

     <li>
        <a href="{{$trashRoute}}" class='{{$trashClass}}'>Trash <span class="count">({{ $trashCount }})</span></a>
     </li>
 </ul>