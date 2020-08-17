<section class="panel">
    <header class="panel-heading well">
        @if(isset($agentLevelItem) )
              ویرایش سطح نمایندگی
        @else
            ایجاد سطح جدید
        @endif

    </header>
    <form action="{{ isset($agentLevelItem) ? route("admin.agentLevel.update",$agentLevelItem) : route('admin.agentLevel.store') }}"
          method="post"  enctype="multipart/form-data"  class="" style="border: 1px solid #dcdbdd;padding: 20px;border-radius: 6px">
        {{ csrf_field() }}
        <div class="form-group">
            <input type="text" name="title"
                   id="title" class="form-control"
                   value="{{ isset($agentLevelItem) ? $agentLevelItem->title : old('title','') }}"
                   placeholder="عنوان">
        </div>
        <div class="form-group">
            <input type="number" name="price"
                   id="price" class="form-control"
                   value="{{ isset($agentLevelItem) ? $agentLevelItem->price*10 : old('price','') }}"
                   placeholder="قیمت به ریال">
        </div>

        <div class="input-group m-bot15">
            <span class="input-group-addon">%</span>
            <input type="number" name="mabino_percent"
                   value="{{ isset($agentLevelItem) ? $agentLevelItem->mabino_percent : old('mabino_percent','') }}"
                   class="form-control" placeholder="درصد مابینو">
        </div>



        <div class="input-group m-bot15">
            <span class="input-group-addon">%</span>
            <input type="number" name="agent_percent"
                   value="{{ isset($agentLevelItem) ? $agentLevelItem->my_percent : old('agent_percent','') }}"
                   class="form-control" placeholder="درصد نمایندگی">
        </div>

        <div class="input-group m-bot15">
            <span class="input-group-addon">%</span>
            <input type="number" name="admin_percent"
                   value="{{ isset($agentLevelItem) ? $agentLevelItem->pageowner_percent : old('admin_percent','') }}"
                   class="form-control" placeholder="درصد ادمین">
        </div>
        
        <div class="form-group">
            <input type="file" name="image"
                   id="image">
        </div>
        
        @if(isset($agentLevelItem) and  !is_null($agentLevelItem->image))
            <img src="{{  config('UploadPath.agent_level_path').$agentLevelItem->image }}" width="100"/>
        @endif

        <div class="form-group">
            @if(isset($agentLevelItem))
                <button type="submit" class="btn btn-warning">ویرایش</button>
            @else
                <button type="submit" class="btn btn-primary">ثبت</button>
            @endif
        </div>
    </form>
</section>