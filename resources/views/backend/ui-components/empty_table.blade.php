<tr class="odd">
    <td valign="top" colspan="{{ @$colspan }}" class="dataTables_empty">
        <div class="no-data-found-wrapper text-center mt-40">
            <img src=" {{ @showImage(setting('empty_table'), 'backend/assets/images/no-data.png') }}" alt="img" class="mb-primary empty_table" width="100">
            <p class="m-3 text-center text-secondary font-size-90">
                {{ @$message }}</p>
        </div>
    </td>
</tr>
