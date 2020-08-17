@if($agentRequest->status == \App\Models\AgentRequest::ACCEPTED)
    {{--<span id="ad_{{$agentRequest->id}}" class="ad_{{$agentRequest->id}} label label-success label-mini" onclick="change_state('{{$agentRequest->id}}')">فعال</span>--}}
    <div class="switch-toggle switch-3 switch-candy">
        <input id="on-{{ $agentRequest->id }}" name="state-{{ $agentRequest->id }}"  type="radio" checked="checked" />
        <label for="on-{{ $agentRequest->id }}" onclick="change_state('{{$agentRequest->id}}')">تایید</label>

        <input id="na-{{ $agentRequest->id }}" name="state-{{ $agentRequest->id }}" type="radio" disabled  />
        <label for="na-{{ $agentRequest->id }}" class="disabled" onclick="">&nbsp;</label>

        <input id="off-{{ $agentRequest->id }}" name="state-{{ $agentRequest->id }}" type="radio" />
        <label for="off-{{ $agentRequest->id }}" onclick="change_state_off('{{$agentRequest->id}}')">رد</label>

        <a></a>
    </div>
@elseif($agentRequest->status == \App\Models\AgentRequest::FAILED)
    <div class="switch-toggle switch-3 switch-candy">
        <input id="on-{{ $agentRequest->id }}" name="state-{{ $agentRequest->id }}"  type="radio"/>
        <label for="on-{{ $agentRequest->id }}" onclick="change_state('{{$agentRequest->id}}')">تایید</label>

        <input id="na-{{ $agentRequest->id }}" name="state-{{ $agentRequest->id }}" type="radio" disabled  />
        <label for="na-{{ $agentRequest->id }}" class="disabled" onclick="">&nbsp;</label>

        <input id="off-{{ $agentRequest->id }}" name="state-{{ $agentRequest->id }}" type="radio" checked="checked" />
        <label for="off-{{ $agentRequest->id }}" onclick="change_state_off('{{$agentRequest->id}}')">رد</label>

        <a></a>
    </div>

@else
    <div class="switch-toggle switch-3 switch-candy">
        <input id="on-{{ $agentRequest->id }}" name="state-{{ $agentRequest->id }}"  type="radio"/>
        <label for="on-{{ $agentRequest->id }}" onclick="change_state('{{$agentRequest->id}}')">تایید</label>

        <input id="na-{{ $agentRequest->id }}" name="state-{{ $agentRequest->id }}" type="radio" disabled checked="checked"  />
        <label for="na-{{ $agentRequest->id }}" class="disabled" onclick="">&nbsp;</label>

        <input id="off-{{ $agentRequest->id }}" name="state-{{ $agentRequest->id }}" type="radio"  />
        <label for="off-{{ $agentRequest->id }}" onclick="change_state_off('{{$agentRequest->id}}')">رد</label>
        <a></a>

    </div>
@endif
