<div class="align-self-center">
    <label>
        <span class="mr-8">{{ ___('cms.Type') }}</span>
        <select class="form-select d-inline-block show_type">
            <option value="web" @if(request()->input('type') == 'web')   {{'selected'}} @endif>{{___('cms.web')}}</option>
            <option value="api" @if(request()->input('type') == 'api')   {{'selected'}} @endif>{{___('cms.api')}}</option>
        </select>
    </label>
</div>
