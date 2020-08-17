@if($ad->status == \App\Models\Ad::OK)
    {{--<span id="ad_{{$ad->id}}" class="ad_{{$ad->id}} label label-success label-mini" onclick="change_state('{{$ad->id}}')">فعال</span>--}}
    <div class="switch-toggle switch-3 switch-candy">
        <input id="on-{{ $ad->id }}" name="state-{{ $ad->id }}"  type="radio" checked="checked" />
        <label for="on-{{ $ad->id }}" onclick="change_state('{{$ad->id}}')">تایید</label>

        <input id="na-{{ $ad->id }}" name="state-{{ $ad->id }}" type="radio" disabled  />
        <label for="na-{{ $ad->id }}" class="disabled" onclick="">&nbsp;</label>

        <input id="off-{{ $ad->id }}" name="state-{{ $ad->id }}" type="radio" />
        <label for="off-{{ $ad->id }}" onclick="change_state_off('{{$ad->id}}')">رد</label>

        <a></a>
    </div>
@elseif($ad->status == \App\Models\Ad::FAILED)
    <div class="switch-toggle switch-3 switch-candy">
        <input id="on-{{ $ad->id }}" name="state-{{ $ad->id }}"  type="radio"/>
        <label for="on-{{ $ad->id }}" onclick="change_state('{{$ad->id}}')">تایید</label>

        <input id="na-{{ $ad->id }}" name="state-{{ $ad->id }}" type="radio" disabled  />
        <label for="na-{{ $ad->id }}" class="disabled" onclick="">&nbsp;</label>

        <input id="off-{{ $ad->id }}" name="state-{{ $ad->id }}" type="radio" checked="checked" />
        <label for="off-{{ $ad->id }}" onclick="change_state_off('{{$ad->id}}')">رد</label>

        <a></a>
    </div>

@else
    <div class="switch-toggle switch-3 switch-candy">
        <input id="on-{{ $ad->id }}" name="state-{{ $ad->id }}"  type="radio"/>
        <label for="on-{{ $ad->id }}" onclick="change_state('{{$ad->id}}')">تایید</label>

        <input id="na-{{ $ad->id }}" name="state-{{ $ad->id }}" type="radio" disabled checked="checked"  />
        <label for="na-{{ $ad->id }}" class="disabled" onclick="">&nbsp;</label>

        <input id="off-{{ $ad->id }}" name="state-{{ $ad->id }}" type="radio"  />
        <label for="off-{{ $ad->id }}" onclick="change_state_off('{{$ad->id}}')">رد</label>

        <a></a>
    </div>
@endif
