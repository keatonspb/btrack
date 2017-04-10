<ul class="instruments">
    <li class="lead_guitar @if($track->lead) active @endif" title="lead guitar"></li>
    <li class="rhythm_guitar @if($track->rhythm) active @endif" title="rhythm guitar"></li>
    <li class="bass @if($track->bass) active @endif" title="bass guitar"></li>
    <li class="voice @if($track->vocals) active @endif" title="vocals"></li>
    <li class="drums @if($track->drums) active @endif" title="drums"></li>
    <li class="keys @if($track->keys) active @endif" title="keys"></li>
</ul>