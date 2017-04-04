<ul class="instruments">
    <li class="lead_guitar @if($track->lead) active @endif"></li>
    <li class="rhythm_guitar @if($track->rhythm) active @endif"></li>
    <li class="bass @if($track->bass) active @endif"></li>
    <li class="voice @if($track->vocals) active @endif"></li>
    <li class="drums @if($track->drums) active @endif"></li>
    <li class="keys @if($track->keys) active @endif"></li>
</ul>