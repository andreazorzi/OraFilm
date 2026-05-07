<div class="col-md-12">
    <label>Status</label>
    <select class="selectize" multiple name="advanced_search[status][]">
        @foreach (["Attivo", "Disattivo"] as $status)
            <option value="{{Str::lower($status)}}">{{$status}}</option>
        @endforeach
    </select>
</div>
<div class="col-md-12">
    <label>Tipo</label>
    <select class="selectize" multiple name="advanced_search[type][]">
        @foreach (User::groupBy("type")->pluck("type")->toArray() as $type)
            <option>{{$type}}</option>
        @endforeach
    </select>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        $(".selectize").selectize({
            plugins: ["remove_button"],
            onChange: function(value) {
                $("#page").val(1);
                htmx.trigger("#page", "change");
            },
            onDropdownOpen: function() {
                for (const select of $(".selectize.selectized")) {
                    if(select !== this.$input[0]){
                        select.selectize.close();
                    }
                }
            }
        });
    });
</script>