<div class="align-self-center">
    <label>
        <span class="mr-8">{{ ___('common.show') }}</span>
        <select class="form-select select2 d-inline-block ajax_show_more">
            <option value="10" {{ @$_GET['show'] == '10' ? 'selected' : '' }}>{{ ___("number.10")}}</option>
            <option value="25" {{ @$_GET['show'] == '25' ? 'selected' : '' }}>{{ ___("number.25")}}</option>
            <option value="50" {{ @$_GET['show'] == '50' ? 'selected' : '' }}>{{ ___("number.50")}}</option>
            <option value="100" {{ @$_GET['show'] == '100' ? 'selected' : '' }}>{{ ___("number.100")}}</option>
        </select>
        <span class="ml-8">{{ ___('common.entries') }}</span>
    </label>
</div>
